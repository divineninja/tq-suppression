<?php
class index_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_asset()
    {
        return $this->select('SELECT * 
			FROM asset AS ass
			LEFT JOIN vendors ON ass.vendor = vendors.id
			LEFT JOIN makers ON ass.maker = makers.id
			LEFT JOIN types ON ass.type = types.id
			LEFT JOIN models ON ass.model = models.id
			LEFT JOIN locations ON ass.location = locations.id
			LEFT JOIN groups ON ass.group = groups.id');
    }
    
    public function get_calibration()
    {
        return $this->select('SELECT * 
			FROM asset AS ass
			LEFT JOIN vendors ON ass.vendor = vendors.id
			LEFT JOIN makers ON ass.maker = makers.id
			LEFT JOIN types ON ass.type = types.id
			LEFT JOIN models ON ass.model = models.id
			LEFT JOIN locations ON ass.location = locations.id
			LEFT JOIN groups ON ass.group = groups.id
			WHERE ass.need_calibration=1');
    }
}
