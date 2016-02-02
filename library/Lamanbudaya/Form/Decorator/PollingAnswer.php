<?php

class Lamanbudaya_Form_Decorator_PollingAnswer
        extends Zend_Form_Decorator_Abstract
{
  public function render($content)
  {
    $markup = <<<HTML
      <li>
        {$content}
        <a href="javascript:void(0)"
           onclick="$(this).parents('li').remove()">Remove</a>
      </li>
HTML;
    return $markup;
  }

}