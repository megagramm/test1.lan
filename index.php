<?php

/**
 * Проверяет существование php-сессии и создает структуру файлов
 * в папке проекта для сессий.
 *
 * @return void
 */
function session_check()
{
	$path_session_dir = $_SERVER['DOCUMENT_ROOT'] . '/session/';
	$path_session_port_dir = $path_session_dir . $_SERVER['SERVER_PORT'];

	if (!file_exists($path_session_dir)) {
		umask(0);
		mkdir($path_session_dir, 0777);
	}
	if (!file_exists($path_session_dir . '.htaccess')) {
		umask(0002);
		$f = fopen($path_session_dir . '.htaccess', 'w');
		fwrite($f, 'Deny from all');
		fclose($f);
	}
	if (!file_exists($path_session_port_dir)) {
		umask(0);
		mkdir($path_session_port_dir, 0777);
		umask(0002);
		copy($path_session_dir . '/.htaccess', $path_session_port_dir . '/.htaccess');
	}
	ini_set('session.save_path', $path_session_port_dir);
	ini_set('session.session.gc_divisor', 5);
	ini_set('session.gc_probability', 1);
	session_start();
}

session_check();


echo '<br>';
echo 'old A ' . $_SESSION['A'];
echo '<br>';
$_SESSION['A'] = rand(0, 99);
echo 'new A ' . $_SESSION['A'];
echo '<br>';
echo '<br>';

echo '<br>';
// session_unset();
// session_destroy();

// session_regenerate_id();

// $login = "admin";
$password = '';

function logout()
{
	// unset($_SESSION['auth']);
	// unset($_SESSION['login']);
	// unset($_SESSION['session_id']);
	// unset($_SESSION['session_name']);
	// $_SESSION = array();
	
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
	$_SESSION = array();
	
	header("location: /");
}
function login()
{
	$_SESSION['auth'] = TRUE;
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['session_id'] = session_id();
	$_SESSION['session_name'] = session_name();
	header("location: /");
}
echo '$_POST ';
var_dump($_POST);
echo '<br>';
echo '$_SESSION ';
var_dump($_SESSION);
echo '<br>';

// echo '<br>';
echo session_id();
echo session_name();
// echo '<br>';
if (!isset($_SESSION['auth'])) {
	if (!empty($_POST['submit'])) {
		if (isset($_POST['login']) && isset($_POST['password'])) {
			if (in_array($_POST['login'], array('a', 'b')) and $_POST['password'] == $password) {
				login();
			} else {
				logout();
			}
		}
	} else {
?>
<form method="post">
	login: <input type="text" name="login"><br />
	password: <input type="text" name="password"><br />
	<input type="submit" name="submit" Value="logIn">
</form>
<?php
	}
} elseif ($_SESSION['auth'] == TRUE) {
	echo "<h2>{$_SESSION['login']}</h2>";
?>
<a href="?logout">Выйти</a>

<?php
	if (isset($_GET['logout'])) {
		logout();
	}
}