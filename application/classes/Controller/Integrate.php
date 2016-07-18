<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Integrate extends Controller
{

    /**
     * Uploads directory
     *
     * @return string
     */
    private function getUploadDir()
    {
        return DOCROOT . 'uploads' . DIRECTORY_SEPARATOR . 'export1c_' . date("d.m.Y") . DIRECTORY_SEPARATOR;
    }


    /**
     * Uploads directory
     *
     * @return string
     */
    private function getExportDir()
    {
        return DOCROOT . 'uploads' . DIRECTORY_SEPARATOR . 'catalogs' . DIRECTORY_SEPARATOR;
    }


    /**
     * Upload file from remote 1C server
     * to uploads folder
     * and save metadata of uploaded file into database
     *
     * @return void
     */
    public function action_uploadPrice()
    {
        if (!is_dir($this->getUploadDir())) {
            @mkdir($this->getUploadDir());
            @chmod($this->getUploadDir(), 0775);
        }

        $headers = $this->request->headers();

        if( isset( $headers['FileName'] ) && !empty($headers) )
        {
            $uploadedFile = $this->getExportDir() . $headers['FileName'];

            if( file_exists( $uploadedFile ) )
            {
                $fileModel = MongoModel::factory('Exports1C');
                $fileModel->selectDB();

                $newFile = $this->getUploadDir() . $headers['FileName'];
                $newFile = preg_replace('/ /is', '_', $newFile);

                if( copy($uploadedFile, $newFile ) )
                {
                    @unlink($uploadedFile);

                    $fileModel->values([
                        'file_format'   => $headers['FileFormat'],
                        'file_size' => filesize($newFile),
                        'file_name' => $headers['FileName'],
                        'file_path' => $this->getUploadDir(),
                        'date_upload'   => new \MongoDate(),
                    ]);

                    $fileModel->save();
                    $this->analizeFile('/home/hammer/htdocs/catalogs/FKT-AVTO.csv');

                    echo Response::factory()
                        ->status(200)
                        ->body('Файл успешно был загружен на сервер')
                        ->render();
                }else
                {
                    echo Response::factory()
                        ->status(500)
                        ->body('Не удалось переместить файл на сервере')
                        ->render();
                }
            }else
            {
                echo Response::factory()
                    ->status(500)
                    ->body('Файл не был загружен или не верно указано имя файла в заголовке')
                    ->render();
            }
        }else
        {
            $this->analizeFile('/home/hammer/htdocs/catalogs/FKT-AVTO.csv');
            /*
            echo Response::factory()
                ->status(403)
                ->body('Заголовки пустые')
                ->render();
            */
        }

    }


    /**
     * Available extension of the uoloaded files
     * @var array
     */
    private $_available_extension = ['csv', 'xls', 'xlsx'];


    /**
     * Anaalize file for format
     * Applied formats is csv,xls,xlsx
     * 
     * @param string file name with full path
     */
    private function analizeFile($filename)
    {
        if( file_exists( $filename ) )
        {
            $fileInfo = new SplFileInfo($filename);

            $prices = [];
            if( in_array(strtolower($fileInfo->getExtension()), $this->_available_extension) )
            {
                $options = [
                    'authMechanism' => 'SCRAM-SHA-1',
                    'db'		=> 'dev_hammer_v3',
                    'username'	=> 'hammer',
                    'password'	=> 'nyFFqv2015',
                ];
                $m = new MongoClient("mongodb://localhost:27017", $options);
                $collection = $m->selectCollection('dev_hammer_v3', 'prices');

                switch (strtolower($fileInfo->getExtension()))
                {
                    case 'csv':

                        $csv = CSV::factory($filename, [
                            'has_titles'    => false
                        ]);

                        if( mb_detect_encoding($filename) == 'ASCII' )
                        {
                            $csv->encode('CP1251', 'UTF-8');
                        }

                        $csv->parse();

                        $rows = $csv->rows();


                        if( !empty( $rows ) )
                        {
                            foreach( $rows as $key => $row )
                            {
                                if( $key == 0 ) continue;

                                $clear_article = preg_replace('/[^\w+]/i', '', $row[2]);
                                if( !empty($clear_article) )
                                {
                                    $price = [
                                        'article'   => $row[2],
                                        'clear_article' => preg_replace('/[^\w+]/i', '', $row[2]),
                                        'manufacture'   => preg_replace('/[^a-z0-9_\-\., +]/i', '', $row[6]),
                                        'name'  => $row[0],
                                        'qty'   => (!empty($row[4]) ? preg_replace('/[^\d+]/Uis', '', $row[4]) : 0),
                                        'price' => (!empty($row[5]) ? sprintf("%01.2f", preg_replace('/ /s', '', $row[5])) : 0.00),
                                        'date_create'   => new \MongoDate()
                                    ];

                                    $collection->update([
                                        'article'	=> $price['article']
                                    ], $price, [
                                        'upsert'	=> true
                                    ]);

                                    $prices[] = $collection->update([
                                        'article'	=> $price['article']
                                    ], $price, [
                                        'upsert'	=> true
                                    ]);
                                }
                            }
                        }

                        break;
                    case 'xls':
                    case 'xlsx':
                        $filename = preg_replace('@^'.DOCROOT.'@is', '/', $filename);
                        $spreadsheet = Spreadsheet::factory([
                            'filename' => $filename
                        ], FALSE)
                            ->load()
                            ->read();

                        if( !empty( $spreadsheet ) )
                        {

                        }
                    break;
                }
            }
        }
    }


}