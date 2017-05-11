<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Partners extends Controller_Template {

	public function action_article() {
	
        $alias = $this->request->param('alias');
        $content = View::factory($this->template_directory . 'contact')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
				
        $partners_obj = new Model_Partners();
        $article = $partners_obj->get_content($alias);
		
		$this->page_class = 'filial';
		
		if($article){
		
			$edit_interface = Liteedit::get_interface($article['id'], 'partners');		
			$this->article_id = $article['id'];
			$this->page_title = $article['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($article['id'], 'partners');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
		}
        $this->template->content = $content;
    }

    public function action_partners() {
	
		$filter_query = '';
		$inner_join = '';
		
        $partners_obj = new Model_Partners();
		$seo_obj = new Model_Seo();
		$categories_obj = new Model_Categories();
		
		$category_info = $categories_obj->getCategory(2, SUBDOMEN);
		
		$filter_query .= ' AND (cc1.category_id = '.$category_info[0]['id'].' AND cc1.module = "partners") ';		
		$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
		
		$partners = $partners_obj->get_all(0, 0, 100, 'a.weight', $inner_join, $filter_query);
		
		if($partners AND count($partners) == 1){
			Request::initial()->redirect('contacts/'.$partners[0]['alias']);
		}
		
		$this->page_class = 'contacts';
		
		$content = View::factory($this->template_directory . 'contacts')
					->bind('partners', $partners);
		
		$this->page_title = $this->lang['text_partners'];	
        $this->template->content = $content;
    }
}
// Partners