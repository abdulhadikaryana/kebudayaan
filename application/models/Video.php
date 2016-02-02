<?php

/**
 * Model_Video
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan video
 *
 * @package Model
 * @copyright Copyright (c) 2010 Sangkuriang Solution
 * @author Sangkuriang Solution <www.sangkuriangstudio.com>
 *
 */
class Model_Video {

    /**
     * Youtube Object
     * @var Zend_Gdata_YouTube
     */
    private $_youtubeService;

    /**
     * Application ID di Youtube
     * @var string
     */
    private $_applicationId = 'Indonesia Berbudaya';

    /**
     * Client ID di Youtube
     * @var string
     */
    private $_clientId = 'IndonesiaBerbudaya';

    /**
     * Developer key Youtube
     * @var string
     */
    private $_developerKey = 'AI39si5mfqE9-uvpiCtM-wA4ClXLWakTm7dEf2g4mSmm_W0UAKzvmzTfAqbKwykMu778nsYeeKwXOY52zl0OZeTOF5ggT-M8aQ';

    /**
     * Username Youtube
     * @var string
     */
    private $_username = 'subbagdatainfo@gmail.com';

    public function __construct() {
        $httpClient = null;
        // Buat client login di Youtube
        $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
        try {
            $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                            $username = $this->_username,
                            $password = 'mantapcoy', $service = 'youtube',
                            $client = null, $source = 'MySource',
                            $loginToken = null, $loginCaptcha = null,
                            $authenticationURL);
        } catch (Zend_Gdata_App_Exception $ex) {
            print_r($ex->getMessage());
        }
        // Inisialisasi Youtube web service
        $this->_youTubeService = new Zend_Gdata_YouTube($httpClient,
                        $this->_applicationId, $this->_clientId, $this->_developerKey);
                
    }

    public function getAllVideos() {
        // Get video
        //$videoFeed = $this->_youTubeService->getVideoFeed(
        //  'http://gdata.youtube.com/feeds/users/default/favorites?start-index=1&orderby=published');
        // Query video
        $query = $this->_youTubeService->newVideoQuery();
        $query->setAuthor($this->_username);
        $query->setStartIndex(1);
        $query->setOrderBy('updated');

        // Ambil data
        $videoFeed = $this->_youTubeService->getVideoFeed($query);

        return $videoFeed;
    }

    public function getMostViewedVideos($startIndex, $maxResult) {
        // Query video
        $query = $this->_youTubeService->newVideoQuery();
        $query->setAuthor('azVC56xAwXKRiQlg7DNlVA'); // author id
        $query->setStartIndex($startIndex);
        $query->setMaxResults($maxResult);
        $query->setOrderBy('published');

        // Ambil data
        $videoFeed = $this->_youTubeService->getVideoFeed($query);

        return $videoFeed;
    }

    public function getTotalFeeds() {
        // Query video
        $query = $this->_youTubeService->newVideoQuery();
        $query->setAuthor($this->_username);
        $query->setStartIndex(1);
        $query->setOrderBy('viewCount');

        // Ambil data
        $videoFeed = $this->_youTubeService->getVideoFeed($query);

        $count = 0;
        foreach ($videoFeed as $video) {
            $count++;
        }

        return $count;
    }

}

?>
