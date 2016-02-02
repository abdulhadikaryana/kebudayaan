<?php

class Budpar_View_Helper_CultureWidget
        extends Zend_Controller_Action_Helper_Abstract
{
  /**
   * @var Zend_View_Abstract
   */
  public $view;

  public function getView()
  {
    return $this->view;
  }

  public function setView(Zend_View_Interface $view)
  {
    $this->view = $view;
  }

  public function cultureWidget($limit, $show_thumbnails = false,
          $side_space = true)
  {
    $languageId = Zend_Registry::get('languageId');

    $cache  = Zend_Registry::get('cache');
    if (($widget = $cache->load('widget_kebudayaan')) === false) {
      $title = $this->view->translate('popular_culture');

      $tbl_culture = new Model_DbTable_Destination();
      $cultures    = $tbl_culture->getFeaturedCulture($languageId,
              $limit);



      $list       = "<ul>";
      $thumbnails = '';
      foreach ($cultures as $culture) {
        $urlFormat = $this->view->makeUrlFormat($culture['name']);
        $link      = $this->view->baseUrl("culture/{$culture['poi_id']}/{$urlFormat}");
        if ($show_thumbnails) {
          $source        = 'default.jpg';
          $width         = 50;
          $height        = 50;
          $quality       = 100;
          $culture_image = 'upload/culture/' . $culture['image'];
          if (!file_exists(IMAGE_FOLDER . $culture_image) || empty($culture['image']))
            $culture_image = $source;
          
          $timthumb      = $this->view->imageUrl("timthumb.php?src={$culture_image}&w={$width}&h={$height}&q={$quality}");
          $thumbnails    = "<img class='thumbnail' src='{$timthumb}' alt='{$culture['name']}' />";
        }

        $list .= "<li>{$thumbnails}<a href='{$link}'><span class='desc'>{$culture['name']}</span></a></li>";
      }
      $list .= "</ul>";
      $list .= "<div class='clear'></div>";

      if ($side_space)
        $side_space_class = 'side-space';

      $widget = <<<HTML
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