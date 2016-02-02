<?php
/**
 * SearchController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * search
 *
 * @package Front Controller
 */
class SearchController extends Budpar_Controller_Common
{
    public function init()
    {
        parent::init();
        $this->view->assets = $this->_request->getBaseUrl();
        define("LIMIT", 7); //konstanta untuk mengatur jumlah content per page
        define("NUM_LINKS", 7); //konstanta untuk mengatur jumlah link page
        
        $getLang = new Model_DbTable_Language();
        $lang = $getLang->getNameById($this->_languageId);
        $this->lang = $lang->language_name;
        $this->_helper->layout->setLayout('one-column');


        //$destinationDesc = new Model_DbTable_DestinationDescription;
        //$a = $destinationDesc->getNameById(33,1);
        //
        //echo $a;


        
    }


    public function indexAction()
    {
        
        /*
            $filterSpace = keyword;
        */
        
        $filterSpace = strip_tags($this->_getParam(urldecode('key')));
		$filterSpace = filter_var($filterSpace, FILTER_SANITIZE_SPECIAL_CHARS);
        if($filterSpace == NULL)
        {
            $this->view->emptyResult = 'Please enter a keyword!';
        }
        else
        {

            $param = str_replace("  "," ",$filterSpace);
    
            $limit = LIMIT ; /* limit perpage*/
            $offset = 0; /* default offset*/
    
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -*/
            /*                          query news content                         */
            /* - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - -*/
            $searchNews = new Model_DbTable_News();
            $getResultNews = $searchNews->searchNewsBaru($param,$limit,$offset,$this->_languageId);
            //$getResultNews = $searchNews->searchNews($param,$limit,$offset,$this->_languageId);
            
            if(count($getResultNews) > 0)
            {
                $news = '';
                foreach($getResultNews as $rowNews)
                {
                    $title = $this->view->boldStyle(strtolower($rowNews['title']),$param);
    
                    $news .= '<li>';
                    $news .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/news/detail/'.$rowNews['id'].'/'.$this->view->makeUrlFormat($rowNews['title']).'" title="'.$rowNews['title'].'">'.ltrim($title,"\t").'</a>';
                    $news .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode(($rowNews['content'])))),0,225).' ...';
                    $news .= '</li>';
                }
            }else{
//                $news = '<li><a href="#">no data that matches with keyword you enter : <b>'.$param.'</b></a></li>';
            }
            $this->view->news = $news;
            
            
            $getTotalNews = $searchNews->numbRowsNews($param,$this->_languageId);
            $this->view->totalpage_news = ceil($getTotalNews / $limit);
    
            /* - - - - - - - - - - - link pages news  - - - - - - -  - - - - -  - -*/
            
            $curpageNews = 1;
            $num_linkNews = NUM_LINKS;
            $per_pageNews = $limit;
    
            // Calculate the start and end numbers. These determine
            // which number to start and end the digit links with
            $num_pageNews = ceil($getTotalNews / $limit);
            $startNews = (($curpageNews - $num_linkNews) > 0) ? $curpageNews - ($num_linkNews - 1) : 1;
            $endNews   = (($curpageNews + $num_linkNews) < $num_pageNews) ? $curpageNews + $num_linkNews : $num_pageNews;
    
            // Write the digit links
            $linkNews = '';
            for ($loop = $startNews -1; $loop <= $endNews; $loop++)
            {
                $i = ($loop * $per_pageNews) - $per_pageNews;
                $get_curpage  = $loop;
                //$get_curpage  = $loop - 1;
    
                if ($i >= 0)
                {
                    if ($curpageNews == $loop)
                    {
                        $linkNews .= '<div class="cur_page">'.$loop.'</div>'; // Current page
                    }
                    else
                    {
                        $n = ($i == 0) ? '' : $i;
                        $linkNews .= '<div class="pages news" title="'.$get_curpage.'">'.$loop.'</div>';
                        //$linkNews .= '<div class="pages news" id="'.$loop.'" title="'.$get_curpage.'">'.$loop.'</div>';
                    }
                }
            }       
            $this->view->linkpage_news = $linkNews;
    
            /* - - - - - - - - - - - end link pages news- - - - - - - -  - - - - -  - -*/
    
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - -*/
            /*                       end query news                                     */
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - -*/
            
            
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -*/
            /*                         query event  content                         */
            /* - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - -*/
            
            $searchEvent = new Model_DbTable_Event();
            $getResultEvent = $searchEvent->searchEventBaru($param,$limit,$offset,$this->_languageId);
            //$getResultEvent = $searchEvent->searchEvent($param,$limit,$offset,$this->_languageId);
            
            if(count($getResultEvent) > 0)
            {
                $event = '';
                foreach($getResultEvent as $rowEvent)
                {
                    $title = $this->view->boldStyle(strtolower($rowEvent['name']),$param);
                    
                    $event .= '<li>';
                    $event .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/event/detail/'.$rowEvent['event_id'].'/'.$this->view->makeUrlFormat($rowEvent['name']).'" title="'.$rowEvent['name'].'">'.ltrim($title).'</a>';
    
                    $event .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowEvent['description']))),0,225).' ...';
                    $event .= '</li>';
                }
                
                
            }else{
                $event = '';
            }
            $this->view->event = $event;
            
            $getTotalEvent = $searchEvent->numbRowsEvent($param,$this->_languageId);
            $this->view->totalpage_event = ceil($getTotalEvent / $limit);
    
            /* - - - - - - - - - - - link pages event - - - - - - -  - - - - -  - -*/
            
            $curpageEvent = 1;
            $num_linkEvent = NUM_LINKS;
            $per_pageEvent = $limit;
    
            // Calculate the start and end numbers. These determine
            // which number to start and end the digit links with
            $num_pageEvent = ceil($getTotalEvent / $limit);
            $startEvent = (($curpageEvent - $num_linkEvent) > 0) ? $curpageEvent - ($num_linkEvent - 1) : 1;
            $endEvent   = (($curpageEvent + $num_linkEvent) < $num_pageEvent) ? $curpageEvent + $num_linkEvent : $num_pageEvent;
    
            // Write the digit links
            $linkEvent = '';
            for ($loop = $startEvent -1; $loop <= $endEvent; $loop++)
            {
                $i = ($loop * $per_pageEvent) - $per_pageEvent;
                $get_curpage  = $loop;
                //$get_curpage  = $loop - 1;
    
                if ($i >= 0)
                {
                    if ($curpageEvent == $loop)
                    {
                        $linkEvent .= '<div class="cur_page">'.$loop.'</div>'; // Current page
                    }
                    else
                    {
                        $n = ($i == 0) ? '' : $i;
                        $linkEvent .= '<div class="pages event" title="'.$get_curpage.'">'.$loop.'</div>';
                        //$linkEvent .= '<div class="pages event" id="'.$loop.'" title="'.$get_curpage.'">'.$loop.'</div>';
                    }
                }
            }       
            $this->view->linkpage_event = $linkEvent;
    
            /* - - - - - - - - - - - end link pages event - - - - - - - -  - - - - -  - -*/        
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - -*/
            /*                       end query event                                    */
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - -*/
            
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -*/
            /*                         query destination content                    */
            /* - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - -*/
            
            $searchDest = new Model_DbTable_Destination();
            $getResultDest = $searchDest->searchDestBaru($param,$limit,$offset,$this->_languageId);
            //$getResultDest = $searchDest->searchDest($param,$limit,$offset,$this->_languageId);
            
            if(count($getResultDest) > 0)
            {
                $dest = '';
                foreach($getResultDest as $rowDest)
                {
                    $title = $this->view->boldStyle(strtolower($rowDest['name']),$param);
                    $dest .= '<li>';
                    $dest .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/culture/'.$rowDest['poi_id'].'/'. $this->view->makeUrlFormat($rowDest['name']).'" title="'.$rowDest['name'].'">'.ltrim($title).'</a>';
                    $dest .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowDest['description']))),0,225).' ...';
                    $dest .= '</li>';
                }
            }
            else
            {
                
            }
            $this->view->destination = $dest;
            
            $getTotalDest = $searchDest->numbRowsDest($param, $this->_languageId);
            $this->view->totalpage_dest = ceil($getTotalDest / $limit);
            
//            link pages dest
            $curpageDest = 1;
            $num_linkDest = NUM_LINKS;
            $per_pageDest = $limit;
            
            $num_pageDest = ceil($getTotalDest / $limit);
            $startDest = (($curpageDest - $num_linkDest) > 0)? $curpageDest - ($num_linkDest - 1): 1;
            $endDest = (($curpageDest + $num_linkDest) < $num_pageDest) ? $curpageDest + $num_linkDest : $num_pageDest;
            
            $linkDest= '';
            for ($loop = $startDest -1;$loop <= $endDest; $loop++)
            {
                $i = ($loop * $per_pageDest) - $per_pageDest;
                $get_curpage = $loop;
                
                if($i >= 0)
                {
                    if($curpageDest == $loop)
                    {
                        $linkDest .= '<div class="cur_page">'.$loop.'</div>';
                    }
                    else
                    {
                        $n = ($i == 0) ? '' : $i;
                        $linkDest .= '<div class="pages dest" title="'.$get_curpage.'">'.$loop.'</div>';
                    }
                }
            }
            $this->view->linkpage_dest = $linkDest;
            
    
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - -*/
            /*                       end query destination                             */
            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - -*/
            
            $searchArticle = new Model_DbTable_Figure();
            $getResultArticle = $searchArticle->searchFig($param,$limit,$offset,$this->_languageId);
            //$getResultDest = $searchDest->searchDest($param,$limit,$offset,$this->_languageId);
            
            if(count($getResultArticle) > 0)
            {
                $article = '';
                foreach($getResultArticle as $rowArticle)
                {
                    $title = $this->view->boldStyle(strtolower($rowArticle['name']),$param);
                    $article .= '<li>';
                    $article .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/figure/detail/'.$rowArticle['figure_id'].'/'. $this->view->makeUrlFormat($rowArticle['name']).'" title="'.$rowArticle['name'].'">'.ltrim($title).'</a>';
                    $article .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowArticle['description']))),0,225).' ...';
                    $article .= '</li>';
                }
            }
            else
            {
                $article = '';
            }
            $this->view->article = $article;
            
            $getTotalArticle = $searchArticle->numbRowsFigure($param, $this->_languageId);
            $this->view->totalpage_article = ceil($getTotalArticle / $limit);
            
//            link pages dest
            $curpageArticle = 1;
            $num_linkArticle = NUM_LINKS;
            $per_pageArticle = $limit;
            
            $num_pageArticle = ceil($getTotalArticle / $limit);
            $startArticle = (($curpageArticle - $num_linkArticle) > 0)? $curpageArticle - ($num_linkArticle - 1): 1;
            $endArticle = (($curpageArticle + $num_linkArticle) < $num_pageArticle) ? $curpageArticle + $num_linkArticle : $num_pageArticle;
            
            $linkArticle= '';
            for ($loop = $startArticle -1;$loop <= $endArticle; $loop++)
            {
                $i = ($loop * $per_pageArticle) - $per_pageArticle;
                $get_curpage = $loop;
                
                if($i >= 0)
                {
                    if($curpageArticle == $loop)
                    {
                        $linkArticle .= '<div class="cur_page">'.$loop.'</div>';
                    }
                    else
                    {
                        $n = ($i == 0) ? '' : $i;
                        $linkArticle .= '<div class="pages dest" title="'.$get_curpage.'">'.$loop.'</div>';
                    }
                }
            }
            $this->view->linkpage_article = $linkArticle; 
            
//            end link figure
            
            
    
            
            $this->view->offset = $offset+$limit;
            $this->view->param = $param;
            $this->view->limit = $limit;


            
        }
    
        
    }
    
    /*
        newspagingAction : fungsi untuk menangani pagination content news
    */
    public function newspagingAction()
    {
        $this->_helper->layout->disableLayout(); /* disable layout */
        $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        
        $limit = $this->_getParam(urldecode('paramLimit'));
        $offset = $this->_getParam(urldecode('paramOffset'));
        $param = $this->_getParam(urldecode('paramKey'));
        
        $generateNews = new Model_DbTable_News();
        $getResultNews = $generateNews->searchNewsBaru($param,$limit,$offset,$this->_languageId);
        //$getResultNews = $generateNews->searchNews($param,$limit,$offset,$this->_languageId);

        $data['result'] = '';
        foreach($getResultNews as $rowNews)
        {
            $title = $this->view->boldStyle(strtolower($rowNews['title']),$param);

            $data['result'] .= '<li>';
            $data['result'] .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/news/detail/'.$rowNews['id'].'/'.$this->view->makeUrlFormat($rowNews['title']).'" title="'.$rowNews['title'].'">'.ltrim($title).'</a>';
            $data['result'] .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowNews['content']))),0,225).' ...';
            $data['result'] .= '</li>';
        }
        

        /* - - - - - - - - - - - link pages - - - - - - - - - -  - - - - -  - -*/
        $action_query = $this->_getParam(urldecode('actionQuery'));
        switch($action_query){
            case 'next' : $curpageNews = $this->_getParam(urldecode('paramPage'))+1; break;
            case 'prev' : $curpageNews = $this->_getParam(urldecode('paramPage'))-1; break;
            default : $curpageNews = $this->_getParam(urldecode('paramPage'))+1; break;
        }
        
        $num_linkNews = NUM_LINKS;
        $per_pageNews = $limit;
        
        $getTotalNews = $generateNews->numbRowsNews($param,$this->_languageId);

        $num_pageNews = ceil($getTotalNews / $limit);
        $startNews = (($curpageNews - $num_linkNews) > 0) ? $curpageNews - ($num_linkNews - 1) : 1;
        $endNews   = (($curpageNews + $num_linkNews) < $num_pageNews) ? $curpageNews + $num_linkNews : $num_pageNews;
        
        $data['start']		= $startNews;
        $data['end']		= $endNews;
        $data['per_pages']	= $per_pageNews;
        $data['cur_pages']	= $curpageNews;
        $data['all_page']	= $getTotalNews;
        

        /* - - - - - - - - - - - end link pages - - - - - - - -  - - - - -  - -*/
        
        $data['offset'] = $offset+$limit;
        $data['curpages'] = $curpageNews;
        
        echo json_encode($data);
    }


    /*
        eventpagingAction : fungsi untuk menangani pagination content event
    */
    public function eventpagingAction()
    {
        $this->_helper->layout->disableLayout(); /* disable layout */
        $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        
        $limit = $this->_getParam(urldecode('paramLimit'));
        $offset = $this->_getParam(urldecode('paramOffset'));
        $param = $this->_getParam(urldecode('paramKey'));
        
        $generateEvent = new Model_DbTable_Event();
        $getResultEvent = $generateEvent->searchEventBaru($param,$limit,$offset,$this->_languageId);
        //$getResultEvent = $generateEvent->searchEvent($param,$limit,$offset,$this->_languageId);

        $data['result'] = '';
        foreach($getResultEvent as $rowEvent)
        {
            $title = $this->view->boldStyle(strtolower($rowEvent['name']),$param);

            $data['result'] .= '<li>';
            $data['result'] .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/event/detail/'.$rowEvent['event_id'].'/'.$this->view->makeUrlFormat($rowEvent['name']).'" title="'.$rowEvent['name'].'">'.ltrim($title).'</a>';
            $data['result'] .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowEvent['description']))),0,225).' ...';
            $data['result'] .= '</li>';
        }
        

        /* - - - - - - - - - - - link pages - - - - - - - - - -  - - - - -  - -*/
        $action_query = $this->_getParam(urldecode('actionQuery'));
        switch($action_query){
            case 'next' : $curpageEvent = $this->_getParam(urldecode('paramPage'))+1; break;
            case 'prev' : $curpageEvent = $this->_getParam(urldecode('paramPage'))-1; break;
            default : $curpageEvent = $this->_getParam(urldecode('paramPage'))+1; break;
        }
        
        $num_linkEvent = NUM_LINKS;
        $per_pageEvent = $limit;
        
        $getTotalEvent = $generateEvent->numbRowsEvent($param,$this->_languageId);

        $num_pageEvent = ceil($getTotalEvent / $limit);
        $startEvent = (($curpageEvent - $num_linkEvent) > 0) ? $curpageEvent - ($num_linkEvent - 1) : 1;
        $endEvent   = (($curpageEvent + $num_linkEvent) < $num_pageEvent) ? $curpageEvent + $num_linkEvent : $num_pageEvent;
        
        $data['start']		= $startEvent;
        $data['end']		= $endEvent;
        $data['per_pages']	= $per_pageEvent;
        $data['cur_pages']	= $curpageEvent;
        $data['all_page']	= $getTotalEvent;
        

        /* - - - - - - - - - - - end link pages - - - - - - - -  - - - - -  - -*/        
        
        $data['offset'] = $offset+$limit;
        $data['curpages'] = $curpageEvent;
        
        echo json_encode($data);
    }
    


    /*
        destpagingAction : fungsi untuk menangani pagination content destination
    */
    public function destpagingAction()
    {
        $this->_helper->layout->disableLayout(); /* disable layout */
        $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        
        $limit = $this->_getParam(urldecode('paramLimit'));
        $offset = $this->_getParam(urldecode('paramOffset'));
        $param = $this->_getParam(urldecode('paramKey'));
        
        $generateDest = new Model_DbTable_Destination();
        $getResultDest = $generateDest->searchDestBaru($param,$limit,$offset,$this->_languageId);

        $data['result'] = '';
        foreach($getResultDest as $rowDest)
        {
            $title = $this->view->boldStyle(strtolower($rowDest['name']),$param);

            $data['result'] .= '<li>';
            $data['result'] .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/culture/'.$rowDest['poi_id'].'/'.$this->view->makeUrlFormat($rowDest['name']).'" title="'.$rowDest['name'].'">'.ltrim($title).'</a>';
            $data['result'] .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowDest['description']))),0,225).' ...';
            $data['result'] .= '</li>';
        }
        

        /* - - - - - - - - - - - link pages - - - - - - - - - -  - - - - -  - -*/
        $action_query = $this->_getParam(urldecode('actionQuery'));
        switch($action_query){
            case 'next' : $curpageDest = $this->_getParam(urldecode('paramPage'))+1; break;
            case 'prev' : $curpageDest = $this->_getParam(urldecode('paramPage'))-1; break;
            default : $curpageDest = $this->_getParam(urldecode('paramPage'))+1; break;
        }
        
        $num_linkDest = NUM_LINKS;
        $per_pageDest = $limit;
        
        $getTotalDest = $generateDest->numbRowsDest($param,$this->_languageId);

        $num_pageDest = ceil($getTotalDest / $limit);
        $startDest = (($curpageDest - $num_linkDest) > 0) ? $curpageDest - ($num_linkDest - 1) : 1;
        $endDest   = (($curpageDest + $num_linkDest) < $num_pageDest) ? $curpageDest + $num_linkDest : $num_pageDest;
        
        $data['start']		= $startDest;
        $data['end']		= $endDest;
        $data['per_pages']	= $per_pageDest;
        $data['cur_pages']	= $curpageDest;
        $data['all_page']	= $getTotalDest;
        

        /* - - - - - - - - - - - end link pages - - - - - - - -  - - - - -  - -*/
        
        $data['offset'] = $offset+$limit;
        $data['curpages'] = $curpageDest;
        
        echo json_encode($data);
    }

    public function articlepagingAction()
    {
        $this->_helper->layout->disableLayout(); /* disable layout */
        $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        
        $limit = $this->_getParam(urldecode('paramLimit'));
        $offset = $this->_getParam(urldecode('paramOffset'));
        $param = $this->_getParam(urldecode('paramKey'));
        
        $generateArticle = new Model_DbTable_Figure();
        $getResultArticle = $generateArticle->searchFig($param,$limit,$offset,$this->_languageId);
       
        $data['result'] = '';
        foreach($getResultArticle as $rowArticle)
        {
            $title = $this->view->boldStyle(strtolower($rowArticle['name']),$param);

            $data['result'] .= '<li>';
            $data['result'] .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/figure/detail/'.$rowArticle['figure_id'].'/'.$this->view->makeUrlFormat($rowArticle['name']).'" title="'.$rowArticle['name'].'">'.ltrim($title).'</a>';
            $data['result'] .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowArticle['description']))),0,225).' ...';
            $data['result'] .= '</li>';
        }
        

        /* - - - - - - - - - - - link pages - - - - - - - - - -  - - - - -  - -*/
        $action_query = $this->_getParam(urldecode('actionQuery'));
        switch($action_query){
            case 'next' : $curpageArticle = $this->_getParam(urldecode('paramPage'))+1; break;
            case 'prev' : $curpageArticle = $this->_getParam(urldecode('paramPage'))-1; break;
            default : $curpageArticle = $this->_getParam(urldecode('paramPage'))+1; break;
        }
        
        $num_linkArticle = NUM_LINKS;
        $per_pageArticle = $limit;
        
        $getTotalArticle = $generateArticle->numbRowsFigure($param,$this->_languageId);

        $num_pageArticle = ceil($getTotalArticle / $limit);
        $startArticle = (($curpageArticle - $num_linkArticle) > 0) ? $curpageArticle - ($num_linkArticle - 1) : 1;
        $endArticle   = (($curpageArticle + $num_linkArticle) < $num_pageArticle) ? $curpageArticle + $num_linkArticle : $num_pageArticle;
        
        $data['start']		= $startArticle;
        $data['end']		= $endArticle;
        $data['per_pages']	= $per_pageArticle;
        $data['cur_pages']	= $curpageArticle;
        $data['all_page']	= $getTotalArticle;
        

        /* - - - - - - - - - - - end link pages - - - - - - - -  - - - - -  - -*/
        
        $data['offset'] = $offset+$limit;
        $data['curpages'] = $curpageArticle;
        
        echo json_encode($data);
    }

    /*
        articlepagingAction : fungsi untuk menangani pagination content article
    */
    


    /*
        gallerypagingAction : fungsi untuk menangani pagination content article
    */
//    public function gallerypagingAction()
//    {
//        $this->_helper->layout->disableLayout(); /* disable layout */
//        $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
//        
//        $limit = $this->_getParam(urldecode('paramLimit'));
//        $offset = $this->_getParam(urldecode('paramOffset'));
//        $param = $this->_getParam(urldecode('paramKey'));
//
//        $searchGallery = new Model_DbTable_Image();
//        $getResultGallery = $searchGallery->searchGalleryBaru($param, $limit, $offset, $this->_languageId);
//        //$getResultGallery = $searchGallery->searchGallery($param, $limit, $offset, $this->_languageId);
//        
//        if(count($getResultGallery) > 0)
//        {
//
//            $data['result'] = '';
//            
//            foreach($getResultGallery as $rowGallery)
//            {
//                
//
//                switch($rowGallery['type']){
//                    case 0 : $path = $this->view->imageUrl('/upload/poi/');$type='poi/'; break;
//                    case 1 : $path = $this->view->imageUrl('/upload/poi/');$type='poi/'; break;
//                    case 2 : $path = $this->view->imageUrl('/upload/article/');$type='article/'; break;
//                    case 3 : $path = $this->view->imageUrl('/upload/tourismoperator/');$type='tourismoperator/'; break;
//                    case 4 : $path = $this->view->imageUrl('/upload/news/');$type='news/'; break;
//                }
//
//                $filter = $rowGallery['source'];
//                ////$filter = str_replace('%',' ',$rowGallery['source']);
//                if((strchr($filter,"/images/upload/")))
//                {
//                    $exp = explode("/",$filter);
//                
//                    $max = count($exp); //jumlah array
//                    
//                    for($i=0;$i<=$max;$i++){
//                        if($i == $max){             //ngambil array terakhir
//                            $src = $exp[($max - 1)]; //array terakhir = index max array - 1
//                        }
//                    }
//                
//                }else{
//                    $src = $rowGallery['source'];
//                }
//                
//                $name = str_replace('%',' ',$rowGallery['name']);
//                
//                if(file_exists(UPLOAD_FOLDER.$type.$src)){
//                    $data['result'] .= '<li class="li_image" style="display:inline;"><a title="'.$name.'" href="'.$path.$src.'" class="fancy-image">';
//                    $data['result'] .= '<img title="'.$name.'" class="img_search" src="'.$path.'thumbnails/'.$src.'" alt="" />';
//                    //$data['result'] .= '<img title="'.$name.'" class="img_search" id="'.$rowGallery->gallery_id.'" src="'.$path.'thumbnails/'.$src.'" alt="" />';
//                    $data['result'] .= '</a></li>';
//                }else{
//                    $data['result'] .= '<li class="li_image" style="display:inline;">';
//                    $data['result'] .= '<img src="'.$this->_request->getBaseUrl().'/media/images/default.jpg" alt="" />';
//                    $data['result'] .= '</li>';
//                }
//                
//            }
//            
//
//        }else{
//            $data['result'] = '<li><a href="#">no data that matches with keyword you enter : <b>'.$param.'</b></a></li>';
//        }
//
//        
//        ///* - - - - - - - - - - - link pages - - - - - - - - - -  - - - - -  - -*/
//        $action_query = $this->_getParam(urldecode('actionQuery'));
//        switch($action_query){
//            case 'next' : $curpageGallery = $this->_getParam(urldecode('paramPage'))+1; break;
//            case 'prev' : $curpageGallery = $this->_getParam(urldecode('paramPage'))-1; break;
//            default : $curpageGallery = $this->_getParam(urldecode('paramPage'))+1; break;
//        }
//        
//        $num_linkGallery = NUM_LINKS;
//        $per_pageGallery = $limit;
//
//         ////Calculate the start and end numbers. These determine
//         ////which number to start and end the digit links with
//        $getTotalGallery = $searchGallery->numbRowsGallery($param, $this->_languageId);
//
//        $num_pageGallery = ceil($getTotalGallery / $limit);
//        $startGallery = (($curpageGallery - $num_linkGallery) > 0) ? $curpageGallery - ($num_linkGallery - 1) : 1;
//        $endGallery   = (($curpageGallery + $num_linkGallery) < $num_pageGallery) ? $curpageGallery + $num_linkGallery : $num_pageGallery;
//        //
//        
//        $data['start']		= $startGallery;
//        $data['end']		= $endGallery;
//        $data['per_pages']	= $per_pageGallery;
//        $data['cur_pages']	= $curpageGallery;
//        $data['all_page']	= $getTotalGallery;
//
//        /* - - - - - - - - - - - end link pages - - - - - - - -  - - - - -  - -*/
//        
//        $data['offset'] = $offset+$limit;
//        $data['curpages'] = $curpageGallery;
//        
//        echo json_encode($data);
//    }
//
//
//
//    public function tourismpagingAction()
//    {
//        $this->_helper->layout->disableLayout(); /* disable layout */
//        $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
//        
//        $limit = $this->_getParam(urldecode('paramLimit'));
//        $offset = $this->_getParam(urldecode('paramOffset'));
//        $param = $this->_getParam(urldecode('paramKey'));
//
//        $searchTO = new Model_DbTable_TourismOperatorDescription();
//        $getResultTO = $searchTO->searchTourismBaru($param, $limit, $offset, $this->_languageId);
//        
//        if(count($getResultTO) > 0)
//        {
//            $data['result'] = '';
//
//            foreach($getResultTO as $rowTO)
//            {
//                $name = $this->view->boldStyle(strtolower($rowTO['name']),$param);
//                $data['result'] .= '<li>';
//                $data['result'] .= '<a href="'.$this->_request->getBaseUrl().'/'.$this->lang.'/tourismoperator/detailsingle/'.$rowTO['tourismoperator_id'].'" title="'.$rowTO['name'].'">'.ltrim($name).'</a>';
//                $data['result'] .= '<br /><br />'.substr((strip_tags($this->view->htmlDecode($rowTO['description']))),0,225).' ...';
//                $data['result'] .= '</li>';
//            }
//        }else{
//            $data['result'] = '<li><a href="#">no data that matches with keyword you enter : <b>'.$param.'</b></a></li>';
//        }
//
//        
//        /* - - - - - - - - - - - link pages - - - - - - - - - -  - - - - -  - -*/
//        $action_query = $this->_getParam(urldecode('actionQuery'));
//        switch($action_query){
//            case 'next' : $curpageTourism = $this->_getParam(urldecode('paramPage'))+1; break;
//            case 'prev' : $curpageTourism = $this->_getParam(urldecode('paramPage'))-1; break;
//            default : $curpageTourism = $this->_getParam(urldecode('paramPage'))+1; break;
//        }
//        
//        $num_linkTourism = NUM_LINKS;
//        $per_pageTourism = $limit;
//        
//        $getTotalArticle = $searchTO->numRowsTourism($param,$this->_languageId);
//
//        $num_pageArticle = ceil($getTotalArticle / $limit);
//        $startArticle = (($curpageTourism - $num_linkTourism) > 0) ? $curpageTourism - ($num_linkTourism - 1) : 1;
//        $endArticle   = (($curpageTourism + $num_linkTourism) < $num_pageArticle) ? $curpageTourism + $num_linkTourism : $num_pageArticle;
//        
//        $data['start']		= $startArticle;
//        $data['end']		= $endArticle;
//        $data['per_pages']	= $per_pageTourism;
//        $data['cur_pages']	= $curpageTourism;
//        $data['all_page']	= $getTotalArticle;
//
//        /* - - - - - - - - - - - end link pages - - - - - - - -  - - - - -  - -*/
//        
//        $data['offset'] = $offset+$limit;
//        $data['curpages'] = $curpageTourism;
//        
//        echo json_encode($data);
//    }


    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        $listTitle = $this->view->translate('id_search_page_google');
        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        switch ($this->_request->getActionName()) {
            case 'detail':
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => $this->view->baseUrl('search'),
                    $newsTitle => '',
                );
                $this->view->pageTitle = $newsTitle;
                break;
            case 'index':
            default:
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => '',
                );
                $this->view->pageTitle = $listTitle;
        }
        Zend_Registry::set('breadcrumb', $links);
    }

    public function to_bold($matches) {
        $this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        return "<b>{$matches[0]}</b>";
    }
}