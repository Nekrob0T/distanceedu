<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');

	$mode = $_GET['mode'];
	$errors = array();
	$user = $_SESSION['login'];
	$printErr = false;

	include 'config.php';
	include 'libs/db.php';

	$link = array("reg","login","profile","profilesettings","articles","articlescreate","articlesview","articlesmodify","articlesdelete","teacherfind","teacherview","groups","groupscreate","groupsview","messages","messagesview");
	$user = R::findOne('users', 'login = ?', array($user));
	$findLink = false;

	if (isset($_GET['mode'])) {
		for ($i=0; $i < count($link); $i++) {
			if ($link[$i] == $mode && isset($user)) {
				include './html/'.$mode.'.php';
				$findLink = true;
				break;
			} else if ($link[$i] == $mode && !isset($user)) {
				if ($mode == 'reg') {
					include './html/reg.php';
					$findLink = true;
					break;
				} else {
					include './html/login.php';
					$findLink = true;
					break;
				}
			}
			if ($mode == '') {
				include './html/login.php';
				$findLink = true;
				break;
			}
		}
	}else{
		include './html/login.php';
		$findLink = true;
	}

	if (!$findLink) {
		include 'html/404.php';
	}
?>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="<?php echo HOST ?>/css/normalize.css"/>
	<link rel="stylesheet" href="<?php echo HOST ?>/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="<?php echo HOST ?>/css/main.css"/>
	<link rel="stylesheet" href="<?php echo HOST ?>/css/font-awesome.min.css"/>
	<!-- <script src="<?php echo HOST ?>/js/collapse.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>