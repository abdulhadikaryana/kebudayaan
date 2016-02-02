<?php 

use Laravel\Database\Eloquent\Model;

class FigureDesc extends Model
{
	public static $table = 'figure_description';

	public function Figure()
	{
		return $this->belongs_to('FigureDesc','figure_id');
	}

}

?>