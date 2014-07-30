<?php



class ManagerUsers extends ModelFasade { 
	public static $model = 'ModxManagerUsers';
}


class ModxManagerUsers extends Model{ 
    public static $_table = 'manager_users';
    public static $_id_column = 'id';
}
