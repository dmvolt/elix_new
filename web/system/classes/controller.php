<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller extends Kohana_Controller {

	protected $template_directory = '';
    protected $languages;
    protected $logged = false;
    protected $is_admin = false;
    protected $session;
    protected $lang_id = 1;
	protected $filial = 'nsk';
    protected $lang_ident = 'ru';
    protected $lang_uri = '';
    protected $lang_dir = 'ltr';
    protected $lang_name = 'Русский';
    protected $lang_icon = '<img src="/images/lang/ru.png" />';
    protected $lang = array();
    protected $user = false;
    public static $privat_data = array();
	
    public function before() {
	
        parent::before();
        $lang_ident = $this->request->param('lang');
        $this->languages = Kohana::$config->load('language');
        if(isset($lang_ident)){
            $this->lang_ident = $lang_ident;
            $this->lang_id = (isset($this->languages[$lang_ident])) ? $this->languages[$lang_ident]['lang_id']:1;
            $this->lang_uri = (isset($this->languages[$lang_ident])) ? $this->languages[$lang_ident]['alias']:'';
            $this->lang_name = (isset($this->languages[$lang_ident])) ? $this->languages[$lang_ident]['name']:'Русский';
            $this->lang_dir = (isset($this->languages[$lang_ident])) ? $this->languages[$lang_ident]['dir']:'ltr';
            $this->lang_icon = (isset($this->languages[$lang_ident])) ? $this->languages[$lang_ident]['icon']:'<img src="/images/lang/ru.png" />';
        }
        $auth = new Model_Auth();
        $this->logged = $auth->logged_in();
        if ($this->logged) {
            $this->user = $auth->get_user();
            if ($this->user->role_id == 1 OR $this->user->role_id == 0) {
                $this->is_admin = 1;
            }
        }
        // Загрузка текстовых констант
        /* if (is_file(APPPATH . 'lang/' . $this->lang_ident . EXT)) {
            require APPPATH . 'lang/' . $this->lang_ident . EXT;
            foreach($lang_array as $key => $value){
                $this->lang[$key] = $value;
            }
        } */
        foreach (Kohana::modules() as $module_name => $module_path) {
            if (is_file($module_path . '/lang/' . $this->lang_ident . EXT)) {
			
                require $module_path . '/lang/' . $this->lang_ident . EXT;
				
				if (isset($lang_array)) {
					foreach($lang_array as $key => $value){
						$this->lang[$key] = $value;
					}
				}
            }
        }
        $this->session = Session::instance();
        //$this->session->delete('cart');
        static::$privat_data = array(
            'logged' => $this->logged,
            'is_admin' => $this->is_admin,
            'session' => $this->session,
            'user' => $this->user,
            'lang_id' => $this->lang_id,
            'lang_ident' => $this->lang_ident,
            'lang_uri' => $this->lang_uri,
            'lang_name' => $this->lang_name,
            'lang_dir' => $this->lang_dir,
            'lang_icon' => $this->lang_icon,
            'lang' => $this->lang,
            'template_directory' => $this->template_directory,
        );
    }
}