<?php defined('SYSPATH') or die('No direct script access.');

class Im {
	
	public static function imagepath($folder = '', $filename = '', $basepath = '/files') {
	
		$image_versions = Kohana::$config->load('admin/image.image_versions');

		clearstatcache();
		
		if($filename AND !empty($filename) AND file_exists(ALL_DOCROOT . 'files/'.$filename)){
			if($folder != ''){
				if($folder == 'thumbnails'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/thumbnails/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						$im->resize($image_versions['thumbnail']['max_width'], $image_versions['thumbnail']['max_height'], Image::HEIGHT);
						if(!file_exists($image_versions['thumbnail']['upload_dir'])){
							mkdir($image_versions['thumbnail']['upload_dir'], 0755);
						}
						$im->save($image_versions['thumbnail']['upload_dir'] . $filename, $image_versions['thumbnail']['jpeg_quality']);
					}
				} elseif($folder == 'preview'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/preview/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						
						/* $bg = clone $im;
						$bg->crop(1, 1, 0, 0);
						$bg->resize($image_versions['preview']['max_width'], $image_versions['preview']['max_height'], Image::NONE);
						$im->resize($image_versions['preview']['max_width'], $image_versions['preview']['max_height']);
						$bg->watermark($im); */
						
						if ($im->width >= $im->height) {
							$im->resize($image_versions['preview']['max_width']+20, $image_versions['preview']['max_height']+20, Image::HEIGHT);
							$im->crop($image_versions['preview']['max_width'], $image_versions['preview']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['preview']['max_width']+20, $image_versions['preview']['max_height']+20, Image::WIDTH);
							$im->crop($image_versions['preview']['max_width'], $image_versions['preview']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						
						if(!file_exists($image_versions['preview']['upload_dir'])){
							mkdir($image_versions['preview']['upload_dir'], 0755);
						}
						$im->save($image_versions['preview']['upload_dir'] . $filename, $image_versions['preview']['jpeg_quality']);
					}
				} elseif($folder == 'preview2'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/preview2/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['preview2']['max_width']+0, $image_versions['preview2']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['preview2']['max_width'], $image_versions['preview2']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['preview2']['max_width']+0, $image_versions['preview2']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['preview2']['max_width'], $image_versions['preview2']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['preview2']['upload_dir'])){
							mkdir($image_versions['preview2']['upload_dir'], 0755);
						}
						$im->save($image_versions['preview2']['upload_dir'] . $filename, $image_versions['preview2']['jpeg_quality']);
					}
				} elseif($folder == '3000x400'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/3000x400/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						$im->resize($image_versions['3000x400']['max_width'], $image_versions['3000x400']['max_height'], Image::WIDTH);
						$im->crop($image_versions['3000x400']['max_width'], $image_versions['3000x400']['max_height'], NULL, 0); /* Обрезать изображение до центр Х центр: */	
						if(!file_exists($image_versions['3000x400']['upload_dir'])){
							mkdir($image_versions['3000x400']['upload_dir'], 0755);
						}
						$im->save($image_versions['3000x400']['upload_dir'] . $filename, $image_versions['3000x400']['jpeg_quality']);
					}
				} elseif($folder == '600x150'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/600x150/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['600x150']['max_width']+0, $image_versions['600x150']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['600x150']['max_width'], $image_versions['600x150']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['600x150']['max_width']+0, $image_versions['600x150']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['600x150']['max_width'], $image_versions['600x150']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['600x150']['upload_dir'])){
							mkdir($image_versions['600x150']['upload_dir'], 0755);
						}
						$im->save($image_versions['600x150']['upload_dir'] . $filename, $image_versions['600x150']['jpeg_quality']);
					}
				} elseif($folder == '400x250'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/400x250/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['400x250']['max_width']+0, $image_versions['400x250']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['400x250']['max_width'], $image_versions['400x250']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['400x250']['max_width']+0, $image_versions['400x250']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['400x250']['max_width'], $image_versions['400x250']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['400x250']['upload_dir'])){
							mkdir($image_versions['400x250']['upload_dir'], 0755);
						}
						$im->save($image_versions['400x250']['upload_dir'] . $filename, $image_versions['400x250']['jpeg_quality']);
					}
				} elseif($folder == '200x250'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/200x250/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['200x250']['max_width']+0, $image_versions['200x250']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['200x250']['max_width'], $image_versions['200x250']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['200x250']['max_width']+0, $image_versions['200x250']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['200x250']['max_width'], $image_versions['200x250']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['200x250']['upload_dir'])){
							mkdir($image_versions['200x250']['upload_dir'], 0755);
						}
						$im->save($image_versions['200x250']['upload_dir'] . $filename, $image_versions['200x250']['jpeg_quality']);
					}
				} elseif($folder == '250x200'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/250x200/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['250x200']['max_width']+0, $image_versions['250x200']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['250x200']['max_width'], $image_versions['250x200']['max_height'], NULL, 0); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['250x200']['max_width']+0, $image_versions['250x200']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['250x200']['max_width'], $image_versions['250x200']['max_height'], NULL, 0); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['250x200']['upload_dir'])){
							mkdir($image_versions['250x200']['upload_dir'], 0755);
						}
						$im->save($image_versions['250x200']['upload_dir'] . $filename, $image_versions['250x200']['jpeg_quality']);
					}
				} elseif($folder == '250x300'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/250x300/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['250x300']['max_width']+0, $image_versions['250x300']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['250x300']['max_width'], $image_versions['250x300']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['250x300']['max_width']+0, $image_versions['250x300']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['250x300']['max_width'], $image_versions['250x300']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['250x300']['upload_dir'])){
							mkdir($image_versions['250x300']['upload_dir'], 0755);
						}
						$im->save($image_versions['250x300']['upload_dir'] . $filename, $image_versions['250x300']['jpeg_quality']);
					}
				} elseif($folder == '200x150'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/200x150/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['200x150']['max_width']+0, $image_versions['200x150']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['200x150']['max_width'], $image_versions['200x150']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['200x150']['max_width']+0, $image_versions['200x150']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['200x150']['max_width'], $image_versions['200x150']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['200x150']['upload_dir'])){
							mkdir($image_versions['200x150']['upload_dir'], 0755);
						}
						$im->save($image_versions['200x150']['upload_dir'] . $filename, $image_versions['200x150']['jpeg_quality']);
					}
				} elseif($folder == 'preview4'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/preview4/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['preview4']['max_width']+0, $image_versions['preview4']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['preview4']['max_width'], $image_versions['preview4']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['preview4']['max_width']+0, $image_versions['preview4']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['preview4']['max_width'], $image_versions['preview4']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['preview4']['upload_dir'])){
							mkdir($image_versions['preview4']['upload_dir'], 0755);
						}
						$im->save($image_versions['preview4']['upload_dir'] . $filename, $image_versions['preview4']['jpeg_quality']);
					}
				} elseif($folder == 'preview3'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/preview3/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						/* if ($im->width >= $im->height) {
							$im->resize($image_versions['preview3']['max_width']+0, $image_versions['preview3']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['preview3']['max_width'], $image_versions['preview3']['max_height'], NULL, NULL); 
						} else { */
							$im->resize($image_versions['preview3']['max_width'], $image_versions['preview3']['max_height'], Image::WIDTH);
							//$im->crop($image_versions['preview3']['max_width'], $image_versions['preview3']['max_height'], NULL, NULL); 
						/* } */
						if(!file_exists($image_versions['preview3']['upload_dir'])){
							mkdir($image_versions['preview3']['upload_dir'], 0755);
						}
						$im->save($image_versions['preview3']['upload_dir'] . $filename, $image_versions['preview3']['jpeg_quality']);
					}
				} elseif($folder == 'photos'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/photos/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						if ($im->width >= $im->height) {
							$im->resize($image_versions['photos']['max_width']+0, $image_versions['photos']['max_height']+0, Image::HEIGHT);
							$im->crop($image_versions['photos']['max_width'], $image_versions['photos']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						} else {
							$im->resize($image_versions['photos']['max_width']+0, $image_versions['photos']['max_height']+0, Image::WIDTH);
							$im->crop($image_versions['photos']['max_width'], $image_versions['photos']['max_height'], NULL, NULL); /* Обрезать изображение до центр Х центр: */
						}
						if(!file_exists($image_versions['photos']['upload_dir'])){
							mkdir($image_versions['photos']['upload_dir'], 0755);
						}
						$im->save($image_versions['photos']['upload_dir'] . $filename, $image_versions['photos']['jpeg_quality']);
					}
				} elseif($folder == 'colorbox'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/colorbox/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						$im->resize($image_versions['colorbox']['max_width'], $image_versions['colorbox']['max_height'], Image::HEIGHT);
						if(!file_exists($image_versions['colorbox']['upload_dir'])){
							mkdir($image_versions['colorbox']['upload_dir'], 0755);
						}
						$im->save($image_versions['colorbox']['upload_dir'] . $filename, $image_versions['colorbox']['jpeg_quality']);
					}
				} elseif($folder == 'top'){
					if(file_exists(ALL_DOCROOT . 'files/'.$filename) AND !file_exists(ALL_DOCROOT . 'files/top/'.$filename)){
						$im = Image::factory(ALL_DOCROOT . 'files/'.$filename);
						$im->resize($image_versions['top']['max_width'], $image_versions['top']['max_height'], Image::WIDTH);
						if(!file_exists($image_versions['top']['upload_dir'])){
							mkdir($image_versions['top']['upload_dir'], 0755);
						}
						$im->save($image_versions['top']['upload_dir'] . $filename, $image_versions['top']['jpeg_quality']);
					}
				}
				return PARENT_FULLURL . $basepath.'/'.$folder.'/'.$filename;
			} else {
				return PARENT_FULLURL . $basepath.'/'.$filename;
			}
		} else {
			return PARENT_FULLURL . $basepath.'/no_photo.png';
		}
	}
}