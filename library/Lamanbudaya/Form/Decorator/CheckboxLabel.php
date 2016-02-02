<?php

class Lamanbudaya_Form_Decorator_CheckboxLabel
        extends Zend_Form_Decorator_Abstract
{
  public function render($content)
  {

    $element = $this->getElement();
    $element->setAttrib('class', 'checkbox');
    $label   = $element->getLabel();
    $name    = $element->getName();

    $markup = <<<HTML
        <label class="checkbox" for="{$name}">
            {$content}
            {$label}
        </label>
HTML;

    return $markup;
  }

}