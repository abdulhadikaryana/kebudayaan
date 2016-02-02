<?php

use Laravel\Database\Eloquent\Model;

class Events extends Model
{
    public static $table = 'event';

    public function EventDesc()
    {    
    	return $this->has_one('EventDesc');	
    }
}

?>
