<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Orders {

    protected $tableName = 'order';
    protected $tableName3 = 'order_product';
	
	protected $default_order_status = 2; /* Принят (зарезервирован) */
	 
    protected $session;

    public function __construct() {
        $this->session = Session::instance();
    }
	
	public function getErrors() {
        return $this->errors;
    }

    public function add_order($data = array(), $cartinfo = false) {
	
        $sertifications_obj = new Model_Sertifications();
		
		$siteinfo_obj = new Model_Siteinfo();
		//$group_attributes = Kohana::$config->load('attributes.group_attributes');

        $order_result = DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableName . '` (order_date, order_time, name, phone, email, order_status, order_shipping, order_payment, street, house, housing, houseroom, order_total) VALUES (:order_date, :order_time, :name, :phone, :email, :order_status, :order_shipping, :order_payment, :street, :house, :housing, :houseroom, :order_total)')
                ->parameters(array(
					':order_date' => date('Y-m-d'),
					':order_time' => date('h:i'),
                    ':name' => $data['name'],
					':phone' => $data['phone'],
					':email' => $data['email'],
					':order_shipping' => $data['shipping'],
					':order_payment' => $data['payment'],
					':order_status' => $this->default_order_status,
					
					':street' => $data['street'],
					':house' => $data['house'],
					':housing' => $data['housing'],
					':houseroom' => $data['houseroom'],
					
					':order_total' => $data['total'],
                ))->execute();

        if ($order_result) {
		
            $order_id = $order_result[0];

            if ($cartinfo) {
                foreach ($cartinfo as $product_code => $item) {
					
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableName3 . '` (order_id, product_id, product_code, product_title, product_price, product_qty, product_total) VALUES (:order_id, :product_id, :product_code, :product_title, :product_price, :product_qty, :product_total)')
							->parameters(array(
								':order_id' => $order_id,
								':product_id' => $item['product_info']['id'],
								':product_code' => $item['product_code'],
								':product_title' => $item['product_info']['descriptions'][1]['title'],
								':product_price' => $item['price'],
								':product_qty' => $item['qty'],
								':product_total' => $item['total'],
							))->execute();                    
                }           
            }
			
			/* $data['content'] = $this->get_order($order_id);
			$data['order'] = Kohana::$config->load('admin/order');
			$mail_body = View::factory('admin/order_mail_body', $data);
		
            $info = $siteinfo_obj->get_siteinfo(1); */

            /* Письмо админу */
/* 			$from = $info['email'];
			$to = $info['email'];
			$subject = 'Новый заказ';
			$message = $mail_body;

			$headers = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "From: <" . $from . ">\r\n";

			mail($to, $subject, $message, $headers);
 */
            return $order_id;
        } else {
            return false;
        }
    }

    public function get_all_orders($filter = array()) {
		$sertifications_obj = new Model_Sertifications();
        $contents = array();
		$order_products = array();
        $filter_str = '';

        if (!empty($filter['order_id']) AND $filter['order_id']) {
            $filter_str = 'WHERE id = ' . $filter['order_id'];
        } elseif ($filter['order_status']) {
            $filter_str = 'WHERE order_status = ' . $filter['order_status'];
        }

        $result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` ' . $filter_str . ' ORDER BY order_date DESC')->execute();

        if (count($result) > 0) {
            foreach ($result as $res) {
                $result2 = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName3 . '` WHERE `order_id` = :order_id')
                        ->parameters(array(
                            ':order_id' => (int) $res['id'],
                        ))->execute();

                foreach ($result2 as $res2) {
                    $product_info = $sertifications_obj->get_content($res2['product_id']);
					
                    $order_products[] = array(
                        'order_id' => $res2['order_id'],
                        'product_id' => $res2['product_id'],
                        'product_title' => $res2['product_title'],
						'product_code' => $res2['product_code'],
                        'product_price' => $res2['product_price'],
                        'product_qty' => $res2['product_qty'],
                        'product_info' => $product_info,
                        'product_total' => $res2['product_total'],
                    );
                }
				
				$contents[] = array(
					'id' => $res['id'],
					'order_date' => $res['order_date'],
					'order_time' => $res['order_time'],
					'order_status' => $res['order_status'],
					'order_shipping' => $res['order_shipping'],
					'order_payment' => $res['order_payment'],
					
					'name' => $res['name'],
					'phone' => $res['phone'],
					'email' => $res['email'],
					
					'street' => $res['street'],
					'house' => $res['house'],
					'housing' => $res['housing'],
					'houseroom' => $res['houseroom'],
					
					'order_total' => $res['order_total'],
					'order_products' => $order_products,
				);
				$order_products = array();
            }
        }
        return $contents;
    }

    public function get_order($order_id) {
		$sertifications_obj = new Model_Sertifications();
        $contents = array();
        $order_products = array();

        $result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `id` = ' . $order_id)->execute();

        if (count($result) > 0) {
			$result2 = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName3 . '` WHERE `order_id` = :order_id')
					->parameters(array(
						':order_id' => (int) $result[0]['id'],
					))->execute();

			foreach ($result2 as $res2) {
			
				$product_info = $sertifications_obj->get_content($res2['product_id']);
				
				$order_products[] = array(
					'order_id' => $res2['order_id'],
					'product_id' => $res2['product_id'],
					'product_title' => $res2['product_title'],
					'product_code' => $res2['product_code'],
					'product_price' => $res2['product_price'],
					'product_qty' => $res2['product_qty'],
					'product_info' => $product_info,
					'product_total' => $res2['product_total'],
				);
			}
			
			$contents = array(
				'id' => $result[0]['id'],
				'order_date' => $result[0]['order_date'],
				'order_time' => $result[0]['order_time'],
				'order_status' => $result[0]['order_status'],
				'order_shipping' => $result[0]['order_shipping'],
				'order_payment' => $result[0]['order_payment'],
				
				'name' => $result[0]['name'],
				'phone' => $result[0]['phone'],
				'email' => $result[0]['email'],
			
				'street' => $result[0]['street'],
				'house' => $result[0]['house'],
				'housing' => $result[0]['housing'],
				'houseroom' => $result[0]['houseroom'],
				
				'order_total' => $result[0]['order_total'],
				'order_products' => $order_products,
			);
        }
        return $contents;
    }
	
	
	public function edit_order_status($data) {
        DB::query(Database::UPDATE, 'UPDATE `' . $this->tableName . '` SET `order_status` = :order_status WHERE `id` = :order_id')
                ->parameters(array(
                    ':order_id' => $data['order_id'],
                    ':order_status' => $data['order_status'],
                ))->execute();
		return true;
    }
    
    public function edit_order_shipping($data) {
        DB::query(Database::UPDATE, 'UPDATE `' . $this->tableName . '` SET `order_shipping` = :order_shipping WHERE `id` = :order_id')
                ->parameters(array(
                    ':order_id' => $data['order_id'],
                    ':order_shipping' => $data['order_shipping'],
                ))->execute();
        return true;
    }
    
    public function edit_order_payment($data) {
        DB::query(Database::UPDATE, 'UPDATE `' . $this->tableName . '` SET `order_payment` = :order_payment WHERE `id` = :order_id')
                ->parameters(array(
                    ':order_id' => $data['order_id'],
                    ':order_payment' => $data['order_payment'],
                ))->execute();
        return true;
    }
	
	public function delete($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM `' . $this->tableName . '` WHERE `id` = :id')
                ->param(':id', $id)
                ->execute();

        DB::query(Database::DELETE, 'DELETE FROM `' . $this->tableName3 . '` WHERE `order_id` = :order_id')
                ->parameters(array(
                    ':order_id' => $id,
                ))->execute();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}