<?php

class Lamanbudaya_Form_Decorator_ControlGroup
        extends Zend_Form_Decorator_Abstract
{
  protected $_format = "<div class='%s'>%s</div>";

  public function render($content)
  {
    $element = $this->getElement();
    $errors  = $element->getErrors();
    $class   = 'control-group';
    if (!empty($errors)) {
      $class = $class . ' error';
    }
    return sprintf($this->_format, $class, $content);
  }

}