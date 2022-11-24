<?php
$path_session_dir = $_SERVER['DOCUMENT_ROOT'] . '/session/';
$path_session_port_dir = $path_session_dir . $_SERVER['SERVER_PORT'];
ini_set('session.save_path', $path_session_port_dir);
ini_set('session.session.gc_divisor', 4);
ini_set('session.gc_probability', 1);
session_start(); 
phpinfo();