<?php

$file = EXT_BASE.'/vendor/paris/paris.php';

if ( !is_file( $file ) ){
	throw new exception('Paris must be installed');
}else{
	require $file;
}


?>