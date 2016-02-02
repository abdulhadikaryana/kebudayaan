<?php 

use Laravel\Database\Eloquent\Model;

class Figure extends Model
{
	public static $table = 'figure';

	public function FigureDesc()
	{
		return $this->has_one('FigureDesc');
	}		
}

?>