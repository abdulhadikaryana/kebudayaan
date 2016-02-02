<?php
/**
 * DestinationController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - destination
 */
require_once 'Zend/Controller/Action.php';

class Admin_DestinationindoController extends Library_Controller_Backend
{
    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    public function init()
    {
        parent::init();
        $this->view->image_dir_type = 1;

        /*get google map key from zend registry and send it to the view*/
        $this->view->gkey = 'ABQIAAAA4l_aTvb-Ccy0LPmnmpLkQxRB93edaK5BFbO7xsagv6wBifXTbxSwGovo4GTJ46u0W13gusb05hq-RA';

	}

    /**
     * IS: Terdeklarasinya filter dan param di session, dan page_row
     * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, paginator,
     *     all_area, all_category, filter_alert
     * Desc: Mengatur aksi yang dilakukan untuk halaman index
     */
    public function indexAction()
    {
        //variable initiation and instance creation
        $this->view->cleanurl = $this->_cleanUrl;

        //get messages from CRUD process
        $message = $this->_flash->getMessages();
        if(!empty($message))
        {
            $this->view->message = $message;
        }

        //create table instances
        $table_destination = new Model_DbTable_Destination;
        $table_area = new Model_DbTable_Area;
        $table_category = new Model_DbTable_Category;

        //set variable initial value
        $filter = null;
        $new_search = FALSE;

        //get params for the filter
        if($this->getRequest()->isPost())
        {
            $filter = $_POST['filterPage'];
            $new_search = TRUE;
            $this->_paginator_sess->filterDestinationIndo = $filter;
            switch($filter)
            {
                case 0 : $param = null;
                case 1 : $param = $_POST['filterName'];
                    break;
                case 2 : $param = $_POST['filterArea'];
                    break;
                case 3 : $param = $_POST['filterCategory'];
                    break;
                case 4 : $param = $_POST['filterStatus'];
                    break;
                case 5 : $param = $_POST['filterSpecial'];
                    break;
            }
            $this->_paginator_sess->param = $param;
        }

        //set paginator for list of destination data
        $filter = $this->_paginator_sess->filterDestinationIndo;
        $param = $this->_paginator_sess->param;

        $select = $table_destination->getQueryAllByLang($filter,$param,2);

        //get pagerow setting and send to the paginator control
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;

        if($page_row != null)
        {
            $paginator = parent::setPaginator($select,$page_row);
        }
        else
        {
            $paginator = parent::setPaginator($select);
        }

        //if this is a new search then return the page number back to the 1st page
        if($new_search)
        {
            $paginator->setCurrentPageNumber(1);
        }

        //send data to the view
        $this->view->paginator = $paginator;
        $area_data = $table_area->getallAreaNameId(2);
        $this->view->all_area =	$area_data;
        $category_data = $table_category->getAllCategoryIdNameByLangId(2);
        $this->view->all_category = $category_data;

        /** Return alert to view on filter selected */
        switch ($filter)
        {
            case 0 : $filter_alert = "Show all destinations";
                break;
            case 1 : $filter_alert = "Destinations which name with keyword '"
                        . $param . "'";
                break;
            case 2 : foreach ($area_data as $area)
                {
                    $parent[$area['area_id']] = $area['name'];
                }
                $filter_alert = "Destinations that located at '"
                        . trim($parent[$param]) . "' area";
                break;
            case 3 : foreach ($category_data as $category)
                {
                    $parent[$category['category_id']] = $category['name'];
                }
                $filter_alert = "Destinations with '" . $parent[$param]
                        . "' category";
                break;
            case 4 : ($param == '1') ? $state = 'Published' : $state = 'Draft';
                $filter_alert = "Destinations with '" . $state . "' status";
                break;
            case 5 : ($param == '1') ? $state = 'Featured' : $state = 'Non Featured';
                $filter_alert = "Destinations that are '" . $state . "'";
                break;
        }
        $this->view->alert = $filter_alert;
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form, gkey
     * Desc: Mengatur aksi yang dilakukan untuk halaman create
     */
    public function createAction()
    {
        //Creating instances: form, table
        $language_id = 2;
        $form = new Admin_Form_PoiFormIndo;
        $table_destination = new Model_DbTable_Destination;
        $table_destination_description = new Model_DbTable_DestinationDescription;
        $table_categorytopoi = new Model_DbTable_CategoryToPoi;
        $table_areatopoi = new Model_DbTable_AreaToPoi;
        $table_relatedpoi = new Model_DbTable_RelatedPoi;
        $table_related_article_poi = new Model_DbTable_RelatedArticlePoi();

        //if this is a post request
        if($this->getRequest()->isPost())
        {
            //if the post is valid
            if($form->isValid($_POST))
            {
                //check if it is a special destination or not
                if($_POST['SpecialDestination'] == 1)
                {
                    //if it was a special destination but no image uploaded
                    if($_POST['HeaderImage']=='')
                    {
                        $this->_flash->addMessage('3\Warning: Data is saved without image! You should upload an image for a featured destination.');
                    }
                    //if theres an image uploaded
                    else
                    {
                        $header_image =  preg_replace( "/'/", "&#39;", $_POST['HeaderImage']);
                    }
                }
                else
                {
                    $header_image = null;
                }

                $PoiName = preg_replace( "/'/", "&#39;", $_POST['PoiName']);
                $PoiAddress = preg_replace( "/'/", "&#39;", $_POST['PoiAddress']);
                $PoiPhone = preg_replace( "/'/", "&#39;", $_POST['PoiPhone']);
                $PoiWebsite = preg_replace( "/'/", "&#39;", $_POST['PoiWebsite']);

                /*preparing data for Poi table*/
                $data = array(
                        'pointX' => $_POST['pointx'],
                        'pointY' => $_POST['pointy'],
                        'address' => $PoiAddress,
                        'phone' => $PoiPhone,
                        'website' => $PoiWebsite,
                        'main_category' => $_POST['MainCategory'],
                        'popular' => $_POST['PopularSelect'],
                        'status' => $_POST['SaveStatus'],
                        'special' => $_POST['SpecialDestination'],
                        'header_image' => ' ',
                );

                /*inserting data to Poi table and get the last inserted poi id*/
                $Poi_id = $table_destination->insertPoi($data);

                /*preparing data for poi description table*/
                if(!empty($Poi_id)) /*if the key is not empty then we assume that the insert process is succed, then we insert the complementary data*/
                {
                    //preparing for description
                    $PoiTagLine = preg_replace( "/'/", "&#39;", $_POST['PoiTagline']);
                    $PoiInformation = preg_replace( "/'/", "&#39;", $_POST['PoiInformation']);
                    $PoiHowToGetThere = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetThere']);
                    $PoiHowToGetAround = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetAround']);
                    $PoiWhatToDo = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToDo']);
                    $PoiWhereToEat = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToEat']);
                    $PoiWhereToStay = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToStay']);
                    $PoiWhatToBuy = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToBuy']);
                    $PoiTips = preg_replace( "/'/", "&#39;", $_POST['PoiTips']);

                    $desc = array(
                            'poi_id' => $Poi_id,
                            'name' => $PoiName,
                            'language_id' => 2,
                            'tagline' => $PoiTagLine,
                            'description' => $PoiInformation,
                            'howToGetThere' => $PoiHowToGetThere,
                            'howToGetAround' => $PoiHowToGetAround,
                            'whatToDo' => $PoiWhatToDo,
                            'whereToEat' => $PoiWhereToEat,
                            'whereToStay' => $PoiWhereToStay,
                            'whatToBuy' => $PoiWhatToBuy,
                            'tips' => $PoiTips,
                            'header_image' => $header_image,
                    );
                    //insert to the database
                    $Poi_descid = $table_destination_description->insertPoiDescription($desc);


                    /*preparing data for categorytopoi table
                   *Get category count and data*/
                    $category_count = $this->_getParam('MaxCategory');
                    $category_stack = array();
                    for($i=0;$i<=$category_count;$i++)
                    {
                        if(!empty($_POST['catValue'.$i]))
                        {
                            array_push($category_stack,$_POST['catValue'.$i]);
                        }
                    }

                    /*inserting data for categorytopoi table*/
                    foreach ($category_stack as $cat_id)
                    {
                        $category_poi = array(
                                'category_id' => $cat_id,
                                'poi_id'  => $Poi_id,
                        );
                        $table_categorytopoi->insertCategoryToPoi($category_poi,2);
                    }

                    /*Preparing area data for table insert
                   *Get area count and data*/
                    $area_count = $this->_getParam('MaxArea');
                    $area_stack = array();
                    for($i=0;$i<=$area_count;$i++)
                    {
                        if(!empty($_POST['areaValue'.$i]))
                        {
                            array_push($area_stack,$_POST['areaValue'.$i]);
                        }
                    }

                    /*inserting to areatopoi table*/
                    foreach($area_stack as $area_id)
                    {
                        $area_poi = array(
                                'area_id' => $area_id,
                                'poi_id' => $Poi_id,
                        );
                        $table_areatopoi->insertAreaToPoi($area_poi);
                    }

                    /*processing related poi data*/
                    $relCtr = $_POST['relPoi_counter'];
                    for($i=0;$i<=$relCtr;$i++)
                    {
                        if(!empty($_POST['relpoi'.$i]))
                        {
                            $data = array(
                                    'poi_id' => $Poi_id,
                                    'related_poi' => $_POST['relpoi'.$i]
                            );
                            $table_relatedpoi->insertRelatedPoi($data);
                        }
                    }


                    /* inserting to related_article_poi */
                    //counter related article poi
                    $counter = $_POST['counterRelated'];
        
                    for($i=1;$i<=$counter;$i++)
                    {
                        if(!empty($_POST['label'.$i]) AND !empty($_POST['link'.$i]))
                        {
                            $data = array('poi_id'=>$Poi_id,
                                          'label'=>$_POST['label'.$i],
                                          'link'=>$_POST['link'.$i],
										  'language_id'=>2
                                          );
                            //insert into table
                            $table_related_article_poi->insertRelated($data);
                        }
                    }


                    /*send a success message via flashmessenger*/
                    $this->loggingaction('destination', 'create', $Poi_id, $language_id);
                    $this->_flash->addMessage('1\Destination Insert Success!');
                } else
                {
                    /*send a failed message via flashmessenger*/
                    $this->_flash->addMessage('2\Destination Insert Failed!');
                }
                /*redirect to the destination list page*/
                $this->_redirect($this->view->rootUrl('/admin/destinationindo/'));

            }
        }
        /*send form to the view*/
        $this->view->form = $form;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: poi_id, form, gkey, header_image
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
         /*retrieving parameter and creating form*/
        $poi_id = $this->_getParam('id');
        $language_id = $this->_getParam('lang');
        //create instance of destination table and get destination data
        $table_destination = new Model_DbTable_Destination;
        $table_destination_description = new Model_DbTable_DestinationDescription;
        $table_category = new Model_DbTable_Category;
        $table_categorytopoi = new Model_DbTable_CategoryToPoi;
        $table_area = new Model_DbTable_Area;
        $table_areatopoi = new Model_DbTable_AreaToPoi;
        $table_relatedpoi = new Model_DbTable_RelatedPoi;
        $data = null;
        $form = new Admin_Form_PoiFormIndo;


        $table_related_article_poi = new Model_DbTable_RelatedArticlePoi();

        //get realated article data
        // @param =  article_id
        $ralated_poi = $table_related_article_poi->getByPoiId($poi_id,$language_id);
        $this->view->edit = 1;
        $this->view->ralated_poi = $ralated_poi;
        $this->view->poi_id = $poi_id;

        /*Update Process*/
        if($this->getRequest()->isPost())
        {
            //if the form is valid
            if($form->isValid($_POST))
            {
                //check if it is a special destination or not
                if($language_id!=2)
                {
                    $indo = $table_destination_description->checkForEnglish($poi_id);
                    if(!$indo)
                    {
                        if($_POST['SpecialDestination'] == 1)
                        {
                                $header_image =  preg_replace( "/'/", "&#39;", $_POST['HeaderImage']);
                        }
                        else
                        {
                            $header_image = null;
                        }
                        $PoiName = preg_replace( "/'/", "&#39;", $_POST['PoiName']);
                        $PoiTagLine = preg_replace( "/'/", "&#39;", $_POST['PoiTagline']);
                        $PoiInformation = preg_replace( "/'/", "&#39;", $_POST['PoiInformation']);
                        $PoiHowToGetThere = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetThere']);
                        $PoiHowToGetAround = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetAround']);
                        $PoiWhatToDo = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToDo']);
                        $PoiWhereToEat = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToEat']);
                        $PoiWhereToStay = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToStay']);
                        $PoiWhatToBuy = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToBuy']);
                        $PoiTips = preg_replace( "/'/", "&#39;", $_POST['PoiTips']);
                        $desc = array(
                                'poi_id' => $poi_id,
                                'language_id' => $language_id,
                                'name' => $PoiName,
                                'tagline' => $PoiTagLine,
                                'description' => $PoiInformation,
                                'howToGetThere' => $PoiHowToGetThere,
                                'howToGetAround' => $PoiHowToGetAround,
                                'whatToDo' => $PoiWhatToDo,
                                'whereToEat' => $PoiWhereToEat,
                                'whereToStay' => $PoiWhereToStay,
                                'whatToBuy' => $PoiWhatToBuy,
                                'tips' => $PoiTips,
                                'header_image' => $header_image,
                        );

                        //updating data to the database
                        $table_destination_description->insertPoiDescription($desc);
                    }else
                    {
                        if($_POST['SpecialDestination'] == 1)
                        {
                                $header_image =  preg_replace( "/'/", "&#39;", $_POST['HeaderImage']);
                        }
                        else
                        {
                            $header_image = null;
                        }
                        $PoiName = preg_replace( "/'/", "&#39;", $_POST['PoiName']);
                        $PoiTagLine = preg_replace( "/'/", "&#39;", $_POST['PoiTagline']);
                        $PoiInformation = preg_replace( "/'/", "&#39;", $_POST['PoiInformation']);
                        $PoiHowToGetThere = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetThere']);
                        $PoiHowToGetAround = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetAround']);
                        $PoiWhatToDo = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToDo']);
                        $PoiWhereToEat = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToEat']);
                        $PoiWhereToStay = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToStay']);
                        $PoiWhatToBuy = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToBuy']);
                        $PoiTips = preg_replace( "/'/", "&#39;", $_POST['PoiTips']);
                        $desc = array(
                                'poi_id' => $poi_id,
                                'language_id' => 1,
                                'name' => $PoiName,
                                'tagline' => $PoiTagLine,
                                'description' => $PoiInformation,
                                'howToGetThere' => $PoiHowToGetThere,
                                'howToGetAround' => $PoiHowToGetAround,
                                'whatToDo' => $PoiWhatToDo,
                                'whereToEat' => $PoiWhereToEat,
                                'whereToStay' => $PoiWhereToStay,
                                'whatToBuy' => $PoiWhatToBuy,
                                'tips' => $PoiTips,
                                'header_image' => $header_image,
                        );

                        //updating data to the database
                        $table_destination_description->UpdatePoiDescription($desc,$poi_id,1);
                    }
                }else
                {
                    if($_POST['SpecialDestination'] == 1)
                    {
                        //if it was a special destination but no image uploaded
                        if($_POST['HeaderImage']=='')
                        {
                            $this->_flash->addMessage('3\Warning: Data is saved without image! You should upload an image for a featured destination.');
                        }
                        //if theres an image uploaded
                        else
                        {
                            $header_image =  preg_replace( "/'/", "&#39;", $_POST['HeaderImage']);
                        }
                    }
                    else
                    {
                        $header_image = null;
                    }

                    $PoiName = preg_replace( "/'/", "&#39;", $_POST['PoiName']);
                    $PoiAddress = preg_replace( "/'/", "&#39;", $_POST['PoiAddress']);
                    $PoiPhone = preg_replace( "/'/", "&#39;", $_POST['PoiPhone']);
                    $PoiWebsite = preg_replace( "/'/", "&#39;", $_POST['PoiWebsite']);
                    if($_POST['SpecialDestination'] == 0)
                    {
                        $SpecialDestination = 0;
                    } else
                    {
                        $SpecialDestination = 1;
                    }

                    /*preparing data for Poi table*/
                    $data = array(
                            'pointX' => $_POST['pointx'],
                            'pointY' => $_POST['pointy'],
                            'address' => $PoiAddress,
                            'phone' => $PoiPhone,
                            'website' => $PoiWebsite,
                            'main_category' => $_POST['MainCategory'],
                            'popular' => $_POST['PopularSelect'],
                            'status' => $_POST['SaveStatus'],
                            'special' => $SpecialDestination,
                            'header_image' => ' ',
                    );
                    /*updating data to Poi table and get the last inserted poi id*/
                    $table_destination->updatePoi($data,$poi_id);

                    /*preparing data for poi description table*/
                    $PoiTagLine = preg_replace( "/'/", "&#39;", $_POST['PoiTagline']);
                    $PoiInformation = preg_replace( "/'/", "&#39;", $_POST['PoiInformation']);
                    $PoiHowToGetThere = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetThere']);
                    $PoiHowToGetAround = preg_replace( "/'/", "&#39;", $_POST['PoiHowToGetAround']);
                    $PoiWhatToDo = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToDo']);
                    $PoiWhereToEat = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToEat']);
                    $PoiWhereToStay = preg_replace( "/'/", "&#39;", $_POST['PoiWhereToStay']);
                    $PoiWhatToBuy = preg_replace( "/'/", "&#39;", $_POST['PoiWhatToBuy']);
                    $PoiTips = preg_replace( "/'/", "&#39;", $_POST['PoiTips']);
                    $desc = array(
                            'poi_id' => $poi_id,
                            'language_id' => 2,
                            'name' => $PoiName,
                            'tagline' => $PoiTagLine,
                            'description' => $PoiInformation,
                            'howToGetThere' => $PoiHowToGetThere,
                            'howToGetAround' => $PoiHowToGetAround,
                            'whatToDo' => $PoiWhatToDo,
                            'whereToEat' => $PoiWhereToEat,
                            'whereToStay' => $PoiWhereToStay,
                            'whatToBuy' => $PoiWhatToBuy,
                            'tips' => $PoiTips,
                            'header_image' => $header_image,
                    );

                    //updating data to the database
                    $table_destination_description->UpdatePoiDescription($desc,$poi_id,2);

                    /*preparing data for categorytopoi table
               *Get category count and data*/
                    $category_count = $this->_getParam('MaxCategory');
                    $category_stack = array();
                    for($i=0;$i<=$category_count;$i++)
                    {
                        if(!empty($_POST['catValue'.$i]))
                        {
                            array_push($category_stack,$_POST['catValue'.$i]);
                        }
                    }

                    /*inserting data for categorytopoi table*/
                    $category_list = $table_categorytopoi->getCategoryIdByPoiId($poi_id);
                    /*convert to non associative array*/
                    $saved_category = array();
                    foreach($category_list as $temp_cat)
                    {
                        array_push($saved_category,$temp_cat['category_id']);
                    }

                    /*processing the data
               if the posted data not found on saved category id list then insert the data */
                    foreach($category_stack as $category_new)
                    {
                        if(!in_array($category_new,$saved_category))
                        {
                            $category_poi = array(
                                    'category_id' => $category_new,
                                    'poi_id'  => $poi_id,
                            );
                            $table_categorytopoi->insertCategoryToPoi($category_poi,2);
                        }
                    }

                    /*complement check, if the data on saved category list not found on posted category
               then delete that data on the database*/
                    foreach($saved_category as $old_category)
                    {
                        if(!in_array($old_category,$category_stack))
                        {
                            $table_categorytopoi->deleteCategoryToPoi($old_category,$poi_id);
                        }
                    }

                    /* We do it the same way for processing the area data
               * First, we obtain the data from the database and then convert it
               * to a non assoc. array*/
                    $areatopoi_list = $table_areatopoi->getPoiAreaId($poi_id);
                    $saved_area = array();
                    foreach($areatopoi_list as $temp_area)
                    {
                        array_push($saved_area,$temp_area['area_id']);
                    }

                    /* Obtain the list of the new area data posted from the form*/
                    $area_count = $this->_getParam('MaxArea');
                    $area_stack = array();
                    for($i=0;$i<=$area_count;$i++)
                    {
                        if(!empty($_POST['areaValue'.$i]))
                        {
                            array_push($area_stack,$_POST['areaValue'.$i]);
                        }
                    }

                    /* Compare the new area list with the old area list
               		 *  if its not in the old area list then insert to the database*/
                    foreach($area_stack as $new_area)
                    {
                        if(!in_array($new_area,$saved_area))
                        {
                            $area_poi = array(
                                    'area_id' => $new_area,
                                    'poi_id' => $poi_id,
                            );
                            $table_areatopoi->insertAreaToPoi($area_poi);
                        }
                    }

                    /* Now we do the complement action
	                 * compare the old list with the new list,
	                 * delete if not found on the new list*/
                    foreach($saved_area as $old_area)
                    {
                        if(!in_array($old_area,$area_stack))
                        {
                            $table_areatopoi->deleteAreaToPoi($old_area,$poi_id);
                        }
                    }

                    /*related poi data processing*/
                    $relpoi_stack = array();
                    $relCtr = $_POST['relPoi_counter'];
                    for($i=0;$i<=$relCtr;$i++)
                    {
                        if(!empty($_POST['relpoi'.$i]))
                        {
                            array_push($relpoi_stack,$_POST['relpoi'.$i]);
                        }
                    }

                    $saved_relpoi = $table_relatedpoi->getAllRelatedByPoiIdLangId($poi_id, $language_id);
                    $old_relpoi = array();
                    
                    if(sizeof($saved_relpoi)>0)
                    {
                        foreach($saved_relpoi as $value)
                        {
                            array_push($old_relpoi,$value['related_poi']);
                        }
                    }

                    foreach($relpoi_stack as $value)
                    {
                        if(!in_array($value,$old_relpoi))
                        {
                            $data = array(
                                    'poi_id' => $poi_id,
                                    'related_poi' => $value,
                            );
                            $table_relatedpoi->insertRelatedPoi($data);
						}
                    }

                    foreach($old_relpoi as $value)
                    {
                        if(!in_array($value,$relpoi_stack))
                        {
                            $table_relatedpoi->deleteSpecificRelatedPoi($poi_id,$value);
                        }
                    }
                }

                ////$this->_helper->layout()->disableLayout();
                ////$this->_helper->viewRenderer->setNoRender(true);                

                /* update related article */
                //param
                // this part add related
                if($_POST['counterRelated'] > 0)
                {
                    $counter = $_POST['counterRelated'];
                    for($i=1;$i<=$counter;$i++)
                    {
                        //echo $_POST['link'.$i];
                        //cek existing label and link in database
                        // if $cek having value = false, then data will be saved
                        if(isset($_POST['label'.$i]))
                        {
                            $cek = $table_related_article_poi->cek_existing($_POST['label'.$i],$_POST['link'.$i]);
                            if(!$cek OR $cek == false)
                            {
                                $data = array('poi_id'=>$poi_id,
                                              'label'=>$_POST['label'.$i],
                                              'link'=>$_POST['link'.$i],
											  'language_id'=>$language_id
                                              );
                                $table_related_article_poi->insertRelated($data);
                            }
                        }
                    }                    
                }

                //bagian untuk menghapus data related artikel
                if($_POST['counterDel'] > 0)
                {
                    $counterDel = $_POST['counterDel'];

                    for($i=1;$i<=$counterDel;$i++)
                    {
                        //cek existing label and link in database
                        // if found, data will be removed
                        if(isset($_POST['labeldel'.$i]))
                        {
                           $cek = $table_related_article_poi->cek_existing_forDel($_POST['labeldel'.$i],$_POST['linkdel'.$i]);
                        }
   
                    }
                }


                //Send a success message via flashmessenger
                $this->loggingaction('destination', 'edit', $poi_id, $language_id);
                $this->_flash->addMessage('1\Destination English Update Success!');
                //redirect to the destination list page
                $this->_redirect($this->view->rootUrl('/admin/destinationindo/'));
            }
        }

        /*load data from the database preparing for view process*/
        if($language_id==2)
        {
            $data = $table_destination->getAllByIdLangForIndo($poi_id,$language_id);
            $parent_category = $table_category->getparentCategoryId($data['main_category']);
            $parent_area = $table_areatopoi->getPoiAreaId($poi_id);
        }else
        {
            $indo = $table_destination_description->checkForEnglish($poi_id);
            if($indo)
            {
                $data = $table_destination->getAllByIdLangForIndo($poi_id,$language_id);
            }
        }
        $tesheader = $table_destination_description->getheaderimagebyid2($poi_id,$language_id);
        /*Set every element Value*/
        if($data != null)
        {
        $form->Poi_Name->setValue($this->view->HtmlDecode($data['name']));
        $form->Popular_Select->setValue($this->view->HtmlDecode($data['popular']));
        $form->Poi_Address->setValue($this->view->HtmlDecode(strip_tags($data['address'])));
        $form->Poi_Website->setValue($data['website']);
        $form->Poi_Phone->setValue($data['phone']);
        $form->Poi_TagLine->setValue($this->view->HtmlDecode($data['tagline']));
        $form->Poi_Information->setValue($this->view->HtmlDecode($data['description']));
        $form->Poi_HowToGetThere->setValue($this->view->HtmlDecode($data['howToGetThere']));
        $form->Poi_HowToGetAround->setValue($this->view->HtmlDecode($data['howToGetAround']));
        $form->Poi_WhatToDo->setValue($this->view->HtmlDecode($data['whatToDo']));
        $form->Poi_WhereToEat->setValue($this->view->HtmlDecode($data['whereToEat']));
        $form->Poi_WhereToStay->setValue($this->view->HtmlDecode($data['whereToStay']));
        $form->Poi_WhatToBuy->setValue($this->view->HtmlDecode($data['whatToBuy']));
        $form->Poi_Tips->setValue($this->view->HtmlDecode($data['tips']));
        $form->Poi_x->setValue($data['pointX']);
        $form->Poi_y->setValue($data['pointY']);
        $form->HeaderImage->setValue($tesheader['header_image']);
        }

        /*check if this is a special destination, if it is, then checkbox value to true*/
        if($table_destination->checkSpecialDestination($poi_id))
        {
            $form->SpecialDestination->setChecked(true);
            $this->view->state_special=TRUE;
        }
        else
        {
            $form->SpecialDestination->setChecked(false);
            $this->view->state_special=FALSE;
        }

        /*send data image filename to the view*/
        $this->view->header_image = $data['header_image'];

        /*set another value to the form element*/
        $area_amount = $table_areatopoi->countAreaByPoiId($poi_id);
        $category_amount = $table_categorytopoi->countCategoryByPoiId($poi_id);
        $main_category = $table_destination->getMainCategoryById($poi_id);
        $form->Category_counter->setValue($category_amount);
        $form->Count_category->setValue($category_amount);
        $form->Main_category->setValue($main_category['main_category']);
        $form->Area_counter->setValue($area_amount);
        $form->Count_area->setValue($area_amount);

        /*send form to view class*/
        $this->view->poi_id = $poi_id;
        $this->view->form = $form;
        $this->view->language_id = $language_id;
        /*get google map key from zend registry and send it to the view*/
    }

    /**
     * IS: Nama file terdeklarasi
     * FS: File extention terdeklarasi
     * Desc: Mengembalikan file extention untuk berkas gambar
     */
    protected function get_file_extension($file_name)
    {
        return substr(strrchr($file_name,'.'),1);
    }

    /**
     * IS: -
     * FS: -
     * Desc: Mengembalikan file-file dari direktori tertentu
     */
    protected function get_files($images_dir,$exts = array('jpg','jpeg','png','gif'))
    {
        $files = array();
        if($handle = opendir($images_dir))
        {
            while(false !== ($file = readdir($handle)))
            {
                $extension = strtolower($this->get_file_extension($file));
                if($extension && in_array($extension,$exts))
                {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        return $files;
    }

    /**
     * IS: Parameter page terdeklarasi
     * FS: Mengirimkan ke viewer: image_files, page
     * Desc: Mengatur aksi yang dilakukan untuk image browser
     */
    public function imagebrowserAction()
    {
        $page = $this->_getParam('page');
        if(!isset($page))
        {
            $page = 0;
        }
        $limit = 20;
        $this->_helper->layout()->disableLayout();
        $images_dir = UPLOAD_FOLDER.'poi/';
        $thumbs_width = 200;
        $images_per_row = 3;
        $image_files = $this->get_files($images_dir);
        $this->view->image_files = $image_files;
        $this->view->page = $page;
    }

}