<?php

defined('SYSPATH') or die('No direct script access.');

class Pagination {
    
    public static function start($total) {

        $session = Session::instance();
        $num = $session->get('num', 10); 

        if (isset($_GET['page'])) {
            $page = htmlspecialchars($_GET['page']);
        } else {
            $page = 1;
        }

        $data = array();

        $total_page = (($total - 1) / $num) + 1;
        $total_page = intval($total_page);

        $page = intval($page);

        if (empty($page) or $page < 0)
            $page = 1; 
            

        if ($page > $total_page)
            $page = $total_page;

        if ($total) {
            $data['start'] = $page * $num - $num;
        } else {
            $data['start'] = 0;
        }

        $data['total_page'] = $total_page;
        $data['num'] = $num;
        $data['page'] = $page;

        return $data;
    }

    public static function navigation($page, $total, $total_page, $num) {

        $pagination_data = array();
		
		$catid = Arr::get($_GET, 'cat', null);
		
		if($catid){
			$cat = '&cat='.$catid;
		} else {
			$cat = '';
		}

       
        if ($page != 1) {
            $previewpage = '<a href="?page=1' . $cat . '" class="announce-pager__link">Первая</a><a href="?page=' . ($page - 1) . $cat . '" class="announce-pager__link">Предидущая</a> ';
        } else {
            $previewpage = '';
        }
        
        if ($page != $total_page) {
            $nextpage = '<a href="?page=' . ($page + 1) . $cat . '" class="announce-pager__link">Следующая</a><a href="?page=' . $total_page . $cat . '" class="announce-pager__link">Последняя</a>';
        } else {
            $nextpage = '';
        }

       
        if ($page - 5 > 0) {
            $page5left = ' <a href="?page=' . ($page - 5) . $cat . '" class="announce-pager__link">' . ($page - 5) . '</a> ';
        } else {
            $page5left = '';
        }
        if ($page - 4 > 0) {
            $page4left = ' <a href="?page=' . ($page - 4) . $cat . '" class="announce-pager__link">' . ($page - 4) . '</a> ';
        } else {
            $page4left = '';
        }
        if ($page - 3 > 0) {
            $page3left = ' <a href="?page=' . ($page - 3) . $cat . '" class="announce-pager__link">' . ($page - 3) . '</a> ';
        } else {
            $page3left = '';
        }
        if ($page - 2 > 0) {
            $page2left = ' <a href="?page=' . ($page - 2) . $cat . '" class="announce-pager__link">' . ($page - 2) . '</a> ';
        } else {
            $page2left = '';
        }
        if ($page - 1 > 0) {
            $page1left = ' <a href="?page=' . ($page - 1) . $cat . '" class="announce-pager__link">' . ($page - 1) . '</a> ';
        } else {
            $page1left = '';
        }

        if ($page + 5 <= $total_page) {
            $page5right = ' <a href="?page=' . ($page + 5) . $cat . '" class="announce-pager__link">' . ($page + 5) . '</a>';
        } else {
            $page5right = '';
        }
        if ($page + 4 <= $total_page) {
            $page4right = ' <a href="?page=' . ($page + 4) . $cat . '" class="announce-pager__link">' . ($page + 4) . '</a>';
        } else {
            $page4right = '';
        }
        if ($page + 3 <= $total_page) {
            $page3right = ' <a href="?page=' . ($page + 3) . $cat . '" class="announce-pager__link">' . ($page + 3) . '</a>';
        } else {
            $page3right = '';
        }
        if ($page + 2 <= $total_page) {
            $page2right = ' <a href="?page=' . ($page + 2) . $cat . '" class="announce-pager__link">' . ($page + 2) . '</a>';
        } else {
            $page2right = '';
        }
        if ($page + 1 <= $total_page) {
            $page1right = ' <a href="?page=' . ($page + 1) . $cat . '" class="announce-pager__link">' . ($page + 1) . '</a>';
        } else {
            $page1right = '';
        }

        if ($total_page > 1) {
            $page_nav_links = '&nbsp;&nbsp;&nbsp;' . $page5left . $page4left . $page3left . $page2left . $page1left . '<a href="#" class="announce-pager__link announce-pager__link_active">' . $page . '</a>' . $page1right . $page2right . $page3right . $page4right . $page5right . '&nbsp;&nbsp;&nbsp;';
        } else {
            $page_nav_links = '';
        }

        $num_in_page = Kohana::$config->load('site.num_in_page');

        $pagination_data = array(
            'page' => $page,
            'total_page' => $total_page,
            'total' => $total,
            'num' => $num,
            'page_nav_links' => $page_nav_links,
        );

        return View::factory(Data::_('template_directory') . 'pagination')
                        ->bind('pagination_data', $pagination_data)
                        ->bind('num_in_page', $num_in_page);
    }

    public static function navigation2($page, $total, $total_page, $num) {

        $pagination_data = array();
		
		$catid = Arr::get($_GET, 'cat', null);
		
		if($catid){
			$cat = '&cat='.$catid;
		} else {
			$cat = '';
		}

        if ($page != 1) {
            $previewpage = '<a href="?page=1' . $cat . '">Первая</a><a href="?page=' . ($page - 1) . $cat . '">Предидущая</a> ';
        } else {
            $previewpage = '';
        }
      
        if ($page != $total_page) {
            $nextpage = '<a href="?page=' . ($page + 1) . $cat . '">Следующая</a><a href="?page=' . $total_page . $cat . '">Последняя</a>';
        } else {
            $nextpage = '';
        }

        if ($page - 5 > 0) {
            $page5left = ' <a href="?page=' . ($page - 5) . $cat . '">' . ($page - 5) . '</a> ';
        } else {
            $page5left = '';
        }
        if ($page - 4 > 0) {
            $page4left = ' <a href="?page=' . ($page - 4) . $cat . '">' . ($page - 4) . '</a> ';
        } else {
            $page4left = '';
        }
        if ($page - 3 > 0) {
            $page3left = ' <a href="?page=' . ($page - 3) . $cat . '">' . ($page - 3) . '</a> ';
        } else {
            $page3left = '';
        }
        if ($page - 2 > 0) {
            $page2left = ' <a href="?page=' . ($page - 2) . $cat . '">' . ($page - 2) . '</a> ';
        } else {
            $page2left = '';
        }
        if ($page - 1 > 0) {
            $page1left = ' <a href="?page=' . ($page - 1) . $cat . '">' . ($page - 1) . '</a> ';
        } else {
            $page1left = '';
        }

        if ($page + 5 <= $total_page) {
            $page5right = ' <a href="?page=' . ($page + 5) . $cat . '">' . ($page + 5) . '</a>';
        } else {
            $page5right = '';
        }
        if ($page + 4 <= $total_page) {
            $page4right = ' <a href="?page=' . ($page + 4) . $cat . '">' . ($page + 4) . '</a>';
        } else {
            $page4right = '';
        }
        if ($page + 3 <= $total_page) {
            $page3right = ' <a href="?page=' . ($page + 3) . $cat . '">' . ($page + 3) . '</a>';
        } else {
            $page3right = '';
        }
        if ($page + 2 <= $total_page) {
            $page2right = ' <a href="?page=' . ($page + 2) . $cat . '">' . ($page + 2) . '</a>';
        } else {
            $page2right = '';
        }
        if ($page + 1 <= $total_page) {
            $page1right = ' <a href="?page=' . ($page + 1) . $cat . '">' . ($page + 1) . '</a>';
        } else {
            $page1right = '';
        }

        if ($total_page > 1) {
            $page_nav_links = '&nbsp;&nbsp;&nbsp;' . $page5left . $page4left . $page3left . $page2left . $page1left . '<span class="total">' . $page . '</span>' . $page1right . $page2right . $page3right . $page4right . $page5right . '&nbsp;&nbsp;&nbsp;';
        } else {
            $page_nav_links = '';
        }

        $num_in_page = Kohana::$config->load('site.num_in_page');

        $pagination_data = array(
            'page' => $page,
            'total_page' => $total_page,
            'total' => $total,
            'num' => $num,
            'page_nav_links' => $page_nav_links,
        );

        return View::factory(Data::_('template_directory') . 'pagination2')
                        ->bind('pagination_data', $pagination_data)
                        ->bind('num_in_page', $num_in_page);
    }

    public static function admin_navigation($page, $total, $total_page, $num) {

        $pagination_data = array();
		
		$catid = Arr::get($_GET, 'cat', null);
		
		if($catid){
			$cat = '&cat='.$catid;
		} else {
			$cat = '';
		}

        if ($page != 1) {
            $previewpage = '<a href="?page=1' . $cat . '">Первая</a><a href="?page=' . ($page - 1) . $cat . '">Предидущая</a> ';
        } else {
            $previewpage = '';
        }
        
        if ($page != $total_page) {
            $nextpage = '<a href="?page=' . ($page + 1) . $cat . '">Следующая</a><a href="?page=' . $total_page . $cat . '">Последняя</a>';
        } else {
            $nextpage = '';
        }

       
        if ($page - 5 > 0) {
            $page5left = ' <a href="?page=' . ($page - 5) . $cat . '">' . ($page - 5) . '</a> ';
        } else {
            $page5left = '';
        }
        if ($page - 4 > 0) {
            $page4left = ' <a href="?page=' . ($page - 4) . $cat . '">' . ($page - 4) . '</a> ';
        } else {
            $page4left = '';
        }
        if ($page - 3 > 0) {
            $page3left = ' <a href="?page=' . ($page - 3) . $cat . '">' . ($page - 3) . '</a> ';
        } else {
            $page3left = '';
        }
        if ($page - 2 > 0) {
            $page2left = ' <a href="?page=' . ($page - 2) . $cat . '">' . ($page - 2) . '</a> ';
        } else {
            $page2left = '';
        }
        if ($page - 1 > 0) {
            $page1left = ' <a href="?page=' . ($page - 1) . $cat . '">' . ($page - 1) . '</a> ';
        } else {
            $page1left = '';
        }

        if ($page + 5 <= $total_page) {
            $page5right = ' <a href="?page=' . ($page + 5) . $cat . '">' . ($page + 5) . '</a>';
        } else {
            $page5right = '';
        }
        if ($page + 4 <= $total_page) {
            $page4right = ' <a href="?page=' . ($page + 4) . $cat . '">' . ($page + 4) . '</a>';
        } else {
            $page4right = '';
        }
        if ($page + 3 <= $total_page) {
            $page3right = ' <a href="?page=' . ($page + 3) . $cat . '">' . ($page + 3) . '</a>';
        } else {
            $page3right = '';
        }
        if ($page + 2 <= $total_page) {
            $page2right = ' <a href="?page=' . ($page + 2) . $cat . '">' . ($page + 2) . '</a>';
        } else {
            $page2right = '';
        }
        if ($page + 1 <= $total_page) {
            $page1right = ' <a href="?page=' . ($page + 1) . $cat . '">' . ($page + 1) . '</a>';
        } else {
            $page1right = '';
        }
		
        if ($total_page > 1) {
            $page_nav_links = '&nbsp;&nbsp;&nbsp;' . $page5left . $page4left . $page3left . $page2left . $page1left . '<span class="total">' . $page . '</span>' . $page1right . $page2right . $page3right . $page4right . $page5right . '&nbsp;&nbsp;&nbsp;';
        } else {
            $page_nav_links = '';
        }

        $num_in_page = Kohana::$config->load('site.num_in_page');

        $pagination_data = array(
            'page' => $page,
            'total_page' => $total_page,
            'total' => $total,
            'num' => $num,
            'page_nav_links' => $page_nav_links,
        );

        return View::factory('admin/pagination')
                        ->bind('pagination_data', $pagination_data)
                        ->bind('num_in_page', $num_in_page);
    }

    public static function admin_navigation2($page, $total, $total_page, $num) {

        $pagination_data = array();
		
		$catid = Arr::get($_GET, 'cat', null);
		
		if($catid){
			$cat = '&cat='.$catid;
		} else {
			$cat = '';
		}

        if ($page != 1) {
            $previewpage = '<a href="?page=1' . $cat . '">Первая</a><a href="?page=' . ($page - 1) . $cat . '">Предидущая</a> ';
        } else {
            $previewpage = '';
        }
        
        if ($page != $total_page) {
            $nextpage = '<a href="?page=' . ($page + 1) . $cat . '">Следующая</a><a href="?page=' . $total_page . $cat . '">Последняя</a>';
        } else {
            $nextpage = '';
        }

      
        if ($page - 5 > 0) {
            $page5left = ' <a href="?page=' . ($page - 5) . $cat . '">' . ($page - 5) . '</a> ';
        } else {
            $page5left = '';
        }
        if ($page - 4 > 0) {
            $page4left = ' <a href="?page=' . ($page - 4) . $cat . '">' . ($page - 4) . '</a> ';
        } else {
            $page4left = '';
        }
        if ($page - 3 > 0) {
            $page3left = ' <a href="?page=' . ($page - 3) . $cat . '">' . ($page - 3) . '</a> ';
        } else {
            $page3left = '';
        }
        if ($page - 2 > 0) {
            $page2left = ' <a href="?page=' . ($page - 2) . $cat . '">' . ($page - 2) . '</a> ';
        } else {
            $page2left = '';
        }
        if ($page - 1 > 0) {
            $page1left = ' <a href="?page=' . ($page - 1) . $cat . '">' . ($page - 1) . '</a> ';
        } else {
            $page1left = '';
        }

        if ($page + 5 <= $total_page) {
            $page5right = ' <a href="?page=' . ($page + 5) . $cat . '">' . ($page + 5) . '</a>';
        } else {
            $page5right = '';
        }
        if ($page + 4 <= $total_page) {
            $page4right = ' <a href="?page=' . ($page + 4) . $cat . '">' . ($page + 4) . '</a>';
        } else {
            $page4right = '';
        }
        if ($page + 3 <= $total_page) {
            $page3right = ' <a href="?page=' . ($page + 3) . $cat . '">' . ($page + 3) . '</a>';
        } else {
            $page3right = '';
        }
        if ($page + 2 <= $total_page) {
            $page2right = ' <a href="?page=' . ($page + 2) . $cat . '">' . ($page + 2) . '</a>';
        } else {
            $page2right = '';
        }
        if ($page + 1 <= $total_page) {
            $page1right = ' <a href="?page=' . ($page + 1) . $cat . '">' . ($page + 1) . '</a>';
        } else {
            $page1right = '';
        }

        if ($total_page > 1) {
            $page_nav_links = '&nbsp;&nbsp;&nbsp;' . $page5left . $page4left . $page3left . $page2left . $page1left . '<span class="total">' . $page . '</span>' . $page1right . $page2right . $page3right . $page4right . $page5right . '&nbsp;&nbsp;&nbsp;';
        } else {
            $page_nav_links = '';
        }

        $num_in_page = Kohana::$config->load('site.num_in_page');

        $pagination_data = array(
            'page' => $page,
            'total_page' => $total_page,
            'total' => $total,
            'num' => $num,
            'page_nav_links' => $page_nav_links,
        );

        return View::factory('admin/pagination2')
                        ->bind('pagination_data', $pagination_data)
                        ->bind('num_in_page', $num_in_page);
    }

}