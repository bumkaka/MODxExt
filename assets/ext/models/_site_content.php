<?php



class _site_content extends ModelFasade
{
    public static $model = 'MODEL_site_content';
}


class MODEL_site_content extends Model
{
    public static $_table = 'site_content';
    public static $_id_column = 'id';


    public function tv()
    {
        return $this->has_many('TV');
    }
}