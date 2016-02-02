<?php 

	class Figure_Controller extends Base_Controller
	{
		//public $restful = true;

		public function get_index()
		{
			$figure = Figure::with('FigureDesc')->where('status','=',3)->get();
			if(is_null($figure))
			{
				return json_encode('Figure not found', 404);
			}
			else
			{
				return json_encode($figure);
			}
		}

		public function get_detail($id)
		{
			$figure = Figure::with('FigureDesc')->find($id);
			if(is_null($figure))
			{
				return json_encode('Figure not found', 404);
			}
			else
			{
				return json_encode($figure);
			}
		}
	}

?>