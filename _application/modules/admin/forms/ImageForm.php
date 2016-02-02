<?php 
class Admin_Form_ImageForm extends Zend_Form
{
    public $image_upload;
    public $image_submit;
    public $image_name;
    public $image_poi;
    public $image_description;
    public $image_type;
    
    public function init()
    {
        $this->image_description = $this->createElement('textarea','ImageDescription');
        $this->image_description->removeDecorator('HtmlTag');
        $this->image_description->removeDecorator('DtDdWrapper');
        $this->image_description->removeDecorator('Label');
        $this->image_description->setAttrib('cols','50');
        $this->image_description->setAttrib('rows','5');
        
        $type = array("multiOptions" => array(
            'culture' => 'Culture',
            'news' => 'News',
        ));        
        
        $this->image_type = $this->createElement('select','ImageSelect',$type);
        $this->image_type->removeDecorator('HtmlTag');
        $this->image_type->removeDecorator('DtDdWrapper');
        $this->image_type->removeDecorator('Label');
        $this->image_type->setAttrib('onchange','changeDir();');
        
        $this->image_name = $this->createElement('text','ImageName');
        $this->image_name->removeDecorator('HtmlTag');
        $this->image_name->removeDecorator('DtDdWrapper');
        $this->image_name->removeDecorator('Label');
        $this->image_name->setAttrib('class','smallele');

        $this->image_poi = $this->createElement('text','ImagePoi');
        $this->image_poi->removeDecorator('HtmlTag');
        $this->image_poi->removeDecorator('DtDdWrapper');
        $this->image_poi->removeDecorator('Label');
        
        $this->image_upload = $this->createElement('file','ImageUpload');
        $this->image_upload->removeDecorator('HtmlTag');
        $this->image_upload->removeDecorator('DtDdWrapper');
        $this->image_upload->removeDecorator('Label');
        
        $this->image_submit = $this->createElement('submit','submit');
        $this->image_submit->setAttrib('value','upload');
        $this->image_submit->setAttrib('style','width: 100px; margin-left: 100px;');
        $this->image_submit->removeDecorator('HtmlTag');
        $this->image_submit->removeDecorator('DtDdWrapper');
        $this->image_submit->removeDecorator('Label');
    }
}