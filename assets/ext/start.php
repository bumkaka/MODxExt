<?php
global $database_server,$database_user,$database_password,$dbase,$modx;
/*
 * Define block
 */
define('EXT_BASE', dirname(__FILE__));


/*
 * Requires
 */
require EXT_BASE.'/lib/autoload.php';



/*
 * Configs
 */
Config::set('path', require  EXT_BASE.'/config/path.php' );
Config::set('app', require  EXT_BASE.'/config/app.php' );

Config::set(
    array(
        'dbserver'=>$database_server,
        'dbuser'=>$database_user,
        'dbpassword'=>$database_password,
        'dbbase' => str_replace('`','',$dbase),
        'prefix'=> $modx->db->config['table_prefix']
    )
);

/*
 *  Injections )
 */
Inj::modx($modx);


