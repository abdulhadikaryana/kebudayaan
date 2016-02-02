<?php
/**
 * Form_RegistrationForm
 *
 * Form untuk registrasi
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_RegistrationForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        $langId = Zend_Registry::get('languageId');
        if($langId!=2){
            $textrealnamereg = 'Real Name';
            $textconfpassreg = 'Confirm Password';
            $textcountryreg = 'Country';
            $textselectcountryreg = 'Choose Country';
            $textreg = 'Register';

        }else{
            $textrealnamereg = 'Nama Asli';
            $textconfpassreg = 'Konfirmasi Password';
            $textcountryreg = 'Negara';
            $textselectcountryreg = 'Pilih Negara Anda';
            $textreg = 'Daftar';
        }


        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'inputForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/registration/index',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // Element Form
        // -> Real Name
        $realName = $this->createElement('text', 'realname');
        $realName->setLabel($textrealnamereg)
                 ->setRequired(true)
                 ->addValidator(new Zend_Validate_StringLength(3, 20));
        $this->addElement($realName);

        // -> Username
        $username = $this->createElement('text', 'username');
        $username->setLabel('Username')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator(new Zend_Validate_StringLength(3, 20))
                 ->addValidator(new Zend_Validate_Db_NoRecordExists('user', 'username'));
        $this->addElement($username);

        // -> Password
        $password = $this->createElement('password', 'password');
        $password->setLabel('Password')
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
        $password2->setLabel($textconfpassreg)
                  ->setRequired(true)
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator($identValidator);
        $this->addElement($password2);

        // -> Email
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email:')
              ->setRequired(true)
              ->addValidator(new Zend_Validate_EmailAddress())
              ->addValidator(new Zend_Validate_Db_NoRecordExists('user', 'email'));
        $this->addElement($email);

        // -> Country
        // ----> Model Country
        $countryModel = new Model_Country;
        $countryData = $countryModel->getNameCountry();
        $countryData[""] = $textselectcountryreg;

        $country = $this->createElement('select', 'country');
        $country->setLabel($textcountryreg)
                ->setRequired(true)
                ->setMultiOptions($countryData);
        $this->addElement($country);

        // -> Captcha
        $publicKey = Zend_Registry::get('recaptcha_public_key');
        $privateKey = Zend_Registry::get('recaptcha_private_key');
        $recaptcha = new Zend_Service_ReCaptcha($publicKey, $privateKey);

        $captcha = new Zend_Form_Element_Captcha('captcha', array(
            'captcha'        => 'ReCaptcha',
            'captchaOptions' => array(
                'captcha' => 'ReCaptcha', 'service' => $recaptcha)
        ));
        $this->addElement($captcha);

        // -> Submit
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($textreg)
               ->removeDecorator('Label');
        $this->addElement($submit);
    }
}

