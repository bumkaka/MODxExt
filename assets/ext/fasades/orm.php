<?php

if ( !is_file( EXT_BASE.'/vendor/idiorm/idiorm.php' ) ){
	throw new exception('Idiorm must be installed');
}else{
	require EXT_BASE.'/vendor/idiorm/idiorm.php';
	
}

$setting = array(
    'connection_string' => 'mysql:host='.Config::get('dbserver').';dbname='.Config::get('dbbase'),
    'username' => Config::get('dbuser'),
    'password' => Config::get('dbpassword')
);

ORM::configure($setting);



?>