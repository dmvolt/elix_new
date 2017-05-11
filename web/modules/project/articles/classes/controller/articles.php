<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Articles extends Controller_Template {

    public function action_article() {
	
        $alias = $this->request->param('alias');
		
        $content = View::factory($this->template_directory . 'article')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
				
        $articles_obj = new Model_Articles();
        $article = $articles_obj->get_content($alias);
		
		$this->page_class = 'action';
		
		if($article){
		
			$edit_interface = Liteedit::get_interface($article['id'], 'articles');		
			$this->article_id = $article['id'];
			$this->page_title = $article['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($article['id'], 'articles');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
			
			$this->template->content = $content;
			
		} else {
		
			$this->auto_render = false; //не использовать главный шаблон вида "template"
			// Выполняем запрос, обращаясь к роутеру для обработки ошибок
			$attributes = array(
				'code'  => 404, // Ошибка по умолчанию
				'message' => 'Страница не найдена или не существует!'
			);
			echo Request::factory(Route::get('error')->uri($attributes))
				->execute()
				->send_headers()
				->body();
			$this->response->status(404);
			return;
		}
    }
	
    public function action_articles() {
        
        $articles_obj = new Model_Articles();
        $categories_obj = new Model_Categories();
		$tags_obj = new Model_Tags();
		
		$tag = Arr::get($_GET, 'tag');
		$cat = $this->current_param_cat;
		
		$filter_query = '';
		$inner_join = '';
		$cat_url = '';
		
		if($cat != 'epil'){
			$cat_url = '/'.$cat;
		}
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "articles") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
			
			$this->page_title = 'Статьи';
		}
		
		if($cat){
			$category_info1 = $categories_obj->getCategory(1, $cat);
			
			if($category_info1){
				$filter_query .= ' AND (cc2.category_id = '.$category_info1[0]['id'].' AND cc2.module = "articles") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = a.id ';
			}
			
			$this->page_title = 'Статьи - '.$category_info1[0]['descriptions'][1]['title'];
		}
		
		if($tag AND !empty($tag)){
			$tag_info = $tags_obj->get_tag_to_alias($tag, 1);
			
			if($tag_info){
				$filter_query .= ' AND (ct.tag_id = '.$tag_info['id'].' AND ct.module = "articles") ';		
				$inner_join .= ' INNER JOIN `contents_tags` ct ON ct.content_id = a.id ';
			}
			
			$this->page_title = 'Статьи - '.$tag_info['name'];
		}
		
		$total = $articles_obj->get_total_all(0, $inner_join, $filter_query);   // Получение общего количества записей
		$result = Pagination::start($total);
		$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
		$contents = $articles_obj->get_all(0, $result['start'], $result['num'], 'a.weight', $inner_join, $filter_query);
		
		$this->page_class = 'articles';
		
		$content = View::factory($this->template_directory . 'articles')
					->bind('pagination', $pagination)
					->bind('cat_url', $cat_url)
					->bind('articles', $contents);
					
        $this->template->content = $content;
    }
}
// Articles