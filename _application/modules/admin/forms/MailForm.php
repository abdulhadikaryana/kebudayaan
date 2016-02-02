<?php 
class Admin_Form_MailForm extends Zend_Form
{
    public $mailRecipient;
    public $mailSubject;
    public $mailContent;
    
    /**
     * IS: 
     * FS: 
     * Desc: Mengatur tampilan form di halaman mail (My Inbox)
     */
    public function init()
    {
        $this->mailRecipient = $this->createElement('text','mailRecipient');
        $this->mailRecipient->removeDecorator('HtmlTag');
        $this->mailRecipient->removeDecorator('DtDdWrapper');
        $this->mailRecipient->removeDecorator('Label');
        $this->mailRecipient->setAttrib('style','width: 350px;');
        
        $this->mailSubject = $this->createElement('text','mailSubject');
        $this->mailSubject->removeDecorator('HtmlTag');
        $this->mailSubject->removeDecorator('DtDdWrapper');
        $this->mailSubject->removeDecorator('Label');
        $this->mailSubject->setAttrib('style','width: 350px;');
        
        $this->mailContent = $this->createElement('textarea','mailContent');
        $this->mailContent->removeDecorator('HtmlTag');
        $this->mailContent->removeDecorator('DtDdWrapper');
        $this->mailContent->removeDecorator('Label');
        $this->mailContent->setAttribs(array('cols' => 5, 'rows' => 5));
    }
}
