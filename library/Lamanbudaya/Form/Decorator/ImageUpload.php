<?php

class Lamanbudaya_Form_Decorator_ImageUpload
        extends Zend_Form_Decorator_Abstract
{
  public function render($content)
  {

    $element = $this->getElement();
    $error   = $element->getErrors();
    
    $img = $this->getOption('src');
    $src = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";
    if(isset($img)) {
      $src = $img;
    }

    $markup = <<<HTML
   <div class="fileupload fileupload-new" data-provides="fileupload">
     <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
      <img style="width: 200px; height: 150px;" src="{$src}" alt="">
     </div>
     <div>
       <span class="btn btn-file">
        <span class="fileupload-new">Select Image</span>
        <span class="fileupload-exists">Change</span>
        {$content}
       </span>
       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">
        Remove
       </a>
     </div>
   </div>
HTML;

    return $markup;
  }

}