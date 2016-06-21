<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Message extends Controller_Main
{
    public $template = 'templates/second/main';

    public function after()
    {
        $this->template->header = View::factory('templates/second/header');
        $this->template->footer = View::factory('templates/second/footer');

        parent::after();

    }

    public function action_index()
    {

    }
    
    public function action_send()
    {
        $this->setScript('assets/js/second.js', 'footer');
        $this->setStyle('assets/css/sidebar.css', 'all');
        
        $message = MongoModel::factory('Message');
        $message->selectDB();

	    $params = $this->request->post();
        $validation = Validation::factory($params);

        $validation
            ->rule('useremail', 'not_empty')
            ->rule('useremail', 'regex', [':value', '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/is']);

        $this->template->content = View::factory('templates/second/content');
        $this->template->content->category_view = View::factory('templates/errors/question_error_validate');

        if( $validation->check() )
        {
            $message->values($params);
            $message->save();

            $this->template->title = "Ваш вопрос успешно передан нашим менеджерам";
            $this->template->content->category_view->title = "Ваш вопрос успешно передан нашим менеджерам";
            $this->template->content->category_view->errors = [];
            $this->template->content->category_view->success = true;
            $this->template->content->category_view->timeout = 5;
        }else
        {
            $errors = $validation->errors();

            $this->template->title = 'Неверно заполнена форма, проверьте правильно ли заполнены все необходимые поля';
            $this->template->content->category_view->title = 'Ошибка при отправке формы';

            $this->template->content->category_view->errors = $errors;
        }

    }
}