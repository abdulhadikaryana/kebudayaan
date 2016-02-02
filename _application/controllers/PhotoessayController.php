<?php
/**
 * Photoessay controller
 *
 * Controller untuk halaman photo essay
 *
 * @package Front Controller
 */
 
class PhotoessayController extends Budpar_Controller_Common
{
    
    protected $_photoEssayTable;
    protected $_photoImageTable;
	protected $_essayCategory;
	
	public function init()
    {
        parent::init();
		//set photo essay layout
		$this->_helper->layout->setLayout('photo-essay');
		
		//init tables
        $this->_photoEssayTable = new Model_DbTable_Photoessay;
        $this->_photoImageTable = new Model_DbTable_Photoessayimage;
        $this->_essayCategory   = new Model_DbTable_EssayCategory;
  
		//get the date filter list
		$dateFilter = $this->_photoEssayTable->getDateList();
		$categoryFilter = $this->_essayCategory->getAll();
		
		//send datefilter option to view
		$this->view->categoryFilter = $categoryFilter;
		$this->view->dateFilter = $dateFilter;
		$this->view->disableHeader = TRUE;
		
		$this->showLatestEssay();
	}
	
    public function indexAction()
    {
    	$dateParam = $this->_getParam('datefilter');
		$categoryParam = $this->_getParam('categoryfilter');
		
		$paramsArr = array();
		$this->view->terms = '';
		
		if($dateParam)
    	{
			//if date param off and category param on
			if(is_numeric($dateParam))
			{
				$paramsArr['pe.category'] = $dateParam;
				$this->view->terms .= ' By category - ' . $this->_essayCategory->getTitleByID($dateParam).'.';
				$this->view->categoryTerms = $dateParam;
			}
			else
			{
				$paramsArr['DATE_FORMAT(pe.publishdate,"%M-%Y")'] = $dateParam;
				$this->view->terms .= ' By date - '.$dateParam.'.';
				$this->view->dateTerms = $dateParam;
			}
		}
		
		if($categoryParam)
		{
			$paramsArr['pe.category'] = $categoryParam;
			$this->view->terms .= ' By category - ' . $this->_essayCategory->getTitleByID($categoryParam).'.';
			$this->view->categoryTerms = $categoryParam;
		}
		
		$essayQuery = $this->_photoEssayTable->getEssayList($paramsArr, TRUE);
		$essayList = parent::setPaginator($essayQuery, 2, 3);
		$this->view->essayList = $essayList;
		$this->view->fb = $this->_fb;
	}


    public function searchAction(){

        $filterSess = new Zend_Session_Namespace('keyword');
        
        if($this->getRequest()->isPost())
        {
            unset($filterSess->keyword);
            $filterSess->keyword = $this->getRequest()->getPost('keyword');
        }

        $data = $this->_photoEssayTable->searchData($filterSess->keyword);
        $essayList = parent::setPaginator($data, 2, 3);
        $this->view->essayList = $essayList;
        $this->view->fb = $this->_fb;

        $this->render('index');
    }
    
    public function detailsAction()
    {
		$postID = $this->_getParam('post');
		$this->view->postID = $postID;
		
		$essayImages = $this->_photoImageTable->getImageByEssayID($postID);
		$essayContent = $this->_photoEssayTable->getEssayByID($postID);
		$essayContent['image'] = $essayImages;

		$xid = 'photoessay_'.$postID;
		$comments = $this->_fb->api(array('method' => 'comments_get', 'xid' => $xid));
		$this->view->removeWebTitle = TRUE;
		$this->view->pageTitle = $essayContent['title'];

		$this->view->commentCount = sizeof($comments);
		$this->view->data = $essayContent;
    	$this->view->appID = Zend_Registry::get('fb_app_id');
	}
	
	protected function showLatestEssay($amount = 3)
	{
    	$latestEssay = $this->_photoEssayTable->getLatestEssayTitle($amount);
    	$this->view->latestEssay = $latestEssay;
	}

}