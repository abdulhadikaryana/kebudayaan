<?php 
class Admin_Form_CommentForm extends Zend_Form
{
    public $commentContent;
    
    /**
     * IS: 
     * FS: 
     * Desc: Mengatur tampilan form di halaman comment
     */
    public function init()
    {   
        $this->commentContent = $this->createElement('textarea','commentContent');
        $this->commentContent->removeDecorator('HtmlTag');
        $this->commentContent->removeDecorator('DtDdWrapper');
        $this->commentContent->removeDecorator('Label');
        $this->commentContent->setAttribs(array('cols' => 5, 'rows' => 5));
    }
}
