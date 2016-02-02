<?php
/**
 * Video
 */
class Video extends Zend_Db_Table_Abstract {
    
    public function httpClient() {
        $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                        $username = 'Budapar',
                        $password = 'budpar',
                        $service = 'youtube',
                        $client = null,
                        $source = 'MySource',
                        $loginToken = null,
                        $loginCaptcha = null,
                        $authenticationURL);
        return $httpClient;
    }
}

?>
