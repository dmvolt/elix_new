<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Multiaction extends Controller {

    public function action_update() {
	
        $multiaction_obj = new Model_Multiaction();
        
        $descriptions = Arr::get($_POST, 'descriptions', null);
        $name = Arr::get($_POST, 'name', null);
        $url = Arr::get($_POST, 'url', null);
        $alias = Arr::get($_POST, 'alias', null);
        $sku = Arr::get($_POST, 'sku', null);
        $price = Arr::get($_POST, 'price', null);
		$old_price = Arr::get($_POST, 'old_price', null);
        $new_price = Arr::get($_POST, 'new_price', null);
        $quantity = Arr::get($_POST, 'quantity', null);
        $status = Arr::get($_POST, 'status', null);
        $weight = Arr::get($_POST, 'weight', null);
        $module = Arr::get($_POST, 'module', null);
        $parameters = Arr::get($_POST, 'parameters', '');
		
        if ($descriptions) {
            $multiaction_obj->new_title($descriptions, $module);
        }
        
        if ($name) {
            $multiaction_obj->new_name($name, $module);
        }
        
        if ($url) {
            $multiaction_obj->new_url($url, $module);
        }
        
        if ($alias) {
            $multiaction_obj->new_alias($alias, $module);
        }
        
        if ($sku) {
            $multiaction_obj->new_sku($sku, $module);
        }
        
        if ($price) {
            $multiaction_obj->new_price($price, $module);
        }
		
		if ($old_price) {
            $multiaction_obj->new_old_price($old_price, $module);
        }
        
        if ($new_price) {
            $multiaction_obj->new_new_price($new_price, $module);
        }
        
        if ($quantity) {
            $multiaction_obj->new_quantity($quantity, $module);
        }
        
        if ($status) {
            $multiaction_obj->new_status($status, $module);
        }
        
        if($weight){
            $multiaction_obj->new_sort($weight, $module);
        }
        Request::initial()->redirect('admin/' . $module . $parameters);
    }
}