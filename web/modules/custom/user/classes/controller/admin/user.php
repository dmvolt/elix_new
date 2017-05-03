<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin_Template {

    public function action_index() {
	
        $this->session->delete('user_redirect');
        $this->session->set('user_redirect', $_SERVER['REQUEST_URI']);

        $getuserdata = array();

        if (isset($_POST['role_id'])) {
            $email = Arr::get($_POST, 'email', '');
            $role_id = Arr::get($_POST, 'role_id', '');

            $getuserdata = array(
                'email' => $email,
                'role_id' => $role_id,
            );
        }

        $content = View::factory('admin/user')
                ->bind('contents', $users)
                ->bind('roles', $roles);

        $roles = Kohana::$config->load('admin/user.roles');

        $user_obj = new Model_User();
        $users = $user_obj->get_users($getuserdata);

        $this->template->content = $content;
    }

    public function action_add() {
        if (isset($_POST['role_id'])) {
            $login = Arr::get($_POST, 'username', '');
            $email = Arr::get($_POST, 'email', '');
            $role_id = Arr::get($_POST, 'role_id', '');
            $status = Arr::get($_POST, 'status', '');
			$pass = Arr::get($_POST, 'pass', '');
            
            //$default_country_id = Kohana::$config->load('checkout_setting.default.country_id'); /* Только для ИМ */
            //$default_zone_id = Kohana::$config->load('checkout_setting.default.zone_id'); /* Только для ИМ */

            $add_data = array(
                'login' => $login,
                'email' => $email,
				'pass' => $pass,
                'role_id' => $role_id,
                'status' => $status,
                /*'name' => '', // Только для ИМ */
                /*'lastname' => '', // Только для ИМ */
                /*'tell' => '', // Только для ИМ */
                /*'city' => '', // Только для ИМ */
                /*'postcode' => '',  // Только для ИМ */
                /*'address' => '',  // Только для ИМ */
                /*'country_id' => $default_country_id,  // Только для ИМ */
                /*'zone_id' => $default_zone_id,  // Только для ИМ */
                /*'newsletter' => '', // Только для ИМ */
            );

            $user_obj = new Model_User();
            $result = $user_obj->add($add_data);

            if ($result) {
                Request::initial()->redirect('admin/user');
            }
        }

        $data['roles'] = Kohana::$config->load('admin/user.roles');

        $this->template->content = View::factory('admin/user-add', $data);
    }

    public function action_edit() {
        $Id = $this->request->param('id');

        $user_obj = new Model_User();

        if (isset($_POST['role_id'])) {
            $login = Arr::get($_POST, 'username', '');
            $email = Arr::get($_POST, 'email', '');
            $role_id = Arr::get($_POST, 'role_id', '');
            $status = Arr::get($_POST, 'status', '');

            $add_data = array(
                'login' => $login,
                'email' => $email,
                'role_id' => $role_id,
                'status' => $status
            );
            $result = $user_obj->edit($Id, $add_data);

            if ($result) {
                Request::initial()->redirect('admin/user');
            }
        }

        $data['roles'] = Kohana::$config->load('admin/user.roles');

        $data['userdata'] = $user_obj->get_userdata($Id);

        $this->template->content = View::factory('admin/user-edit', $data);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $user_obj = new Model_User();

        if (isset($_POST['delete'])) {
            $result = $user_obj->delete($Id);
            if ($result) {
                Request::initial()->redirect('admin/user');
            }
        }

        $data['user'] = $user_obj->displayusername($Id);

        $this->template->content = View::factory('admin/user-delete', $data);
    }
}