<?php
/**
 *
 * @package Front Controller
 */

class UsercontributorController extends Budpar_Controller_Common
{
    public function init()
    {
        parent::init();

        $this->_helper->layout->setLayout('Usercontributor/usercontributor');

        //model
        $model = new Model_Usercontributor();
        
        //parameter content type untuk menyeleksi comment
        // 1 => news, 2 => event, 3 => user contributor
        $this->view->comment_type = 3;

        //category
//        $this->view->userstory_category = $model->select_category($this->_languageId);
        //hanya menampilkan category yang mempunyai artikel
        $this->view->userstory_category = $model->select_category_hascontent($this->_languageId);

        //popular post
        $this->view->popular_post = $model->popular_post($this->_languageId);
        
        //param limit user contributor yg akan ditampilkan di side bar ( default 3 orang)
        $limit = 3;
        
        //user contributor
        $this->view->user_contributor = $model->user_contributor($limit);
        
        //archive
        $this->view->archive_sidebar = $model->archive($this->_languageId);
        
        //lang_id
        $this->view->lang_id = $this->_languageId;


        //image bacground dan header
        //model
        $modelImage = new Model_DbTable_UserStoryImage();
        $this->view->head_image = $modelImage->getDataNew('header');
        $this->view->background_image = $modelImage->getDataNew('background');

        $cek = $model->cekContentByLang($this->_languageId);
        $this->view->contenInThisLang = (!empty($cek)?true :false);

    }
    
    /*
    * paginator function
    * param database_result,display per_page
    */
    private function _paginator($data,$per_page)
    {
        
        if(count($data) > 0)
        {
            /** Get the page number , default 1*/
           $page = $this->_getParam('page',1);
           
           /** Object of Zend_Paginator*/
           $paginator = Zend_Paginator::factory($data);
           
           /** Set the number of counts in a page*/
           $paginator->setItemCountPerPage($per_page);/*
           
           * Set the current page number*/
           $paginator->setCurrentPageNumber($page);
           
           return $paginator;
        }
            
    }
    
    public function popularpostAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        //popular post
        $model = new Model_UserContributor();
        $result = $model->popular_post($this->_languageId);
       
        if(count($result))
        {
            $data['result'] = '';
            foreach($result as $popular_post)
            {
                $data['result'] .= '<div class="link-area">';
                $data['result'] .= '<img src="'.$this->view->imageUrl().'/usercon/btn-popular.png" alt="popular" />';
                $data['result'] .= '<a href="'.$this->view->baseUrl('/usercontributor/detail/'.$popular_post->id.'/title/'.$this->view->makeUrlFormat($popular_post->title)).'" class="post-link display-block">';
                $data['result'] .= $popular_post->title;
                $data['result'] .= '</a>';
                $data['result'] .= '</div>';
            }
        }
        
        echo json_encode($data);
    }

    /*
        param category
        values = all category 
        values = artice category 
        values = photoessay category 
    
    */    
    public function indexAction()
    {
//        parent::disableView();

        $category = $this->_getParam('category',0);

        //
        $model = new Model_UserContributor();

        if($category)
        {
            if($category == "all")
            {
                $result = $model->contentIndex($this->_languageId);
                $this->view->category = $category;
            }
            else
            {
                $result = $model->filterContent($category,$this->_languageId);
                $this->view->category = $category;
            }
        }else{
            $result = $model->contentIndex($this->_languageId);
            $this->view->category = 'all';
        }
        ///** Assign to view*/
        $per_page = 5;
        $this->view->content = $this->_paginator($result,$per_page);
        
    }

    /*
        param category
        values = all category 
        values = artice category 
        values = photoessay category 
    */
    public function indexcategoryAction()
    {
        /* type = photoessay atau article */
        $type = $this->_getParam('type');
        
        $category = $this->_getParam('category');
        $userstory_category_id = $this->_getParam('id');

        $model = new Model_UserContributor();
        $result = $model->contentIndexCategory($userstory_category_id);
        
        /** Assign to view*/
        $per_page = 5;
        $this->view->content = $this->_paginator($result,$per_page);
        
        $this->view->category_content = $category;
        $this->view->category = $type;
        
        $this->render('index');
    }
    
    public function testAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $db = new Model_DbTable_UserStoryPhotoessay();
        $img = $db->getByUserstory(1,$this->_languageId);
        print_r($img);
    }
    
    /*
        param tag_id
        values = all category 
        values = artice category 
        values = photoessay category 
    
        untuk merender content story berdasarkan tags
    */    
    public function indextagsAction()
    {
        //$this->_helper->layout->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);

        $tag_id = $this->_getParam('tags');
        $tag_type = $this->_getParam('type');
        
        $db = new Model_DbTable_UserStoryTag();
        $result = $db->getByTagId($tag_id,$tag_type,$this->_languageId);
        
        /** Assign to view*/
        $per_page = 3;
        $this->view->content = $this->_paginator($result,$per_page);
        $this->view->category = 'all';
        
        $this->render('index');
    }
    
    /*
        Fungsi untuk menangani page archive
    */
    public function archiveAction(){
        //param
        $month = $this->_getParam('month');

        $model = new Model_UserContributor();
        $result = $model->contentArchive($month,$this->_languageId);
 
        $per_page = 3;
        $this->view->archive = $this->_paginator($result,$per_page);
        $this->view->bulan = $month;
        $this->view->category = 'all';
    }

    /*
        Fungsi untuk menangani page detail content
    */
    public function detailAction(){

        //param
        $userstory_id = $this->_getParam('id');
        $title = $this->_getParam('title');
        $type = $this->_getParam('type');
        
        //untuk comment
        $contentType = 3;

        //echo $this->_languageId;        
        ////model
        $model = new Model_UserContributor();
        $commentDb = new Model_DbTable_Comment;
        
        $detail = $model->contentDetail($userstory_id, $this->_languageId);
        if($detail)
        {
            //update viewd counter
            $viewed = $model->getViewed($userstory_id);
            $model->updateViewed($userstory_id, $viewed['viewed']+1);

            $this->view->detail = $detail;
            $this->view->content_type = $type;

            $comment_parent = $commentDb->getAllByContentTypeFix($userstory_id, $contentType);
            $this->view->comments = $comment_parent;
            $this->view->contentType = $contentType;
            $this->view->id = $userstory_id;
            $this->view->category = $type;

            //////Form
            $commentForm = new Form_CommentForm;

            // Request dari Comment Form
            if($this->getRequest()->isPost())
            {
                if($commentForm->isValid($this->getRequest()->getPost()))
                {

                    $autor = (isset($_POST['author']))? $_POST['author'] : "";
                    $email = (isset($_POST['email']))? $_POST['email'] : "";
                    $website = (isset($_POST['website']))? $_POST['website'] : "";

                    $input = array(
                        'author' => $autor,
                        'email' => $email,
                        'website' => $website,
                        'comment' => $_POST['comment'],
                        'parent_id'=>0,
                        'level'=>0
                    );

                    //print_r($input);

                    // Insert
                    $commentId = $commentDb->insertCommentUsercon($userstory_id, $contentType, $input, $this->_sess->userId,$this->_sess->fbname);

                    // Reset form
                    $commentForm->reset();

                    // Redirect
                    $this->_redirector->gotoUrl($this->view->currentUrl());
                }
            }

            $commentForm->setAttrib('action', $this->view->currentUrl());
            $this->view->commentForm = $commentForm;


        }
        else{
            $this->_redirector->gotoUrl($this->view->baseUrl('usercontributor'));
        }
    }

    public function replycommentAction()
    {
        $this->_helper->layout->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);
        
        //form
        $commentForm = new Form_CommentForm;
        $commentForm->init();
        $commentForm->setAttrib('action', $this->view->currentUrl());
        
        //model
        $commentDb = new Model_DbTable_Comment;
        
        //parameter
        $id = $this->_getParam('id');
        $contentType = 3;
        
        //cek id parent comment        
        if($this->_getParam('id_par'))
        {
            $id_parent = $this->_getParam('id_par');
        }
        else
        {
            $id_parent = 0;
        }

        //cek id child comment        
        if($this->_getParam('id_child'))
        {
            $id_child = $this->_getParam('id_child');
        }
        else
        {
            $id_child = 0;
        }
        
        //echo $id .'-'.$id_parent.'-'.$id_child;

        // Request dari Comment Form
        if($this->getRequest()->isPost())
        {
            if($commentForm->isValid($this->getRequest()->getPost()))
            {
                $autor = (isset($_POST['author']))? $_POST['author'] : "";
                $email = (isset($_POST['email']))? $_POST['email'] : "";
                $website = (isset($_POST['website']))? $_POST['website'] : "";
        
                if($id_parent != null AND $id_child != null)
                {
                    $input = array(
                        'author' => $autor,
                        'email' => $email,
                        'website' => $website,
                        'comment' => $_POST['comment'],
                        'parent_id' => $id_parent,
                        'level' => $id_child
                    );                    
        
                }
                else
                {
                    $input = array(
                        'author' => $autor,
                        'email' => $email,
                        'website' => $website,
                        'comment' => $_POST['comment'],
                        'parent_id' => $id_parent,
                        'level'=> 0
                    );
                }
                
                // Insert
                $commentId = $commentDb->insertCommentUsercon($id, $contentType,$input, $this->_sess->userId,$this->_sess->fbname);
        
                // Reset form
                $commentForm->reset();
                $this->view->commentForm = $this->view->translate('id_thanks_comment');
 
                // Redirect
                echo "<script type=text/javascript> window.parent.location.href = window.parent.location.href;</script>";
                //$this->_redirector->gotoUrl($this->view->currentUrl());
            }else{
                echo 'tidak valid';
            }
        }
        else
        {
            $this->view->commentForm = $commentForm;
        }
    }

    
    /*
        Fungsi untuk menghandle page author
    */
    public function authorAction(){
        //$this->_helper->layout->disableLayout(); /* disable layout */
        //$this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */

        //param
        $author_id = $this->_getParam('id');
        $title = $this->_getParam('name');
        $sort = $this->_getParam('sort');
        
        //model
        $model = new Model_UserContributor();
        $author = $model->detailAuthor($author_id);
        
        //print_r($author);
        $this->view->author = $author;
        $this->view->author_id = $author_id;
        
        //sorting
        if($sort == 'default')
        {
            $result = $model->detailContentAuthor($author_id,$this->_languageId);
            $this->view->sort_by = 'default';
        }
        else if($sort == 'date')
        {
            $result = $model->sortBy($author_id,$sort,$this->_languageId);
            $this->view->sort_by = 'date';
        }
        else if($sort == "popular-post")
        {
            $result = $model->sortBy($author_id,$sort,$this->_languageId);
            $this->view->sort_by = 'popular-post';
        }
        else
        {
            $result = $model->detailContentAuthor($author_id,$this->_languageId);
            $result = $model->detailContentAuthor($author_id,$this->_languageId);
            $this->view->sort_by = 'default';
        }
        
        if(count($result) > 0)
        {
            $per_page = 4;
            $this->view->content_author = $this->_paginator($result,$per_page);            
        }
        else
        {
            
        }

    }
    
    /* sorting data berdasarkan date dan popular post */
    public function sortbyAction(){

        $author_id = $this->_getParam('id');
        $sort = $this->_getParam('sortby');
        //echo $sort;


        $model = new Model_UserContributor();
        $author = $model->detailAuthor($author_id);
        $this->view->author = $author;
        $this->view->author_id = $author_id;

        $result = $model->detailContentAuthor($author_id,$this->_languageId);
        if(count($result) > 0)
        {
             $per_page = 4;
             $this->view->content_author = $this->_paginator($result,$per_page);            
        }
        else
        {
            
        }
        
        $this->render('author');

    }


    public function authorlistAction(){
        $model = new Model_UserContributor();
        $result = $model->listAuthor();
        if($result)
        {
            $per_page = 7;
            $this->view->contributor = $this->_paginator($result,$per_page);        
        }
    }


    
    /*
     * Fungsi untuk menghandle fitur searching
     * param = keyword
    */
    public function searchAction()
    {
        //param
        $get_keyword = $this->_getParam(urldecode('keyword'));
        $keyword =  ($get_keyword == "Search...")? "" : $get_keyword;
        $get_category = $this->_getParam(urldecode('category'));
        $category = ($get_category == "") ? 'all' : $this->_getParam(urldecode('category'));

        if($keyword)
        {
            $model = new Model_UserContributor();
            $result = $model->searching($keyword,$category,$this->_languageId);

            if($result)
            {
                $per_page = 5;
                $this->view->content = $this->_paginator($result,$per_page);
            }
            $this->view->keyword = $keyword;
            $this->view->category = $category;
            $this->view->is_search = $category;
        }
        else{
            $this->view->keyword = $keyword;
            $this->view->is_search = false;
        }
    }


    /*
        Fungsi untuk penanganan rating content
    */
    public function ratingAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(); /* disable layout */
            $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
            
            //param
            $userstory_id = $this->_request->getPost('userstory_id');
            $score_rating = $this->_request->getPost('score_rating');
            $rating_status = 1;
            
            //model
            $db = new Model_UserContributor();
            $db->updateRating($userstory_id,$score_rating,$rating_status);
            
            $data['result'] = $score_rating;
            echo json_encode($data);
        
        }
    }

    /*
        Fungsi untuk penanganan rating author
    */    
    public function ratingauthorAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(); /* disable layout */
            $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
            
            //param
            $author_id = $this->_request->getPost('author_id');
            $score_rating = $this->_request->getPost('score_rating');
            $rating_status = 2;
            
            //model
            $db = new Model_UserContributor();
            $db->updateRating($author_id,$score_rating,$rating_status);
            
            $data['result'] = $author_id;
            echo json_encode($data);
        }
    }


    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk generate RSS
     */
    public function rssAction()
    {
        // Tidak pake layout
	//$this->getResponse()->setHeader('Content-Type', 'text/xml');
        //$this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        $this->_helper->layout->disableLayout();

        // Model
        $userstoryDb = new Model_DbTable_UserStory();
        $userstoryQuery = $userstoryDb->getAllDataWithContent($this->_languageId);
        
        //print_r($userstoryQuery);

        $userstory = $userstoryDb->fetchAll($userstoryQuery);
        //echo count($userstory);
        for($i=0; $i<count($userstory);$i++)
        {
            //echo $userstory[$i]['title'];
        	$string = $userstory[$i]['title'];
		$string = str_replace('�',' ',$string); 
		$string = str_replace('�',' ',$string); 
		$string = str_replace('',' ',$string); 
		$string = str_replace('�',' ',$string);
		$userstory[$i]['title'] = $this->xmlEntities(strip_tags($this->view->htmlDecode(htmlentities($string, ENT_QUOTES))));

        	$string = $userstory[$i]['content'];
		$string = str_replace('�',' ',$string); 
		$string = str_replace('�',' ',$string); 
		$string = str_replace('?',' ',$string); 
		$string = str_replace('�',' ',$string);
		$userstory[$i]['content'] = $this->xmlEntities(strip_tags($this->view->htmlDecode(htmlentities($string, ENT_QUOTES))));
	}

    	$this->view->data = $userstory;
    }

    protected function xmlEntities($str) 
    { 
	$xml = array('&#34;','&#38;','&#38;','&#60;','&#62;','&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;');
	$html = array('&quot;','&amp;','&amp;','&lt;','&gt;','&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;');
	$str = str_replace($html,$xml,$str);
	$str = str_ireplace($html,$xml,$str);
	return $str; 
    }

}
?>