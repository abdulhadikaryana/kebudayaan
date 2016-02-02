<?php
/**
 * Form_ContactUsForm
 *
 * Form untuk contact us
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_ContactUsForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        $langId = Zend_Registry::get('languageId');
        if($langId == 2){ // English
            $textrealnamereg = 'Name';
            $textwebs = 'Website (Optional):';
            $textcountryreg = 'Country';
            $textselectcountryreg = 'Choose Country';
            $textreg = 'Submit';
            $textsubj = 'Subject:';
            $textsubjcolm = 'Choose Country';
            $textmsg = 'Message:';
        }else{
            $textrealnamereg = 'Nama';
            $textwebs = 'Website (Tidak Wajib):';
            $textcountryreg = 'Negara';
            $textselectcountryreg = 'Pilih Negara Anda';
            $textreg = 'Kirim';
            $textsubj = 'Subyek:';
            $textsubjcolm = 'Choose Country';
            $textmsg = 'Pesan:';
        }
        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'inputForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/contact-us/index',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // Element Form
        // -> Name
        $name = $this->createElement('text', 'name');
        $name->setLabel($textrealnamereg)
             ->setRequired(true);
        $this->addElement($name);

        // -> Email
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email:')
              ->setRequired(true)
              ->addValidator(new Zend_Validate_EmailAddress());
        $this->addElement($email);

        // -> Website
        $website = $this->createElement('text', 'website');
        $website->setLabel($textwebs)
                ->addValidator(new Budpar_Form_Validator_Url);
        $this->addElement($website);

        // -> Country
        // ----> Model Country
//        $country = $this->createElement('select', 'country');
//        $country->setLabel($textcountryreg)
//                ->setRequired(true)
//                ->setMultiOptions($countryData);
//        $this->addElement($country);

        // -> Subject
        $contactSubjectDb = new Model_DbTable_ContactSubject;
        $subjectData = $contactSubjectDb->getAllForForm($langId);

        $subject = $this->createElement('select', 'subject');
        $subject->setLabel($textsubj)
                ->setRequired(true)
                ->setMultiOptions($subjectData);
        $this->addElement($subject);

        // -> Message
        $message = $this->createElement('textarea', 'comment');
        $message->setLabel($textmsg)
                ->setRequired(true);
        $message->setAttrib('rows', 15);
        $this->addElement($message);

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
               ->removeDecorator('Label')
               ->setOptions(array('class' => 'button button-grey'));        
        $this->addElement($submit);
    }
}

