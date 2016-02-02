<?php
class Admin_Form_RelatedForm extends Zend_Form
{
    public $linkType;
    public $linkTitle;
    public $linkDescription;
    public $linkUrl;
    public $linkName;
    
    public function init()
    {
        $this->linkTitle= $this->createElement('text','linkTitle');
        $this->linkTitle->removeDecorator('HtmlTag');
        $this->linkTitle->removeDecorator('DtDdWrapper');
        $this->linkTitle->removeDecorator('Label');
        $this->linkTitle->setAttrib('class','mediumele');
        $this->linkTitle->setRequired(TRUE);

        $this->linkName= $this->createElement('text','linkName');
        $this->linkName->removeDecorator('HtmlTag');
        $this->linkName->removeDecorator('DtDdWrapper');
        $this->linkName->removeDecorator('Label');
        $this->linkName->setAttrib('class','mediumele');
        $this->linkName->setRequired(TRUE);

        $this->linkUrl= $this->createElement('text','linkUrl');
        $this->linkUrl->removeDecorator('HtmlTag');
        $this->linkUrl->removeDecorator('DtDdWrapper');
        $this->linkUrl->removeDecorator('Label');
        $this->linkUrl->setAttrib('class','mediumele');
        $this->linkUrl->setRequired(TRUE);
        
        $this->linkDescription = $this->createElement('textarea','linkDescription');           
        $this->linkDescription->removeDecorator('HtmlTag');
        $this->linkDescription->removeDecorator('DtDdWrapper');
        $this->linkDescription->removeDecorator('Label');
        $this->linkDescription->setAttribs(array('cols' => 5, 'rows' => 5));
        
        $table_related = new Model_DbTable_Related;
        $select_data = $table_related->getAllTypeDesc('Select Type');
        $data = array("multiOptions" => $select_data);

        $this->linkType = $this->createElement('select','linkType',$data);
        $this->linkType->removeDecorator('HtmlTag');
        $this->linkType->removeDecorator('DtDdWrapper');
        $this->linkType->removeDecorator('Label');        
    }  
}