<?php

class News_Controller extends Base_Controller
{
//    public $restful = true;
   
    public function get_index()
    {
       // $news = News::where('status','=',0)->get();
        $news = News::get();
        
        if(is_null($news))
        {
            return json_encode('News not found',404);
        }
        else
        {
            return json_encode($news);
        }
        
    }

    public function get_detail($id)
    {
        $news = News::find($id);
        if(is_null($news))
        {
            return json_encode('News not found',404);
        }
        else
        {
            return json_encode($news);
        }
    }
}

