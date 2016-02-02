<?php

class Budpar_View_Helper_NewsWidget
        extends Zend_Controller_Action_Helper_Abstract
{
  /**
   *
   * @var Zend_View_Helper_Abstract 
   */
  public $view;

  public function setView(Zend_View_Interface $view)
  {
    $this->view = $view;
  }

  public function newsWidget($news_limit, $show_thumbnails = false,
          $side_space = true)
  {

    $language_id = Zend_Registry::get('languageId');

    $cache  = Zend_Registry::get('cache');
    if (($widget = $cache->load('widget_news')) === false) {
      $title    = $this->view->translate('recent_news');
      $tbl_news = new Model_DbTable_News();
      $arr_news = $tbl_news->getLastNews($language_id, $news_limit)->toArray();

      $list       = "<ul>";
      $thumbnails = '';
      foreach ($arr_news as $news) {
        $link = $this->view->baseUrl('news/detail/' .
                $news['id'] . '/' .
                $this->view->makeUrlFormat($news['title']));
        if ($show_thumbnails) {
          $source     = 'default.jpg';
          if (file_exists(UPLOAD_FOLDER . "news/{$news['image']}") && !empty($news['image']))
            $source     = "upload/news/{$news['image']}";
            
          $thumbs     = $this->view->imageUrl("timthumb.php?src={$source}&w=50&h=50&q=100");
          $thumbnails = "<img src='{$thumbs}' class='thumbnail' alt='{$news['title']}' />";
        }
        $list .= "<li>{$thumbnails}<a href='{$link}'><span class='desc'>{$news['title']}</span></a></li>";
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