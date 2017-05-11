<?php

defined('SYSPATH') or die('No direct script access');

return array(
    'image_versions' => array(
		'top' => array(
            'upload_dir' => ALL_DOCROOT . 'files/top/',
            'upload_url' => PARENT_FULLURL . '/files/top/',
            'max_width' => 464,
            'max_height' => 202,
            'jpeg_quality' => 100
        ),
        'colorbox' => array(
            'upload_dir' => ALL_DOCROOT . 'files/colorbox/',
            'upload_url' => PARENT_FULLURL . '/files/colorbox/',
            'max_width' => 900,
            'max_height' => 700,
            'jpeg_quality' => 100
        ),
		'photos' => array(
            'upload_dir' => ALL_DOCROOT . 'files/photos/',
            'upload_url' => PARENT_FULLURL . '/files/photos/',
            'max_width' => 200,
            'max_height' => 200,
            'jpeg_quality' => 100
        ),
		'preview' => array(
            'upload_dir' => ALL_DOCROOT . 'files/preview/',
            'upload_url' => PARENT_FULLURL . '/files/preview/',
            'max_width' => 230,
            'max_height' => 230,
            'jpeg_quality' => 100
        ),
        'preview2' => array(
            'upload_dir' => ALL_DOCROOT . 'files/preview2/',
            'upload_url' => PARENT_FULLURL . '/files/preview2/',
            'max_width' => 350,
            'max_height' => 400,
            'jpeg_quality' => 100
        ),
		'preview3' => array(
            'upload_dir' => ALL_DOCROOT . 'files/preview3/',
            'upload_url' => PARENT_FULLURL . '/files/preview3/',
            'max_width' => 400,
            'max_height' => 300,
            'jpeg_quality' => 100
        ),
		'preview4' => array(
            'upload_dir' => ALL_DOCROOT . 'files/preview4/',
            'upload_url' => PARENT_FULLURL . '/files/preview4/',
            'max_width' => 180,
            'max_height' => 250,
            'jpeg_quality' => 100
        ),
		'3000x400' => array(
            'upload_dir' => ALL_DOCROOT . 'files/3000x400/',
            'upload_url' => PARENT_FULLURL . '/files/3000x400/',
            'max_width' => 3000,
            'max_height' => 400,
            'jpeg_quality' => 100
        ),
		'600x150' => array(
            'upload_dir' => ALL_DOCROOT . 'files/600x150/',
            'upload_url' => PARENT_FULLURL . '/files/600x150/',
            'max_width' => 600,
            'max_height' => 150,
            'jpeg_quality' => 100
        ),
		'400x250' => array(
            'upload_dir' => ALL_DOCROOT . 'files/400x250/',
            'upload_url' => PARENT_FULLURL . '/files/400x250/',
            'max_width' => 400,
            'max_height' => 250,
            'jpeg_quality' => 100
        ),
		'200x250' => array(
            'upload_dir' => ALL_DOCROOT . 'files/200x250/',
            'upload_url' => PARENT_FULLURL . '/files/200x250/',
            'max_width' => 200,
            'max_height' => 250,
            'jpeg_quality' => 100
        ),
		'250x200' => array(
            'upload_dir' => ALL_DOCROOT . 'files/250x200/',
            'upload_url' => PARENT_FULLURL . '/files/250x200/',
            'max_width' => 250,
            'max_height' => 200,
            'jpeg_quality' => 100
        ),
		'250x300' => array(
            'upload_dir' => ALL_DOCROOT . 'files/250x300/',
            'upload_url' => PARENT_FULLURL . '/files/250x300/',
            'max_width' => 250,
            'max_height' => 300,
            'jpeg_quality' => 100
        ),
		'200x150' => array(
            'upload_dir' => ALL_DOCROOT . 'files/200x150/',
            'upload_url' => PARENT_FULLURL . '/files/200x150/',
            'max_width' => 200,
            'max_height' => 150,
            'jpeg_quality' => 100
        ),
        'thumbnail' => array(
            'upload_dir' => ALL_DOCROOT . 'files/thumbnails/',
            'upload_url' => PARENT_FULLURL . '/files/thumbnails/',
            'max_width' => 100,
            'max_height' => 100,
            'jpeg_quality' => 95
        ),
    ),
    'setting' => array(
        'upload_dir' => ALL_DOCROOT . 'files/',
        'upload_url' => PARENT_FULLURL . '/files/',
        'param_name' => 'files',
    ),
);