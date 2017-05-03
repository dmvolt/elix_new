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