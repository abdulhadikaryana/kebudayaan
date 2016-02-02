<?php

class Event_Controller extends Base_Controller
{
//    public $restful = true;
   
    public function get_index()
    {
       $event = Events::where('status','=',3)->get();
        if(is_null($event))
        {
            return json_encode('Event not found',404);
        }
        else
        {
            return json_encode($event);
        }        
    }

}

