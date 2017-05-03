<?php
defined('SYSPATH') or die('No direct script access');
return array(
    'title' => '',
    'description' => '',
    'slogan' => '',
    'logo' => '<a href='.FULLURL.' class="header__nav__logo js-logo"><img src="'.PARENT_FULLURL.'/images/logo.png" alt=""/></a>',
    'copyright' => ' ' . date('Y') . 'г.',
    'prodigy' => '<a href="http://vadimdesign.ru" class="creator">Сайт разработан в студии рекламы и дизайна Вадима Гончарова, 2013 г.<img src="/images/vadim.png" alt="vadim-design"></a>',
    'num_in_page' => array(
        0 => 10,
        1 => 20,
        2 => 35,
        3 => 50,
        4 => 100,
    )
);