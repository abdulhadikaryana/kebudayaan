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
class Model_Contact
{
    //put your code here

    public function getContactUsMessage($baseUrl, $name)
    {
        $msg = 'The indonesia.travel site has a new comment from:<br />
                Name    : ' . $name . '<br />

                You can view this comment at ' . $baseUrl . '/admin/contact/';
        
        return $msg;
    }

}
