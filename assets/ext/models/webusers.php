<?php

class WebUsers extends ModelFasade { 
	public static $model = 'ModxWebUsers';
}


class ModxWebUsers extends Model{ 
    public static $_table = 'web_users';
    public static $_id_column = 'id';
}