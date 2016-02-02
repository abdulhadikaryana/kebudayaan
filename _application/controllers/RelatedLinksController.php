<?php
/**
 * RelatedLinksController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * related links
 *
 * @package Front Controller
 */
class RelatedLinksController extends Budpar_Controller_Common
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
     * FS: Mengirimkan ke viewer: relatedLink, categorylist, customName
     * Desc: Fungsi untuk menampilkan daftar related links
     */
    public function indexAction()
    {
        $relatedDb = new Model_DbTable_Related();
        $relatedDescDb = new Model_DbTable_RelatedDescription();
        $category = $this->_getParam('category');
        if($this->_languageId==2)
        {
            $textselectcat = "---Semua Kategori---";
            $customName = 'link terkait';
        }else
        {
            $textselectcat = "---All Categories---";
            $customName = 'related link(s)';
        }
        if($this->_languageId==2)
        {
            $categorylist = $relatedDescDb->getAllTypeDescIndo($textselectcat,$this->_languageId);
            if($category > 0)
            {
                $data = $relatedDescDb->getAllByType($category,$this->_languageId);
                $this->view->relatedlink = parent::setPaginator($data);
            }else
            {
                $linkData = $relatedDescDb->getAll();
	            $this->view->relatedlink = parent::setPaginator($linkData);
            }
               
        }else
        {
            $categorylist = $relatedDb->getAllTypeDesc($textselectcat,$this->_languageId);
            if($category > 0)
            {
                $data = $relatedDb->getAllByType($category,$this->_languageId);
                $this->view->relatedlink = parent::setPaginator($data);
            }else
            {
                $linkData = $relatedDb->getAll();
	            $this->view->relatedlink = parent::setPaginator($linkData);
            }
        }
        $this->view->categorylist = $this->view->formSelect('type',$category,array('onchange' => 'filter(this.value)'),$categorylist);

        $this->view->customName = $customName;
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        // id_title_overseas = 'Overseas Representatives'
        $title = $this->view->translate('id_menu_link');
        $links = array(
                $texthomelink => $this->view->baseUrl('/'),
                $title => '',
        );
        $this->view->pageTitle = $title;

        Zend_Registry::set('breadcrumb', $links);
    }

    public function tesAction(){
        $relatedDb = new Model_DbTable_Related();
        $relatedDescDb = new Model_DbTable_RelatedDescription();

        $tesdata = $relatedDb->getDataByRelId(36);
        $id = $tesdata['id'];
        $title = $tesdata['title'];
        $desc = $tesdata['description'];
        $link = $tesdata['link'];

        
        $dataku = array(
                            'id' => $id,
                            'language_id' => 1,
                            'title' => $title,
                            'description' => $desc,
                            'link' => $link,
                    );
        
        $relatedDescDb->insertDataRel($dataku);
        print_r('rerereere');
    }
}
?>