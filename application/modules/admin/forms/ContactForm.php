<?php
class Admin_Form_ContactForm extends Zend_Form
{
    
    public $replyText;
    
    
    public function init()
    {
        $this->replyText = $this->createElement('textarea','replyText');
        $this->replyText->removeDecorator('HtmlTag');
        $this->replyText->removeDecorator('DtDdWrapper');
        $this->replyText->removeDecorator('Label');
        $this->replyText->setAttribs(array('cols' => 5, 'rows' => 5));

              
    }  
}