<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * 
 * Постоение дерева (меню неограниченной вложености) 
 *   
 */
class Tree {
    private $_category_arr = array();
    private $_category_arr_all = array();
    private $_menu_arr = array();
    private $_menu_arr_all = array();
    private $_menu_arr_active = array();
	
    public function __construct() {
        //В переменную $_category_arr записываем все категории (см. ниже) 
        $this->_category_arr = $this->_getCategory();
        $this->_category_arr_all = $this->_getCategoryAll();
        $this->_menu_arr = $this->_getMenu();
        $this->_menu_arr_all = $this->_getMenuAll();
        $this->_menu_arr_active = $this->_getMenu_active();
        $this->_lang_edit = '<img src="/images/admin/edit_page.png" title="Редактировать" />';
        $this->_lang_delete = '<img src="/images/admin/delete_page.png" title="Удалить" />';
    }
	
	public function get_content_category($id) {
        $query = DB::query(Database::SELECT, "SELECT * FROM `categories` WHERE `id` = :id", FALSE)
                ->param(':id', (int) $id);
        $result = $query->execute();
		
		$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `contents_descriptions` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'categories',
                        ))->execute();
						
		if(count($lang_result)>0){
			foreach($lang_result as $value){
				$descriptions[$value['lang_id']] = array(
					'title' => $value['content_title'],
					'teaser' => $value['content_teaser'],
					'body' => $value['content_body'],
				);
			}
		}
		
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
			if(!isset($descriptions[$value['lang_id']])){
				$descriptions[$value['lang_id']] = array(
					'title' => '',
					'teaser' => '',
					'body' => '',
				);
			}
		}
		
		$contents = array(
			'id' => $result[0]['id'],
			'parent_id' => $result[0]['parent_id'],
			'descriptions' => $descriptions,
			'alias' => $result[0]['alias'],
			'dictionary_id' => $result[0]['dictionary_id'],
			'weight' => $result[0]['weight'],
		);
        if ($result)
            return $contents;
        else
            return FALSE;
    }
	
	public function get_content_menu($id) {
        $query = DB::query(Database::SELECT, "SELECT * FROM `menu` WHERE `id` = :id", FALSE)
                ->param(':id', (int) $id);
        $result = $query->execute();
		
		$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `contents_descriptions` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'menu',
                        ))->execute();
						
		if(count($lang_result)>0){
			foreach($lang_result as $value){
				$descriptions[$value['lang_id']] = array(
					'title' => $value['content_title'],
					'teaser' => $value['content_teaser'],
					'body' => '',
				);
			}
		}
		
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
			if(!isset($descriptions[$value['lang_id']])){
				$descriptions[$value['lang_id']] = array(
					'title' => '',
					'teaser' => '',
					'body' => '',
				);
			}
		}
		
		$contents = array(
			'id' => $result[0]['id'],
			'content_id' => $result[0]['content_id'],
			'parent_id' => $result[0]['parent_id'],
			'descriptions' => $descriptions,
			'url' => $result[0]['url'],
			'dictionary_id' => $result[0]['dictionary_id'],
			'weight' => $result[0]['weight'],
			'status' => $result[0]['status'],
			'module' => $result[0]['module'],
		);
        if ($result)
            return $contents;
        else
            return FALSE;
    }
    /**
     * Метод читает из таблицы category все сточки, и  
     * возвращает двумерный массив, в котором первый ключ - id - родителя  
     * категории (parent_id) 
     * @return Array  
     */
    private function _getCategory() {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `categories` ORDER BY `weight`')
                ->execute();
        $result = $query->as_array();
        //Перелапачиваем массим (делаем из одномерного массива - двумерный, в котором  
        //первый ключ - parent_id) 
        $return = array();
        foreach ($result as $value) { //Обходим массив 
            $return[$value['dictionary_id']][$value['parent_id']][] = $this->get_content_category($value['id']);
        }	
        return $return;
    }
    
    private function _getCategoryAll() {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `categories` ORDER BY `weight`')
                ->execute();
        $result = $query->as_array();
        //Перелапачиваем массим (делаем из одномерного массива - двумерный, в котором  
        //первый ключ - parent_id) 
        $return = array();
        foreach ($result as $value) { //Обходим массив 
            $return[$value['parent_id']][] = $this->get_content_category($value['id']);
        }
        return $return;
    }
    
    /**
     * Метод читает из таблицы menu все сточки, и  
     * возвращает двумерный массив, в котором первый ключ - id - родителя  
     * категории (parent_id) 
     * @return Array  
     */
    private function _getMenu() {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `menu` ORDER BY `weight`')
                ->execute();
        $result = $query->as_array();
        //Перелапачиваем массим (делаем из одномерного массива - двумерный, в котором  
        //первый ключ - parent_id) 
        $return = array();
        foreach ($result as $value) { //Обходим массив 
            $return[$value['dictionary_id']][$value['parent_id']][] = $this->get_content_menu($value['id']);
        }
        return $return;
    }
    
    private function _getMenuAll() {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `menu` ORDER BY `weight`')
                ->execute();
        $result = $query->as_array();
        //Перелапачиваем массим (делаем из одномерного массива - двумерный, в котором  
        //первый ключ - parent_id) 
        $return = array();
        foreach ($result as $value) { //Обходим массив 
            $return[$value['parent_id']][] = $this->get_content_menu($value['id']);
        }
        return $return;
    }
    
    private function _getMenu_active() {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `menu` WHERE `status` = 1 ORDER BY `weight`')
                ->execute();
        $result = $query->as_array();
        //Перелапачиваем массим (делаем из одномерного массива - двумерный) 
        $return = array();
        foreach ($result as $value) { //Обходим массив 
            $return[$value['dictionary_id']][$value['parent_id']][] = $this->get_content_menu($value['id']);
        }
        return $return;
    }
    
    
    /**
     * Вывод дерева 
     * @param Integer $parent_id - id-родителя 
     * @param Integer $level - уровень вложености 
     */
    public function outMenuTree($parent_id, $level) {
        $return = array();
        if (isset($this->_menu_arr_all[$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->_menu_arr_all[$parent_id] as $key => $value) { //Обходим ее 
                $return[$value['id']] = array(
                    'id' => $value['id'],
                    'content_id' => $value['content_id'],
                    'module' => $value['module'],
                    'parent_id' => $value['parent_id'],
                    'descriptions' => $value['descriptions'],
                    'level' => $level,
                    'url' => $value['url'],
                    'dictionary_id' => $value['dictionary_id'],
                );
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $return = array_merge($return,$this->outMenuTree($value['id'], $level));
                $level--; //Уменьшаем уровень вложености 
            }
        }
        return $return;
    }
    public function selectOutMenuTree($dictionary_id, $parent_id, $level, $parent = false) {
        if (isset($this->_menu_arr[$dictionary_id][$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->_menu_arr[$dictionary_id][$parent_id] as $key => $value) { //Обходим ее 
                if (is_array($parent)) {
                    if (isset($parent[$value['id']]['category_id'])) {
                        echo "<option value='" . $value['id'] . "' selected='selected'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    } else {
                        echo "<option value='" . $value['id'] . "'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    }
                } else {
                    if ($value['id'] == $parent) {
                        echo "<option value='" . $value['id'] . "' selected='selected'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    } else {
                        echo "<option value='" . $value['id'] . "'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    }
                }
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->selectOutMenuTree($dictionary_id, $value['id'], $level, $parent);
                $level--; //Уменьшаем уровень вложености 
            }
        }
    }
    public function tableOutMenuTree($dictionary_id, $parent_id, $level) {
		$languages = Kohana::$config->load('language');
        if (isset($this->_menu_arr[$dictionary_id][$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->_menu_arr[$dictionary_id][$parent_id] as $key => $value) { //Обходим ее 
                if ($level <= 1) {
                    $color = '4d52b3';
                } elseif ($level == 2) {
                    $color = 'b34d59';
                } elseif ($level == 3) {
                    $color = '4db35e';
                } elseif ($level >= 4) {
                    $color = 'd98c41';
                }
                
                if ($value['status']){
                    $text_decoration = 'none';
                }else{
                    $text_decoration = 'line-through';
                }
                echo "<tr>
                        <td class='first'>";
				if(count($languages)>1){
					foreach ($languages as $item){
						echo "<input type='text' style='margin-left:" . ($level * 25) . "px; color:#" . $color . "; text-decoration:".$text_decoration."' id='name_input_lang_".$item['lang_id']."' name='descriptions[".$value['id']."][".$item['lang_id']."][title]' value='" . $value['descriptions'][$item['lang_id']]['title'] . "' class='text'>".$item['icon'];
					}
				} else {
					echo "<input type='text' style='margin-left:" . ($level * 25) . "px; color:#" . $color . "; text-decoration:".$text_decoration."' name='descriptions[".$value['id']."][1][title]' value='".$value['descriptions'][1]['title']."' class='text'>";
				}
					echo "</td>
                        <td><input type='text' name='url[" . $value['id'] . "]' class='text' value='" . $value['url'] . "'></td>
                        <td class='last'>";
                            if ($value['status']){
                                echo "<input type='checkbox' onclick='checkboxStatus(" . $value['id'] . ");' id='status_" . $value['id'] . "' checked value='1'>";
                            }else{
                                echo "<input type='checkbox' onclick='checkboxStatus(" . $value['id'] . ");' id='status_" . $value['id'] . "' value='1'>";
                            }
                  echo "</td>
                      <input type='hidden' name='status[" . $value['id'] . "]' id='statusfield_" . $value['id'] . "' value=''>
                        <script>
                        $(document).ready(function(){
                            checkboxStatus(" . $value['id'] . ");
                        });
                        </script>
						<td class='last'><input type='text' name='weight[" . $value['id'] . "]' class='text short' value='" . $value['weight'] . "'></td>
                        <td class='last'><a href='/admin/menu/edit/" . $value['id'] . "' class='edit'>" . $this->_lang_edit . "</a>&nbsp;&nbsp;<a href='/admin/menu/delete/" . $value['id'] . "' class='delete'>" . $this->_lang_delete . "</a></td>
                     </tr>";
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->tableOutMenuTree($dictionary_id, $value['id'], $level);
                $level--; //Уменьшаем уровень вложености 
            }
        }
    }
    public function listOutMenuTree($dictionary_id, $parent_id, $level, $url) {
        if (isset($this->_menu_arr_active[$dictionary_id][$parent_id])) { //Если категория с таким parent_id существует 
            
            if ($level == 1){
                echo "<ul class='menu'>";
            }else {
                echo "<ul>";
            }
            
            foreach ($this->_menu_arr_active[$dictionary_id][$parent_id] as $key => $value) { //Обходим ее 
                /**
                 * Выводим категорию  
                 *  $level - хранит текущий уровень вложености (0,1,2..) 
                 */
                    
                $url_array = explode('/', $url);
                $url_real_array = explode('/', $value['url']);
                if (!$key) {
                    $class = 'first';
                }else{
                    $class = '';
                }
                if ($url_real_array[1] == $url_array[1]) {
                    $class .= ' active';
                }else{
                    $class .= '';
                }
                echo "<li class='menu_level_".$level."'><a href='" . $value['url'] . "' class='" . $class . "'>" . $value['descriptions'][1]['title'] . "</a>";
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->listOutMenuTree($dictionary_id, $value['id'], $level, $url);
                $level--; //Уменьшаем уровень вложености
                
                echo "</li>";
            }
            echo "</ul>";
        }
    }
    
    /**
     * Вывод дерева 
     * @param Integer $parent_id - id-родителя 
     * @param Integer $level - уровень вложености 
     */
    public function outTree($parent_id, $level) {
        $return = array();
        if (isset($this->_category_arr_all[$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->_category_arr_all[$parent_id] as $key => $value) { //Обходим ее 
                $return[$value['id']] = array(
                    'id' => $value['id'],
                    'parent_id' => $value['parent_id'],
                    'descriptions' => $value['descriptions'],
                    'level' => $level,
                    'alias' => $value['alias'],
                    'dictionary_id' => $value['dictionary_id'],
                );
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                
                $return = array_merge($return,$this->outTree($value['id'], $level));
                $level--; //Уменьшаем уровень вложености 
            }
        }
        return $return;
    }
    public function selectOutTree($dictionary_id, $parent_id, $level, $parent = false) {
        if (isset($this->_category_arr[$dictionary_id][$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->_category_arr[$dictionary_id][$parent_id] as $key => $value) { //Обходим ее 
                if (is_array($parent)) {
                    if (isset($parent[$value['id']])) {
                        echo "<option value='" . $value['id'] . "' selected='selected'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    } else {
                        echo "<option value='" . $value['id'] . "'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    }
                } else {
                    if ($value['id'] == $parent) {
                        echo "<option value='" . $value['id'] . "' selected='selected'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    } else {
                        echo "<option value='" . $value['id'] . "'>" . str_repeat('-&nbsp;', $level) . htmlspecialchars($value['descriptions'][1]['title']) . "</option>";
                    }
                }
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->selectOutTree($dictionary_id, $value['id'], $level, $parent);
                $level--; //Уменьшаем уровень вложености 
            }
        }
    }
    public function tableOutTree($dictionary_id, $parent_id, $level) {
		$languages = Kohana::$config->load('language');
        if (isset($this->_category_arr[$dictionary_id][$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->_category_arr[$dictionary_id][$parent_id] as $key => $value) { //Обходим ее 
                if ($level <= 1) {
                    $color = '4d52b3';
                } elseif ($level == 2) {
                    $color = 'b34d59';
                } elseif ($level == 3) {
                    $color = '4db35e';
                } elseif ($level >= 4) {
                    $color = 'd98c41';
                }
                echo "<tr>
                        <td class='first'>";
				if(count($languages)>1){
					foreach ($languages as $item){
						echo "<input type='text' style='margin-left:" . ($level * 25) . "px; color:#" . $color . "' id='name_input_lang_".$item['lang_id']."' name='descriptions[".$value['id']."][".$item['lang_id']."][title]' value='" . $value['descriptions'][$item['lang_id']]['title'] . "' class='text'>".$item['icon'];
					}
				} else {
					echo "<input type='text' style='margin-left:" . ($level * 25) . "px; color:#" . $color . "' name='descriptions[".$value['id']."][1][title]' value='".$value['descriptions'][1]['title']."' class='text'>";
				}
				echo "
                        <td><input type='text' name='alias[" . $value['id'] . "]' class='text' value='" . $value['alias'] . "'></td>
						<td class='last'><input type='text' name='weight[" . $value['id'] . "]' class='text short' value='" . $value['weight'] . "'></td>
                        <td class='last'><a href='/admin/categories/edit/" . $value['id'] . "' class='edit'>" . $this->_lang_edit . "</a>&nbsp;&nbsp;<a href='/admin/categories/delete/" . $value['id'] . "' class='delete'>" . $this->_lang_delete . "</a></td>
                     </tr>";
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->tableOutTree($dictionary_id, $value['id'], $level);
                $level--; //Уменьшаем уровень вложености 
            }
        }
    }
    public function xlsExampleOutTree($dictionary_id, $parent_id, $level) {
        if (isset($this->_category_arr[$dictionary_id][$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->_category_arr[$dictionary_id][$parent_id] as $key => $value) { //Обходим ее 
                if ($level <= 1) {
                    $color = '4d52b3';
                } elseif ($level == 2) {
                    $color = 'b34d59';
                } elseif ($level == 3) {
                    $color = '4db35e';
                } elseif ($level >= 4) {
                    $color = 'd98c41';
                }
                echo "<tr>
				        <td class='first'>" . $value['id'] . "</td>
                        <td class='first'><span style='margin-left:" . ($level * 25) . "px; color:#" . $color . "'>" . $value['descriptions'][1]['title'] . "</span></td>
                    </tr>";
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->xlsExampleOutTree($dictionary_id, $value['id'], $level);
                $level--; //Уменьшаем уровень вложености 
            }
        }
    }
    public function listOutTree($dictionary_id, $parent_id, $level) {
        if (isset($this->_category_arr[$dictionary_id][$parent_id])) { //Если категория с таким parent_id существует 
            $i = 0;
            $i = count($this->_category_arr[$dictionary_id][$parent_id]);
            foreach ($this->_category_arr[$dictionary_id][$parent_id] as $key => $value) { //Обходим ее 
                /**
                 * Выводим категорию  
                 *  $level - хранит текущий уровень вложености (0,1,2..) 
                 */
                if ($level == 1 && $key == 0) {
                    $class = 'menu_one_level';
                    $tags_in = '<li class="menu_one_level">';
                    $tags_out = '';
                } elseif ($level == 1 && $key != 0) {
                    $class = 'menu_one_level';
                    $tags_in = '</li><li class="menu_one_level">';
                    $tags_out = '';
                } elseif ($level == 2 && $key == 0) {
                    $class = 'menu_two_level';
                    $tags_in = '<ul><li class="menu_two_level">';
                    $tags_out = '';
                } elseif ($level == 2 && $key == ($i - 1)) {
                    $class = 'menu_two_level';
                    $tags_in = '</li><li class="menu_two_level">';
                    $tags_out = '</li></ul>';
                } elseif ($level == 2 && $key != ($i - 1) && $key != 0) {
                    $class = 'menu_two_level';
                    $tags_in = '</li><li class="menu_two_level">';
                    $tags_out = '';
                }
                echo $tags_in . "<a href='/products/" . $value['id'] . "' class='edit'>" . $value['descriptions'][1]['title'] . "</a>" . $tags_out;
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->listOutTree($dictionary_id, $value['id'], $level);
                $level--; //Уменьшаем уровень вложености 
            }
        }
    }
}