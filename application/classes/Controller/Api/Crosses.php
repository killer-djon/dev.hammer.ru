<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Crosses extends Controller_Rest
{
    /**
     * Set the authentication type.
     *
     * @var string
     */
    protected $_auth_type = RestUser::AUTH_TYPE_OFF;


    /**
     * MongoModel instance
     *
     * @var MongoModel
     */
    private $_model;

    /**
     * ReflectionClass
     *
     * @var ReflectionClass
     */
    private $reflection;

    /**
     * MongoId
     *
     * @var MongoId
     */
    private $_id = null;

    /**
     * Current page number
     *
     * @var integer
     */
    private $_page = 1;

    /**
     * Limit of the recors
     *
     * @var integer|string
     */
    private $_limit = 'all';

    /**
     * Current number to skip record
     *
     * @var integer
     */
    private $_skip = 0;

    /**
     * Parent document alias name
     *
     * @var string
     */
    private $_parentAlias = 'crosses';

    /**
     * Parent document getted by parenAlias
     *
     * @var mixed|array
     */
    private $_parent = null;

    /**
     * A Restexample model instance for all the business logic.
     *
     * @var Model_AuthUser
     */
    protected $_rest;

    /**
     * Initialize the example model.
     */
    public function before()
    {
        //echo '<pre>';
        parent::before();

        $this->reflection = new ReflectionClass($this->request);

        $this->_model = MongoModel::factory('HammerCrosses');
        $this->_model->selectDB();

    }

    /**
     * Запросы GET на получение данных
     * @
     */
    public function action_index()
    {
        $requestMethod = $this->request->method();
        if (in_array($requestMethod, ['GET', 'OPTIONS'])) {

        }
    }

    /**
     * Загружаем файл на сервак
     *
     * @throws Kohana_HTTP_Exception
     * @throws Kohana_Exception
     */
    public function action_upload()
    {
        try {
            $requestMethod = $this->request->method();
            if (in_array($requestMethod, ['POST', 'OPTIONS'])) {
                $countUploadFiles = [];
                $file = Validation::factory($_FILES);
                $file->rules(
                    'file',
                    [
                        [['Upload', 'valid']],
                        [['Upload', 'not_empty']],
                        ['Upload::type', [':value', ['xls', 'xlsx', 'csv']]]
                    ]
                );

                if ($file->check()) {
                    $filename = explode('.', $_FILES['file']['name']);

                    $crossFile = MongoModel::factory('CrossFile');
                    $crossFile->selectDB();

                    $crossFile->set('name', $_FILES['file']['name'])
                        ->set('size', $_FILES['file']['size'])
                        ->set('type', $_FILES['file']['type'])
                        ->set('leaf', true)
                        ->set('createdAt', new MongoDate());

                    $crossFile->save();
                    $lastDocument = $crossFile->lastDocument();
                    if ($lastDocument) {
                        $uploaded = Upload::save(
                            $_FILES['file'],
                            $lastDocument['_id']['$id'] . '.' . $filename[1],
                            DOCROOT . 'upload/',
                            0775
                        );

                        if ($uploaded) {
                            $this->rest_output([
                                'items'   => $crossFile->lastDocument(),
                                'success' => true
                            ]);

                        } else {
                            $this->rest_output([
                                'success' => false,
                                'error'   => $uploaded
                            ]);
                        }
                    }
                }
            }
        } catch (Kohana_HTTP_Exception $khe) {
            $this->_error($khe);
        } catch (Kohana_Exception $e) {
            $this->_error($e);
        }
    }


    /**
     * Получаем список файлов
     * загруженных ранее на сервак
     *
     */
    public function action_listFiles()
    {
        $crossFile = MongoModel::factory('CrossFile');
        $crossFile->selectDB();

        $items = $crossFile->find_all();
        $countItems = $crossFile->count();

        array_walk($items, function (&$item) {
            $item['createdAt'] = strftime('%Y-%m-%d %H:%M:%S', $item['createdAt']['sec']);
        });

        $this->rest_output([
            'items'      => $items,
            'pagination' => [
                'item_per_page' => ('all' != $this->_limit ? (int)$this->_limit : count($items)),
                'total_items'   => $countItems,
                'current_page'  => $this->_page
            ]
        ]);
    }

    public function action_removeFile()
    {
        $id = isset($this->_params['id']) && !is_null($this->_params['id']) ? $this->_params['id'] : null;
        if (!is_null($id)) {
            try {

                $crossFile = MongoModel::factory('CrossFile');
                $crossFile->selectDB();

                $record = $crossFile->where('_id', '=', new MongoId($id))->find();

                $filename = DOCROOT . 'upload/' . $id . '.' . File::ext_by_mime($record->get('type'));

                if (file_exists($filename)) {
                    unlink($filename);
                    $record->remove();

                    $this->rest_output([
                        'success'  => true,
                        'message'  => "Record with ID: {$id} was succefull deleted",
                        'filename' => $filename
                    ]);
                }

            } catch (Kohana_Exception $e) {
                $this->rest_output([
                    'success' => false,
                    'error'   => $e->getMessage()
                ]);
            }

        }
    }

    /**
     * АНализируем структуру файла
     * для получения и создания сапостовления колонок
     */
    public function action_fileStructure()
    {
        try {
            $id = $this->_params['file_id'];
            $crossFile = MongoModel::factory('CrossFile');
            $crossFile->selectDB();

            $record = $crossFile->where('_id', '=', new MongoId($id))->find();

            if ($record->loaded()) {
                $fileExt = File::ext_by_mime($record->get('type'));
                $filename = DOCROOT . 'upload/' . $id . '.' . $fileExt;

                if ($filename) {
                    if (in_array($fileExt, ['xlsx', 'xls'])) {

                        require DOCROOT . '/Classes/PHPExcel.php';
                        $objPHPExcel = PHPExcel_IOFactory::load($filename);
                        $worksheet = $objPHPExcel->getActiveSheet();

                        $header = [];
                        $row = $worksheet->getRowIterator();
                        foreach ($row->current()->getCellIterator() as $cell) {
                            $header[] = $cell->getValue();
                        }

                        $this->rest_output([
                            'success'  => true,
                            'headers'  => $header,
                            'filename' => $id . '.' . $fileExt
                        ]);
                    } else {
                        if ('csv' == $fileExt) {
                            // тут будем обрабатываеть csv файлы
                        }
                    }
                } else {
                    $this->rest_output([
                        'success' => false,
                        'error'   => 'File not exists with name: ' . $filename
                    ]);
                }
            }
        } catch (Kohana_HTTP_Exception $e) {
            $this->rest_output([
                'success' => false,
                'error'   => $e->getMessage(),
                'code'    => $e->getCode()
            ]);
        }
    }

    /**
     * Получаем анализированные поля
     * по которым надо выбрать все данные из файла
     */
    public function action_fileAnalyzeData()
    {
        $file_rows = json_decode($this->_params['file_rows'], true);
        $filename = $this->_params['filename'];

        $file = explode('.', $filename);
        if (empty($filename)) {
            $this->rest_output([
                'success' => false,
                'error'   => 'File extension is not set, check file in path'
            ]);
        }
        $crossFile = DOCROOT . 'upload/' . $filename;

        if (!empty($file_rows)) {
            $result = [];
            if (in_array($file[1], ['xls', 'xlsx'])) {
                require DOCROOT . '/Classes/PHPExcel.php';
                $objPHPExcel = PHPExcel_IOFactory::load($crossFile);
                $worksheet = $objPHPExcel->getActiveSheet();

                $rows = $worksheet->toArray();
                foreach ($rows as $index => $row) {
                    if ($index == 0) {
                        continue;
                    }


                    $rowItem = [];
                    foreach ($file_rows as $value) {
                        $rowName = $value['value'];
                        $rowIndex = $value['id'];

                        if (!empty($row[$rowIndex])) {
                            $rowItem[$rowName] = $row[$rowIndex];
                        }

                    }

                    $result[] = $rowItem;
                }
            } else {
                if ('csv' == $file[1]) {

                }
            }

            if (!empty($result)) {
                $insertDocuments = [];
                $crossHammer = MongoModel::factory('HammerCrosses');
                $crossHammer->selectDB();
                $crossHammer->where('file_id', '=', $file[0])->remove_all();

                foreach ($result as $rowData) {

                    $crossHammer = MongoModel::factory('HammerCrosses');
                    $crossHammer->selectDB();

                    if (!empty($rowData)) {
                        $rowData['file_id'] = $file[0];

                        $crossHammer->values($rowData);
                        $doc = $crossHammer->save();
                        $insertDocuments[] = $doc->get('_id');
                    }
                }

                if(!empty($insertDocuments))
                {
                    $this->rest_output([
                        'success' => true,
                        'count' => count($insertDocuments)
                    ]);
                }
            }
        }
    }

}

    
    