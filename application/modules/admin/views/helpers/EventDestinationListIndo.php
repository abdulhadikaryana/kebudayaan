<?php
/**
 * Zend_View_Helper_EventDestinationList
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_EventDestinationListIndo extends Zend_View_Helper_Abstract
{

    protected $table_poitoevent;

    public function __construct()
    {
        $this->table_poitoevent = new Model_DbTable_PoiToEvent;
    }

    public function EventDestinationListIndo($event_id)
    {
        $destination_list  = $this->table_poitoevent->getAllPoiNameByEventId($event_id,2);
        if(sizeof($destination_list)>0)
        {
            return $destination_list->toArray();
        }else
        {
            return 'no related Destination!';
        }
    }
}