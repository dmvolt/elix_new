<?php

defined('SYSPATH') or die('No direct script access.');

class Data extends Controller {

    public static function _($key) {
		return parent::$privat_data[$key];
    }

}