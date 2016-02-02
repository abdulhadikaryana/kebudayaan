<?php 

use Laravel\Database\Eloquent\Model;

class EventDesc extends Model
{
	public static $table = 'eventdesc';

	public function Events()
	{
		return $this->belongs_to('EventDesc','event_id');
	}
}

?>