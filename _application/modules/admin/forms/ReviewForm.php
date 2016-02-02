<?php 
class Admin_Form_ReviewForm extends Zend_Form
{
    public $reviewTitle;
    public $reviewContent;
    
    /**
     * IS: 
     * FS: 
     * Desc: Mengatur tampilan form di halaman review
     */
    public function init()
    {
        $this->reviewTitle= $this->createElement('text','reviewTitle');
        $this->reviewTitle->removeDecorator('HtmlTag');
        $this->reviewTitle->removeDecorator('DtDdWrapper');
        $this->reviewTitle->removeDecorator('Label');
        $this->reviewTitle->setAttrib('style','width:50%;');
        
        $this->reviewContent = $this->createElement('textarea','reviewContent');
        $this->reviewContent->removeDecorator('HtmlTag');
        $this->reviewContent->removeDecorator('DtDdWrapper');
        $this->reviewContent->removeDecorator('Label');
        $this->reviewContent->setAttribs(array('cols' => 5, 'rows' => 5));
    }
}
