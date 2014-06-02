<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
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

<form action="fb.php" method="post">
	<label for="message">Message:</label><input type="text" name="message">
	<input type="submit" value="送信">
</form>
<p style="color: red;">※あなたのフィードに投稿しますよ？</p>

</body>
</html>