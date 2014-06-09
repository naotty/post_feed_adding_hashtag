<?php
/**
 * Created by PhpStorm.
 * User: teruyanaoto
 * Date: 14/06/09
 * Time: 9:18
 */

class clsCommon {

	public function upload( $files = null ){

		if ( !isset($files['error']) || !is_int($files['error']) ){
			return null;
		}

		if ( $files['error'] != UPLOAD_ERR_OK ){
			return null;
		}

		if ( $files['size'] > 1024000 ){
			return null;
		}

		$fileInfo = new finfo(FILEINFO_MIME_TYPE);
		if ( !$ext = array_search(
			$fileInfo->file($files['tmp_name']),
			array(
				'gif' => 'image/gif',
				'jpg' => 'image/jpeg',
				'png' => 'image/png',
			),
			true
		) ){
			return null;
		}

		$fileName = sha1_file($files['tmp_name']);
		if (!move_uploaded_file(
			$files['tmp_name'],
			$path = sprintf('./tmp/%s.%s',
				$fileName,
				$ext
			)
		)) {
			return null;
		}

		chmod($path, 0644);

		return $path;

	}
} 