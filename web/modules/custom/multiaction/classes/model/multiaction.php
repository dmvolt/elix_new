<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Multiaction {

	protected $tableDesc = 'contents_descriptions';
	
    public function get_all($module, $parameters) {
	
        if ($parameters == '') {
            $result = DB::query(Database::SELECT, "SELECT id FROM " . $module)->execute();
        } else {
            $result = DB::query(Database::SELECT, 'SELECT a.id FROM `contents_categories` cc INNER JOIN ' . $module . ' a ON cc.content_id = a.id  WHERE cc.category_id = :category_id AND cc.module = :module LIMIT :start, :num')
                    ->parameters(array(
                        ':category_id' => $parameters,
                        ':module' => $module,
                        ':start' => 0,
                        ':num' => 100,
                    ))
                    ->execute();
        }
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
    
    public function new_title($descriptions, $module) {
        if (is_array($descriptions)) {
            foreach ($descriptions as $id => $item) {
				foreach($item as $lang_id => $value){
					$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
							->parameters(array(
								':lang_id' => $lang_id,
								':content_id' => $id,
								':module' => $module,
							))->execute();
							
					if(count($result)>0){
						DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
						->parameters(array(
							':content_id' => (int) $id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':module' => $module,
						))
						->execute();
					} else {
						DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
							->parameters(array(
								':content_id' => (int) $id,
								':lang_id' => $lang_id,
								':content_title' => Security::xss_clean($value['title']),
								':content_teaser' => '',
								':content_body' => '',
								':module' => $module,
							))
							->execute();
					}
					
				}
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_name($name, $module) {
        if (is_array($name)) {
            foreach ($name as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `name` = :name WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':name' => $value,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_url($url, $module) {
        if (is_array($url)) {
            foreach ($url as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `url` = :url WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':url' => $value,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_alias($alias, $module) {
        if (is_array($alias)) {
            foreach ($alias as $id => $value) {
                if ($this->unique_alias($value, $module)) {
                    DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `alias` = :alias WHERE `id` = :id')
                            ->parameters(array(
                                ':id' => $id,
                                ':alias' => $value,
                            ))
                            ->execute();
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_sku($sku, $module) {
        if (is_array($sku)) {
            foreach ($sku as $id => $value) {
                if ($this->unique_sku($value, $module)) {
                    DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `sku` = :sku WHERE `id` = :id')
                            ->parameters(array(
                                ':id' => $id,
                                ':sku' => $value,
                            ))
                            ->execute();
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_price($price, $module) {
        if (is_array($price)) {
            foreach ($price as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `price` = :price WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':price' => $value,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function new_old_price($price, $module) {
        if (is_array($price)) {
            foreach ($price as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `old_price` = :price WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':price' => $value,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_new_price($new_price, $module) {
        if (is_array($new_price)) {
            foreach ($new_price as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `new_price` = :new_price WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':new_price' => $value,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_quantity($quantity, $module) {
        if (is_array($quantity)) {
            foreach ($quantity as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `quantity` = :quantity WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':quantity' => $value,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function new_sort($weight, $module) {
        if (is_array($weight)) {
            foreach ($weight as $id => $sort) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `weight` = :sort WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':sort' => $sort,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function new_status($status, $module) {
        if ($status AND is_array($status)) {
            foreach ($status as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `' . $module . '` SET `status` = :status WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':status' => $value,
                        ))
                        ->execute();
                DB::query(Database::UPDATE, 'UPDATE `menu` SET `status` = :status WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
                            ':module' => $module,
                            ':status' => $value,
                        ))
                        ->execute();
            }
            return true;
        } else {
            return FALSE;
        }
    }
    
    public function new_product_sku($product_sku, $order_id) {
        if (is_array($product_sku)) {
            foreach ($product_sku as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `order_product` SET `product_sku` = :product_sku WHERE `product_id` = :id AND `order_id` = :order_id')
                        ->parameters(array(
                            ':id' => $id,
                            ':product_sku' => $value,
                            ':order_id' => $order_id,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_product_title($product_title, $order_id) {
        if (is_array($product_title)) {
            foreach ($product_title as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `order_product` SET `product_title` = :product_title WHERE `product_id` = :id AND `order_id` = :order_id')
                        ->parameters(array(
                            ':id' => $id,
                            ':product_title' => $value,
                            ':order_id' => $order_id,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_product_options($product_options, $order_id) {
        if (is_array($product_options)) {
            foreach ($product_options as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `order_product` SET `product_options` = :product_options WHERE `product_id` = :id AND `order_id` = :order_id')
                        ->parameters(array(
                            ':id' => $id,
                            ':product_options' => $value,
                            ':order_id' => $order_id,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_product_price($product_price, $order_id) {
        if (is_array($product_price)) {
            foreach ($product_price as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `order_product` SET `product_price` = :product_price WHERE `product_id` = :id AND `order_id` = :order_id')
                        ->parameters(array(
                            ':id' => $id,
                            ':product_price' => $value,
                            ':order_id' => $order_id,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_product_qty($product_qty, $order_id) {
        
        if (is_array($product_qty)) {
            foreach ($product_qty as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `order_product` SET `product_qty` = :product_qty WHERE `product_id` = :id AND `order_id` = :order_id')
                        ->parameters(array(
                            ':id' => $id,
                            ':product_qty' => $value,
                            ':order_id' => $order_id,
                        ))
                        ->execute();
                
                $result = DB::query(Database::SELECT, 'SELECT `reserved`, `quantity` FROM `products` WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                        ))->execute();
                
                DB::query(Database::UPDATE, 'UPDATE `products` SET  `reserved` = :reserved, quantity = :quantity WHERE `id` = :id')
                        ->parameters(array(
                            ':id' => $id,
                            ':reserved' => $value,
                            ':quantity' => ($result[0]['reserved'] + $result[0]['quantity']) - $value,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function new_product_total($product_total, $order_id) {
        if (is_array($product_total)) {
            foreach ($product_total as $id => $value) {
                DB::query(Database::UPDATE, 'UPDATE `order_product` SET `product_total` = :product_total WHERE `product_id` = :id AND `order_id` = :order_id')
                        ->parameters(array(
                            ':id' => $id,
                            ':product_total' => $value,
                            ':order_id' => $order_id,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function unique_alias($alias, $module) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from($module)
                        ->where('alias', '=', $alias)
                        ->execute()
                        ->get('total');
    }
    public function unique_sku($sku, $module) {
        return !DB::select(array(DB::expr('COUNT(sku)'), 'total'))
                        ->from($module)
                        ->where('sku', '=', $sku)
                        ->execute()
                        ->get('total');
    }
}