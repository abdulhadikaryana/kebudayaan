<?php
/**
 * InternationalController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * international event
 *
 * @package Front Controller
 */
class InternationalController extends Budpar_Controller_Common
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: international
     * Desc: Fungsi untuk menampilkan daftar international event
     */
    public function indexAction()
    {
        $langId = 1;
        
        $internationalDb = new Model_DbTable_International;
        $international = $internationalDb->getAllWithDesc($langId);

        $this->view->international = parent::setPaginator($international);
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: event
     * Desc: Fungsi untuk menampilkan detail international event
     */
    public function viewAction()
    {
        // Param
        $id = $this->_getParam('id');

        // Model
        $eventDb = new Model_DbTable_Event;
        
        // Data
        $event = $eventDb->getAllWithDescById($id, 1);

        // View
        $this->view->event = $event[0];
    }
}