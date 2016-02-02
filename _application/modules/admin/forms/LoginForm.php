<?php 
class Admin_Form_LoginForm extends Zend_Form
{

	public function init()
	{
		
		$LoginDecorator = array(
	    	'ViewHelper',
	    	'Description',
	    	'Errors',
	    	array(array('elementDiv' => 'HtmlTag'), array('tag' => 'div','class' => 'login-input')),
            array(array('br' => 'HtmlTag'),array('tag' => 'br','placement' => 'append')),
	    	array('Label',array('tag' => 'div','class' => 'login-label'))
	    );
	    
		$username = $this->createElement('text','username');
		$username->setDecorators($LoginDecorator);
		$username->addValidator(new Zend_Validate_StringLength(6,25));
		$username->addFilter(new Zend_Filter_StringToLower());
		$username->addFilter(new Zend_Filter_StripTags());
		$username->setRequired(TRUE);
		$username->setAttrib('size',15);
        $username->clearDecorators();
        $username->addDecorator('ViewHelper');
        $username->setAttrib('placeholder' , 'Username');
		$this->addElement($username);
		
		$password = $this->createElement('password','password');
		$password->addValidator(new Zend_Validate_StringLength(6,25));
		$password->addValidator('IdenticalField', false, array('confirm_password', 'Retype Password :'));
		$password->setDecorators($LoginDecorator);
		$password->addFilter(new Zend_Filter_StripTags());
		$password->setRequired(TRUE);
		$password->setAttrib('size',15);
        $password->clearDecorators();
        $password->addDecorator('ViewHelper');
        $password->setAttrib('placeholder' , 'Password');
		$this->addElement($password);

		$submit_button = $this->createElement('submit','login');
        $submit_button->setAttrib('class', 'btn btn-inverse pull-right');
        
		$this->addElement($submit_button);
	}
	
}

?>