<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Template extends Kohana_Controller_Template {

    protected $parameters = '';
	
    public function before() {
	
        $this->template = 'admin/template';
        parent::before();
		
        // Формирование строки $parameters из строки запроса
        $cat = Arr::get($_GET, 'cat', null);
        $page = Arr::get($_GET, 'page', null);
        $filter = Arr::get($_GET, 'filter', null);
		
        $this->parameters = '';
        $i = 0;
		
        if($cat){
            $this->parameters .= ($i) ? '&cat='.$cat : '?cat='.$cat;
            $i++;
        }
        if($page){
            $this->parameters .= ($i) ? '&page='.$page : '?page='.$page;
            $i++;
        }
        if($filter){
            $this->parameters .= ($i) ? '&filter='.$filter : '?filter='.$filter;
            $i++;
        }
		
        // Загрузка текстовых констант
        foreach (Kohana::modules() as $module_name => $module_path) {
            if (is_file($module_path . '/lang/admin/' . $this->lang_ident . EXT)) {
			
                require $module_path . '/lang/admin/' . $this->lang_ident . EXT;
				
				if (isset($lang_array)) {
					foreach ($lang_array as $key => $value) {
						$this->lang[$key] = $value;
					}
				}
            }
        }
		
        if ($this->session->get('admin_redirect', 0)) {
            if ($this->session->get('admin_redirect', 0) == $_SERVER['REQUEST_URI']) {
                $this->session->delete('admin_redirect');
            } else {
                $redirect = $this->session->get('admin_redirect', 0);
                $this->session->delete('admin_redirect');
                Request::initial()->redirect($redirect);
            }
        }
		
        //$this->session->delete('add_files');
        //$this->session->delete('options');
        //$this->session->delete('features');
		
        if ($this->logged == 0) {
            $this->session->set('admin_redirect', $_SERVER['REQUEST_URI']);
            Request::initial()->redirect('auth');
        }
		
        $roles = Kohana::$config->load('admin/user.roles');
		
        if($this->user->role_id){
            if($roles[$this->user->role_id]['is_admin'] != 1){
                $this->session->set('admin_redirect', $_SERVER['REQUEST_URI']);
                Request::initial()->redirect('auth');
            }
			
            $pre_url_array = explode('?', $_SERVER['REQUEST_URI']); /* Обрезаем от полного урла параметры */
            $url_array = explode('/', $pre_url_array[0]);
			
            if($url_array[1] == 'admin'){
                $current_url = '';
            } else {
                $current_url = $url_array[1].'/';
            }
			
            if(isset($url_array[2]) AND $url_array[2] != 'admin'){
                $current_url .= $url_array[2];
            }
			
            if(isset($url_array[3]) AND $url_array[3] != 'admin'){
                $current_url .= '/'.$url_array[3];
            }
			
            $permissions = explode(',', $roles[$this->user->role_id]['permission']);
            if(count($permissions)>0){
                foreach($permissions as $key => $path){
                    $permissions[$key] = trim($path);
                    $path_array = explode('/', trim($path));
                    $controllers[$key] = $path_array[0];
                }
            }
			
            if(!in_array($current_url, $permissions) AND $permissions[0] != '*' AND $current_url != ''){
                $this->session->set('admin_redirect', $_SERVER['REQUEST_URI']);
                Request::initial()->redirect('auth');
            }
        }
		
        $siteinfo = new Model_Siteinfo();
        $info = $siteinfo->get_siteinfo(1);
		
        View::set_global('role_name', (isset($roles[$this->user->role_id]['name'])? $roles[$this->user->role_id]['name']: 'ROOT'));
        View::set_global('title', $info['descriptions'][1]['site_name']);
        View::set_global('logo', Kohana::$config->load('admin/site.logo'));
        View::set_global('slogan', Kohana::$config->load('admin/site.slogan'));
        View::set_global('prodigy', Kohana::$config->load('site.prodigy'));
        View::set_global('copyright', $info['descriptions'][1]['site_copyright']);
        View::set_global('tell', $info['tell']);
        View::set_global('info_email', $info['email']);
		
        $this->template->styles = array(
			'admin/style', 'admin/pluggables', 
			'smoothness/jquery-ui-1.10.3.custom', 
			'admin/redactor'
		);
		
        $this->template->scripts = array('jquery-1.9.1', 
			'jquery-ui-1.10.3.custom.min',
			'redactor/redactor', 
			'redactor/plugins/fontfamily',
			'redactor/plugins/fontsize',
			'redactor/plugins/fontcolor',
			'redactor/plugins/fullscreen',
			'redactor/langs/ru', 'admin/jquery.form', 'admin/common',
		);
			
        // Формирование меню
        $menu = array();
        foreach (Kohana::modules() as $module_name => $module_path) {
            if (is_file($module_path . 'config/admin/' . $module_name . '_menu' . EXT)) {
                $module_menus = Kohana::$config->load('admin/' . $module_name . '_menu.main_menu');
                foreach ($module_menus as $module_menu) {
                    if(!$this->user->role_id){
                        $menu[] = $module_menu;
                    } elseif(in_array($module_menu['controller'], $controllers) OR $permissions[0] == '*'){
                        $menu[] = $module_menu;
                    }
                }
            }
        }
        $this->template->menu = $menu;
        if(count($this->languages)>1){
            View::set_global('languages', $this->languages);
        }
    }
}