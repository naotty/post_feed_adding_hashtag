<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta charset="UTF-8">
	<title>投稿フォーム</title>
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
<h1>投稿フォーム</h1>

<form id="frmMain" action="fb.php" method="post" enctype="multipart/form-data">
	<label for="message">Message:</label><input type="text" name="message">
	<br>
	<label for="message">ファイル(1MBまで):</label><input type="file" id="upfile" name="upfile" size="30" />
	<br />
	<input type="submit" id="btnSubmit" value="送信">
</form>
<p style="color: red;">※あなたのフィードに投稿しますよ？</p>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>

	$(function(){

		$('#upfile').change(function(){

			if (window.File) {

				// 指定されたファイルを取得
				var input = this.files[0];
				if ( input ){
					var size = input.size / 1024;
					if ( size > 1024 ){
						alert('1MB超えてますけど？');
						$(this).val('');
						return false;
					}
				}

			}

			return true;

		});

		$('#btnSubmit').click(function(){
			return confirm('いいですか？');
		});

	});

</script>
</body>
</html>