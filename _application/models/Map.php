<?php
/**
 * Model_Map
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * map/peta
 *
 * @package Model
 * @copyright Copyright (c) 2010 Sangkuriang Solution
 * @author Sangkuriang Solution <www.sangkuriangstudio.com>
 *
 */
class Model_Map extends Budpar_Model_Common
{
    private $_poiInfo;
    private $_poiCategories;

    public function __construct()
    {
        parent::__construct();
        $this->getAllForMap();
    }

    public function getAllForMap()
    {
        $destDescDb = new Model_DbTable_DestinationDescription;
        $destination = $destDescDb->getAllForMap($this->_languageId);

        $poiInfo = array();
        $poiCategories = array();
        foreach($destination as $row){
            $poiInfo[$row['poi_id']] = array();
            $poiInfo[$row['poi_id']]['descname'] = $row['descname'];
            $poiInfo[$row['poi_id']]['x'] = $row['pointX'];
            $poiInfo[$row['poi_id']]['y'] = $row['pointY'];
            $poiInfo[$row['poi_id']]['des'] = $this->_getContentBox($row);

            if($row['category_id'])
                $poiCategories[$row['poi_id']] = $row['category_id'];
        }

        $this->_poiInfo = $poiInfo;
        $this->_poiCategories = $poiCategories;
    }

    public function getPoiInfo()
    {
        return json_encode($this->_poiInfo);
    }

    public function getPoiCategories()
    {
        return json_encode($this->_poiCategories);
    }

    private function _getContentBox($row)
    {
        $mainImage = $this->_getMainImage($row);
        $description = $this->_getDescription($row);

        $content .= "<p class='mapDescBox'>";
        $content .= $mainImage . $description;
        $content .= "</p>";
        $content .= "<div class='clear'></div>";

        return $content;
    }

    private function _getMainImage($row)
    {
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();

        $imageDb = new Model_DbTable_Image;
        $result = $imageDb->getImageById($row['poi_id']);

        $mainImage = "";
        if (count($result) > 0) {
            $linkImage = $baseUrl . '/media/images/upload/poi/' . $result[0]['source'];
            $mainImage = "<img class='mapImageBox' src='" .
                $linkImage . "' alt='" . $row['descname'] . "' title='" .
                $row['descname'] . "'  />";
        }

        return $mainImage;
    }

    private function _getDescription($row)
    {
        // Variable
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();

        // Kelas
        $custom = new Budpar_Custom_Common;

        // Data deskripsi destinasi
        $description = $custom->truncate($row['description'], 200);
        $description = strip_tags($description);

        // Format url dari nama destinasi
        $formatUrlName = $custom->makeUrlFormat($row['descname']);

        // Tambahin read more
        $description .= "<span class='read-more'><a onclick=window.open('" .
            $baseUrl . "/destination/" . $row['poi_id'] ."/". $formatUrlName .
            "')>Read More &raquo;</a></span>";

        return $description;
    }
    
}
?>
