<?php

class Budpar_View_Helper_CategoryWidget
        extends Zend_Controller_Action_Helper_Abstract
{
  public $view;

  public function setView(Zend_View_Interface $view)
  {
    $this->view = $view;
  }

  public function categoryWidget($side_space = true)
  {

    $language_id = Zend_Registry::get('languageId');
    $cache  = Zend_Registry::get('cache');
    if (($widget = $cache->load('widget_category')) === FALSE) {
      $title        = $this->view->translate('culture_category');
      $tbl_category = new Model_DbTable_Category();
      $categories   = $tbl_category->getAllParentCategoryIdNameByLangId($language_id)->toArray();

      $list = "<ul>";
      foreach ($categories as $category) {
        $link = $this->view->baseUrl("category/see-category/{$category['category_id']}");
        $list.= "<a href='{$link}'><li>{$category['name']}</li></a>";
      }
      $list .= "<div class='clear'></div>";
      $list .= "</ul>";

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