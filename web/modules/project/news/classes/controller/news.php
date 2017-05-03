<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Template {

    public function action_new() {
		$categories_obj = new Model_Categories();
		$news_obj = new Model_News();  // Создание экземпляра объекта модели
		
		$alias = $this->request->param('alias');

        $content = View::factory($this->template_directory . 'news')
				->bind('edit_interface', $edit_interface)
                ->bind('news', $one_news);

        $category_info = $categories_obj->getCategory(1, SUBDOMEN);
		
        $one_news = $news_obj->get_content_to_cat($category_info[0]['id'], $alias); // Создание экземпляра объекта модели с выборкой из метода
		
		$edit_interface = Liteedit::get_interface($one_news['id'], 'news');

        $this->page_title = $one_news['descriptions'][$this->lang_id]['title'];
		
		/****************************** SEO ******************************/	
		$seo_obj = new Model_Seo();
		$seo = $seo_obj->get_seo_to_content($one_news['id'], 'news');

		if($seo[$this->lang_id]['title'] != ''){
			$this->page_title = $seo[$this->lang_id]['title'];
		}

		$this->meta_description = $seo[$this->lang_id]['meta_d'];
		$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
		/****************************** /SEO *****************************/

        $this->template->content = $content;
    }

    public function action_news() {
		$categories_obj = new Model_Categories();
		$news_obj = new Model_News();  // Создание экземпляра объекта модели
       
        $content = View::factory($this->template_directory . 'all-news')
                ->bind('all_news', $all_news)
				->bind('modulinfo', $modulinfo)
				->bind('pagination', $pagination);
  
        //$total = $news_obj->get_total();
        //$result = Pagination::start($total);                                                                   // Пагинатор data
        //$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);  // Пагинатор views
		
		$category_info = $categories_obj->getCategory(1, SUBDOMEN);
        $all_news = $news_obj->get_all_to_cat($category_info[0]['id']);

        $this->page_title = $this->lang['text_all_news'];
		
		$modulinfo = Modulinfo::get_block('news', $category_info[0]['id']);
		if(!empty($modulinfo)){
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($modulinfo[0]['id'], 'modulinfo');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
		}
		
        $this->template->content = $content;
    }
}
// Controller_News