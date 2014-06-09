<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require './src/facebook.php';
require './clsCommon.php';

session_start();


// TODO: set application id
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '',
  'secret' => '',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');

  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
$serachResult = null;

$params = array(
	'scope'=>'publish_stream'
);

$clsCommon = new clsCommon();

if ($user) {

  $logoutUrl = $facebook->getLogoutUrl();


   try {

	   $path = null;
	   if ( !empty($_SESSION['ri_test_file']) ){
		   $path = $_SESSION['ri_test_file'];
	   } else {
		   if ( !empty($_FILES['upfile']) ){
			   $path = $clsCommon->upload($_FILES['upfile']);
		   }
	   }

	   if(!empty($path)){
		   $source = '@' . realpath($path);
	   }


		if ( !empty($_POST['message']) ){
			$message = htmlentities($_POST['message'],ENT_QUOTES,'UTF-8');
		}

		if ( empty($message) ){
			$message = $_SESSION['ri_test_msg'];
		}

		if ( !empty( $message ) ){


			if ( !empty( $source ) ){

				// アルバムへ投稿
				$facebook->setFileUploadSupport(true);

				$attachment = array(
					'image' => $source,
					'name' => $message . ' #test',
				);
				$result = $facebook->api("/me/photos", 'post', $attachment);

			} else {

				//ウォールへ投稿
				$result = $facebook->api("/me/feed", "post", array(
					"message" => $message . ' #test',
					"caption" => 'リンクのキャプション(見出し)',
					"description" => 'リンクの説明文'
				));

			}


			header("Location: ./result.php" );
			exit();

		}

	} catch (FacebookApiException $e) {
		echo "FacebookApiException : something is wrong, please try again later.<br>";
		echo $e->getMessage();
		exit();

	} catch (Exception $e) {
		echo "Exception : something is wrong, please try again later.<br>";
		echo $e->getMessage();
		exit();

	}


} else {

  $loginUrl = $facebook->getLoginUrl($params);

	$message = htmlentities($_POST['message'],ENT_QUOTES,'UTF-8');
	if ( !empty( $message ) ){
		$_SESSION['ri_test_msg'] = $message;
	}

	$_SESSION['ri_test_file'] = $clsCommon->upload($_FILES['upfile']);

}


?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
	<meta charset="UTF-8">
	<title>Facebook認証</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>Facebook認証</h1>

      <div>
        Facebookへのログイン・アプリ許可が必要です:
        <a href="<?php echo $loginUrl; ?>">ログイン</a>
      </div>

  </body>
</html>
