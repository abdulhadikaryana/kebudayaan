<?php 
class Admin_Form_AccountForm extends Zend_Form
{
    public $adminUser;
    public $adminPassword;
    public $adminPasswordConfirm;
    public $adminEmail;
    public $adminRole;
    
    public function init()
    {
        $this->adminUser = $this->createElement('text','adminUser');
        $this->adminUser->removeDecorator('HtmlTag');
        $this->adminUser->removeDecorator('DtDdWrapper');
        $this->adminUser->removeDecorator('Label');
        $this->adminUser->setAttrib('class','mediumele');

        $this->adminPassword = $this->createElement('password','adminPassword');
        $this->adminPassword->removeDecorator('HtmlTag');
        $this->adminPassword->removeDecorator('DtDdWrapper');
        $this->adminPassword->removeDecorator('Label');
        $this->adminPassword->setAttrib('class','mediumele');

        $this->adminPasswordConfirm = $this->createElement('password','adminPasswordConfirm');
        $this->adminPasswordConfirm->removeDecorator('HtmlTag');
        $this->adminPasswordConfirm->removeDecorator('DtDdWrapper');
        $this->adminPasswordConfirm->removeDecorator('Label');
        $this->adminPasswordConfirm->setAttrib('class','mediumele');
    
        $this->adminEmail = $this->createElement('text','adminEmail');
        $this->adminEmail->removeDecorator('HtmlTag');
        $this->adminEmail->removeDecorator('DtDdWrapper');
        $this->adminEmail->removeDecorator('Label');
        $this->adminEmail->setAttrib('class','mediumele');
    }
    
    public function setRoleOption()
    {
        $table_role = new Model_DbTable_AdminRole;
        $role_list = $table_role->getAllRole();
        foreach($role_list as $value)
        {
            $role_select[$value['role_id']] = $value['role_name'];    
        }
        $data = array("multiOptions" => $role_select);
        $this->adminRole = $this->createElement('select','adminRole',$data);
        $this->adminRole->removeDecorator('HtmlTag');
        $this->adminRole->removeDecorator('DtDdWrapper');
        $this->adminRole->removeDecorator('Label');
    }
    
}