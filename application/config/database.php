<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
//	'hostname' => 'localhost',
//	'username' => 'layanan_user',
//	'password' => '7@-+f?k=z-JI',
//	'database' => 'layanan_db',
	'hostname' => '34.101.184.111',
 	'username' => 'root',
 	'password' => 'adminganteng',
 	'database' => 'layanan_database',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
);

$db['otherdb'] = array(
	'hostname' => 'localhost',
	'username' => 'simpeg_userdb',
	'password' => 'pegawaidisiplin123',
	'database' => 'simpeg_sistem',
	'dbdriver' => "mysqli",
	'dbprefix' => "",
	'pconnect' => TRUE,
	'db_debug' => FALSE,
	'cache_on' => FALSE,
	'cachedir' => "",
	'char_set' => "utf8",
	'dbcollat' => "utf8_general_ci",
	'swap_pre' => "",
	'autoinit' => TRUE,
	'stricton' => FALSE,
);
