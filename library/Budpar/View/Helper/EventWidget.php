<?php

class Budpar_View_Helper_EventWidget
        extends Zend_Controller_Action_Helper_Abstract
{
  /**
   *
   * @var Zend_View_Abstract 
   */
  public $view;

  public function setView(Zend_View_Interface $view)
  {
    $this->view = $view;
  }

  public function eventWidget($limit, $show_thumbnails = false,
          $side_space = true)
  {
    $languageId = Zend_Registry::get('languageId');


    $cache  = Zend_Registry::get('cache');
    if (($widget = $cache->load('widget_event')) === false) {
      $title     = $this->view->translate('recent_events');
      $tbl_event = new Model_DbTable_Event();
      $events    = $tbl_event->getEventLatestByIdLang($languageId,
              null, $limit);

      $list       = "<ul>";
      $thumbnails = '';
      foreach ($events as $event) {
        $urlFormat = $this->view->makeUrlFormat($event['name']);
        $link      = $this->view->baseUrl("event/detail/{$event['event_id']}/{$urlFormat}");
        if ($show_thumbnails) {
          $source     = 'default.jpg';
          $image_dir  = UPLOAD_FOLDER . 'event/';
          $width      = 50;
          $height     = 50;
          $quality    = 100;
          if (file_exists($image_dir . $event['main_pics']) && !empty($event['main_pics']))
                $source     = "upload/event/{$event['main_pics']}";          
            
          $thumb      = $this->view->imageUrl("timthumb.php?src={$source}&w={$width}&h={$height}&q={$quality}");
          $thumbnails = "<img class='thumbnail' src='{$thumb}' alt='{$event['name']}' />";    
        }
        $list .= "<li>{$thumbnails}<a href='{$link}'><span class='desc'>{$event['name']}</span></a></li>";
      }
      $list .= "</ul>";
      $list .= "<div class='clear'></div>";

      if ($side_space)
        $side_space_class = 'side-space';
      $widget           = <<<HTML
        <div class="widget-half-list {$side_space_class}">         
          <h2>{$title}</h2>            
          {$list}      
        </div>
HTML;
      $cache->save($widget);
    }

    return $widget;
  }

}