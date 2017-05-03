<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Template extends Kohana_Controller_Template {

	protected $page_class = '';
	protected $current_param_cat = '';
	protected $current_param_menu = '';
	protected $article_id = false;

    public function before() {
	
		$categories_obj = new Model_Categories();
		$siteinfo = new Model_Siteinfo();
		$partners_obj = new Model_Partners();
		
        $this->template_directory = Kohana::$config->load('template.directory');
        $this->template = $this->template_directory . $this->template;

        parent::before();

        if ($this->session->get('redirect', 0)){
            if ($this->session->get('redirect', 0) == $_SERVER['REQUEST_URI']){
                $this->session->delete('redirect');
            } else {
                $redirect = $this->session->get('redirect', 0);
                $this->session->delete('redirect');
                Request::initial()->redirect($redirect);
            }
        }

        
        $info = $siteinfo->get_siteinfo(1);
		$category_info = $categories_obj->getCategory(2, SUBDOMEN);
		
		$a_filter_query = ' AND (cc1.category_id = '.$category_info[0]['id'].' AND cc1.module = "partners") ';		
		$a_inner_join = ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
		
		$address = $partners_obj->get_all(0, 0, 100, 'a.weight', $a_inner_join, $a_filter_query);
		
		$this->current_param_cat = Request::current()->param('cat');
		
		if($this->current_param_cat){
			$this->current_param_menu = '/'.$this->current_param_cat;
		}
		
		if(!$this->current_param_cat){
			$this->current_param_cat = 'epil';
			$this->current_param_menu = '/';
		}

        View::bind_global('logged', $this->logged);
        View::bind_global('lang_id', $this->lang_id);
        View::bind_global('lang_uri', $this->lang_uri);
        View::bind_global('is_admin', $this->is_admin);
        View::set_global('title', $info['descriptions'][$this->lang_id]['site_name']);
		View::set_global('region_title', $category_info[0]['descriptions'][$this->lang_id]['title']);
        View::bind_global('page_title', $this->page_title);
		View::bind_global('page_class', $this->page_class);
		View::bind_global('article_id', $this->article_id);
		
		View::bind_global('filial', $category_info[0]['alias']);
		View::bind_global('current_param_cat', $this->current_param_cat);
		View::bind_global('current_param_menu', $this->current_param_menu);
		
        View::bind_global('meta_description', $this->meta_description);
        View::bind_global('meta_keywords', $this->meta_keywords);
        View::set_global('description', $info['descriptions'][$this->lang_id]['body']);
        View::set_global('logo', Kohana::$config->load('site.logo'));
        View::set_global('slogan', $info['descriptions'][$this->lang_id]['site_slogan']);
		View::set_global('address', $address);
		View::set_global('licence', $info['descriptions'][$this->lang_id]['site_licence']);
        View::set_global('prodigy', Kohana::$config->load('site.prodigy'));
        View::set_global('copyright', $info['descriptions'][$this->lang_id]['site_copyright']);
        View::set_global('info_email', $info['email']);
        View::set_global(Kohana::$config->load('template.colors'));

        $this->template->styles = array(
			PARENT_FULLURL . '/css/' . $this->template_directory . 'main',
			PARENT_FULLURL . '/css/' . $this->template_directory . 'main2',
			PARENT_FULLURL . '/css/redactor',
		);
		
        $this->template->scripts1 = array(
			/* 'js/' . $this->template_directory . 'vendor/jquery-1.9.1.min', */
		);
		
		$this->template->scripts2 = array(
            PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/jquery.min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'jquery.maskedinput.min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'jquery.validate.min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/jquery.parallaxify.min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/jquery.scrollNav.min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/swiper.jquery.min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/jquery.magnific-popup.min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/jquery.sticky',
			
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/snap.svg-min',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/svgicons-config',
			PARENT_FULLURL . '/js/' . $this->template_directory . 'vendor/svgicons',
			
			PARENT_FULLURL . '/js/' . $this->template_directory . 'main',
		);

        $this->template->menu_left = Menu::getmenu(1, '-left');
		$this->template->menu_right = Menu::getmenu(2, '-right');
		
		$this->template->menu_left_mobile = Menu::getmenu(1, '-left-mobile');
		$this->template->menu_right_mobile = Menu::getmenu(2, '-right-mobile');
		
		$this->template->menu_social = Menu::getmenu(3, '-social');
		$this->template->menu_social_mobile = Menu::getmenu(3, '-social-mobile');
		
		$this->template->menu_category_parent = Menu::getmenu(4, '-category-parent');
		$this->template->menu_category_childs = Menu::getmenu(4, '-category-childs');
		$this->template->menu_category_childs2 = Menu::getmenu(4, '-category-childs2');

        $this->template->login_block = Model_Auth::loginform();
        $this->template->feedback_block = Feedback::contact_form();
		$this->template->review_block = Feedback::rev_form();
		$this->template->check_block = Checkout::contact_form();

		$this->template->action_block = Actions::actions_block();
		$this->template->info_block_right = Infoblock::infoblock_block();
		$this->template->info_block_left = Infoblock::infoblock_block(3, 2);

		$this->template->tags_block = null; //Tags::get_cloud();
		$this->template->blog_block = null;
        $this->template->left_block = null;
        $this->template->right_block = null;
        $this->template->top_block = null; //Banners::get();
        $this->template->bottom_block = null;
		$this->template->bottom_script = Liteedit::get_script();

		$this->template->them_colors_styles = View::factory($this->template_directory . 'them_colors_styles');
    }
}
