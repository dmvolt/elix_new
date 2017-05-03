<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Template {

    public function action_index() {
        $this->auto_render = FALSE; //не использовать главный шаблон вида "template"

        $auth = new Model_Auth();
        $data = array();

        if ($this->logged) {
           Request::initial()->redirect();
        } else {
            if (isset($_POST['login'])) {
                $login = Arr::get($_POST, 'login', '');
                $password = Arr::get($_POST, 'password', '');

                if ($auth->login($login, $password)) {
                    $redirect = '/'; /* переадресация на главную страницу сайта, вместо админки */ //$this->session->get('admin_redirect', '/'); 
                    $this->session->delete('admin_redirect');
                    Request::initial()->redirect($redirect);
                } else {
                    $data["error"] = "";
                }
            }
        }
        $this->response->body(View::factory($this->template_directory . 'login', $data));
    }

    public function action_form() {
        //Закрываем доступ к контроллеру первичным зарпосам
        if ($this->request->is_initial()) {
            throw new HTTP_Exception_404('File not found!');
        }

        $this->auto_render = FALSE; //не использовать главный шаблон вида "template"

        if ($this->logged) {

            $customer = new Model_Checkout();
            $customerinfo = $customer->get_customerinfo($this->user->id);

            if ($customerinfo) {
                $data['username'] = $customerinfo->name;
            } else {
                $data['username'] = $this->user->username;
            }

            $data['userid'] = $this->user->id;
        }

        $this->response->body(View::factory($this->template_directory . 'authformlogin', $data));
    }

    public function action_reg() {
        $data = array();

        if (isset($_POST['btnsubmit'])) {
            $reg_data['email'] = Arr::get($_POST, 'email', '');
            $reg_data['login'] = Arr::get($_POST, 'login', '');

            $reg_data['name'] = Arr::get($_POST, 'name', '');
            $reg_data['lastname'] = Arr::get($_POST, 'lastname', '');
            $reg_data['tell'] = Arr::get($_POST, 'tell', '');
            $reg_data['city'] = Arr::get($_POST, 'city', '');
            $reg_data['postcode'] = Arr::get($_POST, 'postcode', '');
            $reg_data['address'] = Arr::get($_POST, 'address', '');
            
            $default_country_id = Kohana::$config->load('checkout_setting.default.country_id');
            $default_zone_id = Kohana::$config->load('checkout_setting.default.zone_id');
            
            $reg_data['country_id'] = Arr::get($_POST, 'country_id', $default_country_id);
            $reg_data['zone_id'] = Arr::get($_POST, 'zone_id', $default_zone_id);
            $reg_data['newsletter'] = Arr::get($_POST, 'newsletter', 0);

            $register = new Model_Register();
            if ($register->reg($reg_data)) {
                $answer_message = 'Регистрация прошла успешно! </br>Ваши логин и пароль для входа в систему высланны на адрес электронний почты, который вы указали при регистрации.';
                AW::answer($answer_message);
            } else {
                $data["errors"] = $register->getErrors();
            }
        }
        $this->page_title = 'Регистрация';
        $this->template->content = View::factory($this->template_directory . 'registration', $data);
    }

    public function action_hpass() {
        $auth = new Model_Auth();
        $this->template->content = $auth->hash_password('user');
    }

    public function action_logout() {
        $auth = new Model_Auth();
        $auth->logout();

        Request::initial()->redirect();
    }

    public function action_pwrecovery() {
        $data = array();

        if (isset($_POST['btnsubmit'])) {

            $email = Arr::get($_POST, 'email', '');

            $register = new Model_Register();

            if ($register->newpassword1($email)) {
                $answer_message = 'Код для восстановления пароля выслан Вам на e-mail! </br>Проверте Вашу почту.';
                AW::answer($answer_message);
            } else {
                $answer_message = 'E-mail, который Вы указали не зарегистрирован в системе';
                AW::answer($answer_message);
            }
        }
        $this->page_title = 'Восстановление пароля';
        $this->template->content = View::factory($this->template_directory . 'pwrecovery', $data);
    }

    public function action_checkcode() {

        $code = $this->request->param('id');

        $register = new Model_Register();
        $return_data = $register->newpassword2($code);

        if (!empty($return_data)) {
            $answer_message = 'Временный пароль для входа в вашу учетную запись успешно создан!</br></br><span style="display:block; font-weight:normal; padding:3px; font-size:22px; background:#fdf863; color:#757575;">Логин(е-mail): ' . $return_data['login'] . '</br>Пароль: ' . $return_data['pass'] . '</span></br>После входа рекомендуется изменить временный пароль.';
            AW::answer($answer_message);
        } else {
            $answer_message = 'Ошибка! Пароль восстановить не удалось.';
            AW::answer($answer_message);
        }
    }

}

// End Controller_Auth