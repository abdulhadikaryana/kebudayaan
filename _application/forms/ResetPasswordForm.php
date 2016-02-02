<?php
/**
 * Form_ResetPasswordForm
 *
 * Form untuk reset password
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_ResetPasswordForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        
        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'inputForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/registration/reset',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // Element Form
        // -> Hidden email
        $email = $this->createElement('hidden', 'email');
        $email->setLabel('email')
              ->removeDecorator('Label');
        $this->addElement($email);

        // -> Hidden Key
        $key = $this->createElement('hidden', 'key');
        $key->setLabel('key')
            ->removeDecorator('Label');
        $this->addElement($key);
        
        // -> Password
        $password = $this->createElement('password', 'password');
        $password->setLabel('New Password')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        $this->addElement($password);

        // -> Password Confirm
        // ---> Validator password
        $identValidator = new Zend_Validate_Identical($_POST['password']);
        $identValidator->setMessages(
            array('notSame' => 'Value doesn\'t match!',
                  'missingToken' => 'Value doesn\'t match!'));
        
        $password2 = $this->createElement('password', 'password2');
        $password2->setLabel('Confirm new password:')
                  ->setRequired(true)
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator($identValidator);
        $this->addElement($password2);

        // -> Submit
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Change')
               ->removeDecorator('Label');
        $this->addElement($submit);
    }
}

