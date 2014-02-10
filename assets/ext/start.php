<?php

define('EXT_BASE', dirname(__FILE__));
require EXT_BASE.'/lib/autoload.php';

Config::load('path', EXT_BASE.'/config/path.php' );
Config::load('app', EXT_BASE.'/config/app.php' );

global $database_server,$database_user,$database_password,$dbase,$modx;
Config::set('dbserver',$database_server);
Config::set('dbuser',$database_user);
Config::set('dbpassword',$database_password);
Config::set('dbbase', str_replace('`','',$dbase));

Config::set('prefix', $modx->db->config['table_prefix']);


