<?php

class Budpar_View_Helper_relatedWidget extends Zend_Controller_Action_Helper_Abstract{
    
    public $view;
    
    public function setView(Zend_View_Interface $view){
        $this->view = $view;
    }
    
    public function relatedWidget($side_space = true){
        $title = $this->view->translate('related_culture');
//        $id = $this->_request->_getParam('poi_id');
        $languageId = Zend_Registry::get('languageId');
        $poiDb = new Model_DbTable_Destination();
        $relatedPoi = $poiDb->getRelatedCulture($id,$languageId);
        
        $list = "<ul>";
        foreach($relatedPoi as $related){
            $link = $this->view->baseUrl("culture/detail/{$related['name']}");
            $list.= "<a href= '{$link}'><li>{$related['name']}</li></a>";
        }
        $list .= "<div class='clear'></div>";
        $list .= "</ul>";
        
        if($side_space)
            $side_space_class = 'side-space';
        
        $widget = <<<HTML
        <div class="widget-half-list {$side_space_class}">
        <h2>{$title}</h2>    
        {$list}
        </div>
HTML;
        
        return $widget;
    }
    
}