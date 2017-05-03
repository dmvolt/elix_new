<?php

defined('SYSPATH') or die('No direct script access.');

class Specials {

    public static function specials_block($num = 6) {
        $content = View::factory(Data::_('template_directory') . 'specials-block')
                ->bind('specials', $specials);

        $specials_obj = new Model_Specials();
        $specials = $specials_obj->get_last($num);

        return $content;
    }

}

// Specials