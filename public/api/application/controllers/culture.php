<?php

/**
 * RESTful Controller for interact on Culture API
 * @author Egi Hasdi <egi.hasdi@sangkuriang.co.id>
 */
class Culture_Controller extends Base_Controller
{
    /**
     * List all cultures or based on category if specified
     */
    public function get_index()
    {
        $cultures = Culture::get();
        return json_encode($cultures);
    }

}