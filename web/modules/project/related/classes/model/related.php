<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Related {

    protected $tableName = 'related';
    protected $tableName2 = 'contents_related';

    public function add($Id, $related_str = '') {
        $related_str = trim($related_str);
        $data = ($related_str == "") ? array() : explode(",", $related_str);  /* Преобразование строки значений, разделенных запятыми (в данном случае) в массив */

        if ($data === FALSE) {
            $data = array();
        }
		
		$this->delete($Id);

        if (count($data) > 0) {

            foreach ($data as $sku) {

                if ($this->unique_rel(trim($sku))) {

                    DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (sku) VALUES (:sku)')
                            ->parameters(array(
                                ':sku' => Security::xss_clean(trim($sku)),
                            ))
                            ->execute();

                    $query = DB::query(Database::SELECT, 'SELECT id FROM ' . $this->tableName . ' WHERE sku = :sku') /* Узнаем id только что добавленного */
                            ->parameters(array(
                                ':sku' => Security::xss_clean(trim($sku))
                            ))
                            ->execute();

                    $result = $query->as_array();

                    DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (product_id, related_id) VALUES (:product_id, :related_id)')
                            ->parameters(array(
                                ':product_id' => $Id,
                                ':related_id' => $result[0]['id'],
                            ))
                            ->execute();
                } else {

                    $query = DB::query(Database::SELECT, 'SELECT id FROM ' . $this->tableName . ' WHERE sku = :sku') /* Узнаем id */
                            ->parameters(array(
                                ':sku' => Security::xss_clean(trim($sku))
                            ))
                            ->execute();

                    $result = $query->as_array();

                    $query2 = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE product_id = :product_id AND related_id = :related_id') /* Узнаем, принадлежит ли данный товар к рекомендуемому */
                            ->parameters(array(
                                ':product_id' => $Id,
                                ':related_id' => $result[0]['id'],
                            ))
                            ->execute();

                    if (count($query2) == 0) {

                        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (product_id, related_id) VALUES (:product_id, :related_id)')
                                ->parameters(array(
                                    ':product_id' => $Id,
                                    ':related_id' => $result[0]['id'],
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

    public function delete($Id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `product_id` = :product_id')
                ->parameters(array(
                    ':product_id' => $Id,
                ))
                ->execute();

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_related_to_content($Id, $adminka = 0) {
        if ($adminka) {

            $related = '';
            $query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `product_id` = :product_id", FALSE)
                    ->parameters(array(
                        ':product_id' => $Id,
                    ))
                    ->execute();

            if ($query) {
                $result = $query->as_array();

                foreach ($result as $key => $tag) {
                    $query2 = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :related_id", FALSE)
                            ->param(':related_id', $tag['related_id'])
                            ->execute();

                    $result2 = $query2->as_array();

                    if (!$key) {
                        $related .= $result2[0]['sku'];
                    } else {
                        $related .= ', ' . $result2[0]['sku'];
                    }
                }
            }
            return $related;
        } else {
		
            $related = array();
            $query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `product_id` = :product_id", FALSE)
                    ->parameters(array(
                        ':product_id' => $Id,
                    ))
                    ->execute();

            if ($query) {
                $result = $query->as_array();

                foreach ($result as $tag) {
                    $query2 = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :related_id", FALSE)
                            ->param(':related_id', $tag['related_id'])
                            ->execute();

                    $result2 = $query2->as_array();

                    $related[] = array(
						'id' => $result2[0]['id'],
						'code' => $result2[0]['sku'],
					);
                }
            }
            return $related;
        }
    }

    public function unique_rel($sku) {
        return !DB::select(array(DB::expr('COUNT(sku)'), 'total'))
                        ->from($this->tableName)
                        ->where('sku', '=', $sku)
                        ->execute()
                        ->get('total');
    }
}