<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Country
 *
 * @author BackpackerMania
 */
class Model_User
{
    //put your code here
    public function getActivationMessage($rootUrl, $name, $email, $activationkey)
    {
        $htmlMsg = "
                Dear ".$name.",<br />
                <br />
                Welcome to Visit Indonesia - Indonesia Tourism Official Website <br />
                <br />
                Your account is one step away from activation.  You can complete activation by clicking the following link:<br />
                <a href = '".$rootUrl."/registration/activate/email/".$email."/key/".$activationkey."/'>Activate Account</a> <br />
                <br />
                Thank you
                <br />
                <br />
                Best Regards, <br />
                Indonesian Tourism Website Team <br />
                <a href='www.indonesia.travel'>http://www.indonesia.travel</a>
            ";

        return $htmlMsg;
    }

    public function getForgotMessage($rootUrl, $name, $email, $activationkey)
    {
        $htmlMsg = "
                Dear ".$name.",<br />
                <br />
                You have lost your Visit Indonesia's password<br />
                <br />
                Please click on the following link: <br />
                <a href = '".$rootUrl."/registration/reset/email/".$email."/key/".$activationkey."/'>Reset Password</a> <br />
                <br />
                This will reset your password. You can then change it to other password.
                <br />
                <br />
                Best Regards, <br />
                Indonesian Tourism Website Team <br />
                <a href='www.indonesia.travel'>http://www.indonesia.travel</a>
            ";

        return $htmlMsg;
    }

}

