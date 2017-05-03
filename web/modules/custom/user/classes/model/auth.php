<?php

defined('SYSPATH') or die('No direct access allowed.');

class Model_Auth {

    protected $tableName = 'users';
    protected $session;
    protected $_config;

    /**
     * Loads Session and configuration options.
     *
     * @return  void
     */
    public function __construct($config = array()) {
        // Load the configuration for this type
        $config = Kohana::$config->load('auth');

        // Save the config in the object
        $this->_config = $config;

        $this->session = Session::instance($this->_config['session_type']);
    }

    public function get_user($default = NULL) {
        return $this->session->get($this->_config['session_key'], $default);
    }

    public function login($username, $password, $remember = FALSE) {
        if (empty($password)) {
            return FALSE;
        }

        if (is_string($password)) {
            // Create a hashed password
            $password = $this->hash($password);
        } else {
            return FALSE;
        }

        $user = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `username` = :username AND `password` = :password', TRUE)
                ->as_object()
                ->parameters(array(
                    ':username' => $username,
                    ':password' => $password,
                ))
                ->execute();

        if (isset($user[0]->username)) {
            //$user = $query->as_array();
            // Finish the login
            $this->complete_login($user[0]);

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function logout($destroy = FALSE, $logout_all = FALSE) {
        if ($destroy === TRUE) {
            // Destroy the session completely
            $this->session->destroy();
        } else {
            // Remove the user from the session
            $this->session->delete($this->_config['session_key']);

            // Regenerate session_id
            $this->session->regenerate();
        }

        // Double check
        return !$this->logged_in();
    }

    public function logged_in($role = NULL) {
        return ($this->get_user() !== NULL);
    }

    public function hash_password($password) {
        return $this->hash($password);
    }

    public function hash($str) {
        if (!$this->_config['hash_key'])
            throw new Kohana_Exception('A valid hash key must be set in your auth config.');

        return hash_hmac($this->_config['hash_method'], $str, $this->_config['hash_key']);
    }

    protected function complete_login($user) {
        // Regenerate session_id
        $this->session->regenerate();

        // Store username in session
        $this->session->set($this->_config['session_key'], $user);

        return TRUE;
    }

    public static function loginform() {
        return View::factory(Data::_('template_directory') . 'authformlogin');
    }
    
    public static function regform() {
        return View::factory(Data::_('template_directory') . 'authformreg');
    }
}
// End Auth
