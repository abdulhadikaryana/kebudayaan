<?php

class Admin_Form_UserForm extends Zend_Form
{
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $name;
  /**
   *
   * @var Zend_Form_Element_Password
   */
  public $new_password;
  /**
   *
   * @var Zend_Form_Element_Password
   */
  public $confirm_password;
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $email;
  /**
   *
   * @var Zend_Form_Element_Textarea
   */
  public $biography;
  /**
   *
   * @var Zend_Form_Element_Submit
   */
  public $submit;

  public function init()
  {
    $this->name = new Zend_Form_Element_Text('name');
    $this->new_password = new Zend_Form_Element_Password('new_password');
    $this->confirm_password = new Zend_Form_Element_Password('confirm_password');
    $this->email = new Zend_Form_Element_Text('email');
    $this->biography = new Zend_Form_Element_Textarea('biography');
    $this->submit = new Zend_Form_Element_Submit('submit');

    $email_validator = new Zend_Validate_EmailAddress();
    $email_validator->setDeepMxCheck(false);
    $email_validator->setDomainCheck(false);
    $email_validator->setMessages(array(
        Zend_Validate_EmailAddress::INVALID_FORMAT => "Format Email Salah",
    ));

    $confirm_password_validator = new Zend_Validate_Identical();
    $confirm_password_validator->setMessage("Kata sandi tidak cocok.");

    $this->biography->setAttribs(array(
        'style' => 'width:100%;height:240px',
    ));

    $this->name->setAttribs(array(
        'class'       => 'span6',
        'placeholder' => 'Nama lengkap anda',
    ));

    $this->email->addValidator($email_validator)
            ->setAttribs(array(
                'class'       => 'span4',
                'placeholder' => 'pengguna@contoh.com'
            ));

    $this->submit->setAttribs(array(
        'class' => 'btn btn-success'
    ))->setLabel('Simpan');

    $this->confirm_password->addValidator($confirm_password_validator);

    $this->addElements(array(
        $this->name,
        $this->new_password,
        $this->confirm_password,
        $this->email,
        $this->biography,
        $this->submit
    ));

    $this->setElementDecorators(array(
        'ViewHelper', 'Errors'
    ));
  }

  public function isValid($data)
  {
    $this->confirm_password->getValidator('identical')->setToken(
            $data['new_password']);

    return parent::isValid($data);
  }

}