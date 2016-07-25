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

    /**
     * Уточнить наличие детали
     * При отправке формы методом ajax
     * мы сначала проверяем форму если все ОК кидаем на почту
     * если нет то выдаем ошибки
     */
    public function action_detailFeedback()
    {
        $params = $this->request->post();
        $validation = Validation::factory($params);

        $validation
            ->rule('useremail', 'not_empty')
            ->rule('useremail', 'regex', [':value', '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/is']);

        if( $validation->check()  && $this->sendAdminMessage($params) && $this->sendClientMessage($params) )
        {

            exit(Response::factory()
                ->status(200)
                ->body(json_encode([
                    'success'   => true,
                    'message'   => 'В ближайшее время с Вами свяжеться менеджер.'
                ])));
        }else
        {
            $errors = $validation->errors();

            exit(Response::factory()
                ->status(403)
                ->body(json_encode([
                    'success'   => false,
                    //'errors'    => $errors,
                    'message'   => 'Произошла ошибка при отправки письма'
                ])));
        }

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

    private function sendClientMessage($params)
    {
        $mailConfig = Kohana::$config->load('cart')->as_array();
        $mailer = Email::instance('sendmail');

        $clientMessage = Swift_Message::newInstance();
        $clientMessage
            ->setSubject('Вопрос о наличии детали в интернет-магазине HAMMERSCHMIDT')
            ->setTo([$params['useremail']	=> $params['username']])
            ->setFrom($mailConfig['emailFrom'])
            ->setBody(
                View::factory(
                    'email/detailquestion',
                    [
                        'title'	=> 'Ваш вопрос о наличии детали успешно отправлен',
                        'userdata'	=> $params,
                        'base_url'	=> URL::base(),
                        'thanks'	=> '
							<h4>Спасибо что воспользовались нашими услугами.</h4> <p>Ждем Вас снова в нашем интернет-магазине деталей. 
							Если появились вопросы или хотите поделиться своими впечатлениями пишитем нам на email: info@hammerschmidt.ru.</p>'
                    ]
                )
                    ->render(),
                'text/html'
            );


        $client = $mailer->send($clientMessage);

        if( $client > 0 )
        {
            return true;
        }

        return false;
    }

    private function sendAdminMessage($params)
    {
        $mailConfig = Kohana::$config->load('cart')->as_array();
        $mailer = Email::instance('sendmail');

        $message = Swift_Message::newInstance();

        $message
            ->setSubject('Поступил вопрос о наличии товара')
            ->setTo($mailConfig['emailTo'])
            ->setFrom($mailConfig['emailFrom'])
            ->setBody(
                View::factory(
                    'email/detailquestion',
                    [
                        'title'	=> 'Поступил вопрос о детали',
                        'userdata'	=> $params,
                        'base_url'	=> URL::base(),
                    ]
                )
                    ->render(),
                'text/html'
            );



        $admin = $mailer->send($message);

        if( $admin > 0 )
        {
            return true;
        }

        return false;

    }

}