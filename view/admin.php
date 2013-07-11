<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Panel administracyjny</title>
<style type="text/css">
	@import url("view/admin.css");
</style>
<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<div id="menuUp">
		<ul>
			<li><a href="admin,dodaj.html" {dodaj_active}><span>Dodaj wpis</span></a></li>
			<li><a href="admin,pokaz.html" {pokaz_active}><span>Pokaż wpisy</span></a></li>
		</ul>
		
		<div id="userInfo">
			<p><span>Zalogowany jako</span>: {logged_as} <img src="gfx/login.gif" alt="Logout" /> </p>
		</div>
	</div>
	<div id="mainPlace">
		<div id="mainPanel">
			<div class="header"><span>Profil użytkownika</span></div>
			<div class="content"><p><span class="bold">Imię i nazwisko:</span> {logged_as}</p></div>
			<div class="content"><p><a href="wyloguj.html">Wyloguj</a></p></div>
		</div>
		<div id="mainViewer">
		{content}
		</div>
		<div class="breaker">&nbsp;</div>
	</div>
</body>
</html>