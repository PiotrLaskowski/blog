<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Logowanie</title>
<style type="text/css">
	@import url("view/signin.css");
</style>
</head>
<body>
	
	<div id="wrapper">
		<div id="cell">
			<form action="loguj.html" method="post">
			<div class="username_box"><label class="label" for="username">Login:</label><input type="text" id="username" name="form[login]" /></div>
			<div class="password_box"><label class="label" for="password">Hasło:</label><input type="password" id="password" name="form[password]" /></div>
			<div class="signin_box"><input type="submit" value="Sign in" /></div>
			</form>
				<div class="error">{error}</div>
	</div></div>
	
</body>
</html>