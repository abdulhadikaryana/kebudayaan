<?php

class Budpar_View_Helper_PollingWidget
        extends Zend_Controller_Action_Helper_Abstract
{
  public $view;

  public function setView(Zend_View_Interface $view)
  {
    $this->view = $view;
  }

  public function pollingWidget()
  {
    $title        = $this->view->translate('polling');
    $language_id  = Zend_Registry::get('languageId');
    $url          = $this->view->baseUrl() . '/ajax/polling';
    $ajax_img_src = $this->view->imageUrl('ajax_loader.gif');


    $widget = <<<HTML
      <div class="widget-half-list" style="padding-bottom: 0">
       <h2 style="margin-bottom: 0">Polling Widget</h2>
       <div id="polling-container"
            style="min-height:25px;background: url('$ajax_img_src')
                    center center no-repeat">
         
       </div>
      </div>
      <script type="text/javascript">
        window.onload = function(){
          $("#polling-container").load('{$url}');
        };
      </script>
HTML;

    return $widget;
  }

}
// <h2>{$title}</h2>
//        <div id="polling-container" style="padding: 5px;">
//          <form action="" id="polling-form">
//            <p>{$polling['question']}</p>
//            {$list}
//            <input type="submit" value="Vote" class="button small blue nice radius" />
//          </form>
//        </div>
//
//   $("#polling-form").submit(function(){
//            $.ajax({
//              type: "POST",
//              url: '{$url}',
//              data: $(this).serialize(),
//              success: function(data) {
//                $("#polling-container").html(data);
//              }
//            });
//            return false;
//          })