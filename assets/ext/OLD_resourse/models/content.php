<?php
namespace \Resourse\Models{



class Content extend \Resourse\Table{

use \Resourse\Table as Table; 

protected $table = '';

//@TODO:  Content::pagetitle(24)
/*
*
* Content::get(4);
* $Result = Content::get(4);
* echo $result['pagetitle']
* $Result['price'] = 3400;
* $Result->set( array('price'=>3400) )->save()
*
* Content::->get( array('id != 5') )->where('id=14 AND titl = "qwqw");
* 
* 
*/
function __call( $method, $args){


}




}


}

?>