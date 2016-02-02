<?php

class Model_Usergeneratedcontent {

    /**
     * Constructor
     */
    function __Construct()
    {
    }

    public function saveUserStory($contributor_id,$date,$type)
    {
        //save user story
        $userStory = new Model_DbTable_UserStory();
        $userStory->insertStory($contributor_id,$date,$approved = 1,$type);        
        
        //get last id from user story table
        $lastId = $userStory->getLastID($contributor_id);
        $id = $lastId['id'];
        
        return $id;
        
    }
    
    //fungsi untuk save user story tag
    public function saveTag($userstory_id,$tagEvent,$tagDest,$lang_id)
    {
        if(count($tagEvent))
        {
            $saveTagEvent = new Model_DbTable_UserStoryTag();
            foreach($tagEvent as $key=>$value)
            {
                $saveTagEvent->insertStoryTags($userstory_id,$value,'event',$lang_id);
            }
        }

        //save tag destination
        if(count($tagDest)){
            $saveTagDest = new Model_DbTable_UserStoryTag();
            foreach($tagDest as $key=>$value)
            {
                $saveTagDest->insertStoryTags($userstory_id,$value,'destination',$lang_id);
            }
        }
    }
    
    //fungsi untuk save user story category
    public function saveCategory($userstory_id,$category,$lang_id)
    {
        if(count($category))
        {
            $saveCategory = new Model_DbTable_UserStoryRelated();
            foreach($category as $key=>$value)
            {
                $saveCategory->insertRealatedStory($userstory_id,$value,$lang_id);
            }
            
        }        
    }

    //save user story content
    public function saveStoryContent($userstory_id,$title,$content,$lang_id)
    {
        
        //model db
        $userStoryContent = new Model_DbTable_UserStoryContent();
        $userStoryContent->insertStoryContent($userstory_id,$title,$content,$lang_id,$userstory_id);
        
        //create text lang, untuk memberitahukan content yg bahasa mana saja yg di save
        $db_lang = new Model_DbTable_Language;
        $lang_text = $db_lang->getNameById($lang_id);
        
        return $lang_text['language_text'];

    }
    
    /*
        fungsi untuk mendapatkan list language    
    */
    public function getLang()
    {
        $getLang = new Model_DbTable_Language();
        $lang = $getLang->getAllLang();
        
        return $lang;
    }
    
    public function getContent($userstory_id,$approved)
    {
        $userStory = new Model_DbTable_UserStory();
        $content = $userStory->selectAllDataFix($userstory_id,$approved);
        
        return $content;
    }
    
    /*
        fungsi untuk mendapatkan detail user story berdasarkan id    
    */
    public function detailContent($userStoryId)
    {
        $detail = new Model_DbTable_UserStory();
        $userStoryDetail = $detail->getById($userStoryId);
        return $userStoryDetail;
    }

    /*
        fungsi untuk mendapatkan detail tags user story berdasarkan userstory_id    
    */
    public function detailTags($userStoryId,$lang_id,$url)
    {
        $userStoryTag = new Model_DbTable_UserStoryTag();
        $detailTags = $userStoryTag->getTag($userStoryId,$lang_id);

        $event = new Model_DbTable_EventDesc();
        $destination = new Model_DbTable_DestinationDescription();
        $article = new Model_DbTable_ArticleDescription();
        
        $listTags = '';
        if(count($detailTags) > 0)
        {
            $a = 1;
            foreach($detailTags as $tags)
            {
                
                if($tags->object_type == 'event')
                {
                    $getEvent = $event->getEvenName($tags->object_id,$lang_id);
                    if($a == 1) //jika kata pertama, tidak pakai koma di depannya
                    {
                        $listTags .= '<a href="'.$url.'/travelers-stories/indextags/tags/'.$tags->object_id.'/type/'.$tags->object_type.'">'.$getEvent['name'].'</a>';
                    }else{
                        $listTags .= ', <a href="'.$url.'/travelers-stories/indextags/tags/'.$tags->object_id.'/type/'.$tags->object_type.'">'.$getEvent['name'].'</a>';
                    }
                }
                else if($tags->object_type == 'destination')
                {
                    $getDest = $destination->getDestName($tags->object_id,$lang_id);
                    if($a == 1) //jika kata pertama, tidak pakai koma di depannya
                    {
                        $listTags .= '<a href="'.$url.'/travelers-stories/indextags/tags/'.$tags->object_id.'/type/'.$tags->object_type.'">'.$getDest['name'].'</a>';
                    }else{
                        $listTags .= ', <a href="'.$url.'/travelers-stories/indextags/tags/'.$tags->object_id.'/type/'.$tags->object_type.'">'.$getDest['name'].'</a>';
                    }
                }
                else
                {
                    $getArticle = $article->getArticleName($tags->object_id,$lang_id);

                    if($a == 1) //jika kata pertama, tidak pakai koma di depannya
                    {
                        $listTags .= '<a href="'.$url.'/travelers-stories/indextags/tags/'.$tags->object_id.'/type/'.$tags->object_type.'">'.$getArticle['title'].'</a>';
                    }else{
                        $listTags .= ', <a href="'.$url.'/travelers-stories/indextags/tags/'.$tags->object_id.'/type/'.$tags->object_type.'">'.$getArticle['title'].'</a>';
                    }

    
                }
                $a++;
            }            
        }else
        {
            $listTags = '-';
        }
       
        
        return $listTags;
    }

    public function tagLinkUsercontributorDetail($userStoryId,$lang_id,$url)
    {
        $userStoryTag = new Model_DbTable_UserStoryTag();
        $detailTags = $userStoryTag->getTag($userStoryId,$lang_id);

        $event = new Model_DbTable_EventDesc();
        $destination = new Model_DbTable_DestinationDescription();
        $article = new Model_DbTable_ArticleDescription();


        
        $related = '<ul>';
        //
        if(count($detailTags) > 0)
        {

            //$related = count($detailTags);

            foreach($detailTags as $tags)
            {
                
                if($tags->object_type == 'event')
                {
                    $getEvent = $event->getEvenName($tags->object_id,$lang_id);
                    $related .= '<li><a target="_blank" href="'.$url.'/event/detail/'.$tags->object_id.'/'.$getEvent['name'].'">'.$getEvent['name'].'</a></li>';
                }
                else if($tags->object_type == 'destination')
                {
                    $getDest = $destination->getDestName($tags->object_id,$lang_id);
                    $related .= '<li><a target="_blank" href="'.$url.'/destination/'.$tags->object_id.'/'.$getDest['name'].'">'.$getDest['name'].'</a></li>';
                }

                else
                {
                    $getArticle = $article->getArticleName($tags->object_id,$lang_id);

                    if(!empty($getArticle['poi_id']))
                    {
                        $Dest = $destination->getDestName($getArticle['poi_id'],$lang_id);
                        $related .= '<li><a target="_blank" href="'.$url.'/destination/'.$getArticle['poi_id'].'/'.$Dest['name'].'/article/'.$tags->object_id.'/'.$getArticle['title'].'">'.$getArticle['title'].'</a></li>';
                    }
                }
            }            
            $related .= '</ul>';

            return $related;

        }else
        {
        
//            $related .= '<li> - </li>';
//            $related .= '</ul>';
            return false;
        }
    }


    /*
        fungsi untuk mendapatkan detail category user story berdasarkan userstory_id    
    */
    public function detailCategory($userStoryId,$lang_id,$url,$content_category)
    {
        $userStoryRelated = new Model_DbTable_UserStoryRelated();
        $related_id = $userStoryRelated->getByUserStoryId($userStoryId,$lang_id);
        
        $category = '';

        $queryCategory = new Model_DbTable_UserStoryCategory();
        
        if(sizeof($related_id))
        {
            $a = 1;
            foreach($related_id as $category_id)
            {
                
                $get_category = $queryCategory->getById($category_id->userstorycategory_id)->toArray();
                
                if($a == 1)
                {
                    //$category .= '<li><a href="'.$url.'/usercontributor/indexcategory/id/'.$get_category['id'].'/category/'.$get_category['title'].'/type/'.$content_category.'">'.$get_category['title'].'</a></li>';
                    $category .= '<a class="float-left" href="'.$url.'/travelers-stories/indexcategory/id/'.$get_category['id'].'/category/'.$get_category['title'].'/type/'.$content_category.'">'.$get_category['title'].'</a>';

                }
                else
                {
                    //$category .= '<li><a href="'.$url.'/usercontributor/indexcategory/id/'.$get_category['id'].'/category/'.$get_category['title'].'/type/'.$content_category.'"> - '.$get_category['title'].'</a></li>';
                   $category .= '<a class="float-left" href="'.$url.'/travelers-stories/indexcategory/id/'.$get_category['id'].'/category/'.$get_category['title'].'/type/'.$content_category.'"> - '.$get_category['title'].'</a>';
                }
                $a++;
                
            }
        }
        else
        {
            $category = '-';
        }
        
        return $category;

    }
    
    public function detailUser($usercontrib_id)
    {
        $get_user = new Model_DbTable_UserStoryContributor();
        $user = $get_user->getById($usercontrib_id);
        
        return $user;
    }
    
    /*
        fungsi untuk memfilter content yang sudah di approve berdasarkan bahasa
    */
    public function filterByLang($userstory_id,$approved,$lang_id){
        $filterByLang = new Model_DbTable_UserStory();
        $result = $filterByLang->getByLang($userstory_id,$approved,$lang_id);
        
        return $result;
    }

    /*
        fungsi untuk memfilter content yang sudah di approve berdasarkan keyword yang dimasukan
    */
    public function filterByKeyword($userstory_id,$approved,$keyword){
        $filterByLang = new Model_DbTable_UserStory();
        $result = $filterByLang->getByKeyword($userstory_id,$approved,$keyword);
        
        return $result;
    }
    
    /*
        Fungsi untuk menampilkan archive berdasarkan user contributor id
    */
    public function archive($usercontrib_id,$date,$filter_id,$limit,$offset)
    {
        $dbArcive = new Model_DbTable_UserStory();
        
        if($filter_id == 1) //filter berdasarkan tahun
        {
            $archives = $dbArcive->filterYear($usercontrib_id,$date,$limit,$offset);
        }
        else //filter berdasarkan bulan
        {
            $archives = $dbArcive->filterMonth($usercontrib_id,$date,$limit,$offset);
        }
        
        return $archives;
    }

    /*
        Fungsi untuk menampilkan total data archive 
    */
    public function totalArchive($usercontrib_id,$date,$filter_id,$limit,$offset)
    {
        $dbArcive = new Model_DbTable_UserStory();
        
        if($filter_id == 1) //filter berdasarkan tahun
        {
            $archives = $dbArcive->filterYear($usercontrib_id,$date,$limit,$offset);
        }
        else //filter berdasarkan bulan
        {
            $archives = $dbArcive->filterMonth($usercontrib_id,$date,$limit,$offset);
        }
        
        return count($archives);
    }
    
    
    /*
        Fungsi untuk mendapatkan category sebuah content
        dgn parameter user story id
    */
    public function getCategory($userstory_id,$lang_id)
    {
        $get_relasi = new Model_DbTable_UserStoryRelated();
        $relasi = $get_relasi->getByUserStoryId($userstory_id,$lang_id);
        
        $dbCategory = new Model_DbTable_UserStoryCategory();
        
        $category = '';
        $array = array();
        if(count($relasi) > 0)
        {
            foreach($relasi as $category_id)
            {
                $result_category = $dbCategory->paramID($category_id->userstorycategory_id);
                $category .= '<span class="category '.$category_id->id.'" title="click to remove" id="'.$result_category['id'].'">'.$result_category['title'].'</span>';
    
                //isi elemen array dgn userstorycategory_id
                $array[] = $category_id->userstorycategory_id;
    
            }
        }

        /* convert $arrayCategory */
        $arrayCategory = '';
        
        for($x = 0; $x < count($array); $x++)
        {
            $arrayCategory .= $array[$x]; 
            if($x+1 < count($array))
            {
                $arrayCategory .= ",";
            }
        }
        
        $result = array($category,$arrayCategory);
        return $result;
    }
    
    /*
        fungsi untuk mendapatkan data category
    */
    public function listCategory()
    {
        $get_cat = new Model_DbTable_UserStoryCategory();
        $category = $get_cat->selectAllCategory();
        
        return $category;
    }


    /*
        fungsi untuk update field pada table user story
    */
    public function updateUserStory($id,$user_cobtributorId,$date)
    {
        $update = new Model_DbTable_UserStory();
        $update->updateField($id,$user_cobtributorId,$date);
    }
    
    /*
        fungsi untuk update field pada table user story content
    */
    public function updateUserStoryContent($storyContentId,$title,$content,$lang_id)
    {
        $update = new Model_DbTable_UserStoryContent();
        $update->updateField($storyContentId,$title,$content,$lang_id);
    }
    
    /*
        fungsi untuk add user contributor
    */
    public function addcontributor($input)
    {
        $db = new Model_DbTable_UserStoryContributor();
        $db->insertContributor($input);
        //$db->
    }    

    public function listcontributor($limit = 0, $offset = 0, $sortColumn = 0, $order = 'asc', $search = '')
    {
        $db = new Model_DbTable_UserStoryContributor();
        $data = $db->getAllDataFix($limit = 0, $offset = 0, $sortColumn = 0, $order = 'asc', $search = '');
        
        return $data;
    }
    
    /*
     * update data contributor
    */
    public function updateContributor($contributor_id,$data)
    {
        $db= new Model_DbTable_UserStoryContributor();
        $db->updateField($contributor_id,$data);
    }
    /*
     * delete data contributor
    */
    public function deleteContributor($contributor_id)
    {
        $db= new Model_DbTable_UserStoryContributor();
        $db->deleteContributor($contributor_id);
    }
    /*
     * delete data story
    */
    public function deleteStory($userstory_id)
    {
        $db_userstory= new Model_DbTable_UserStory();
        $db_userstory->deleteStory($userstory_id);
        
        $db_userstory_content = new Model_DbTable_UserStoryContent();
        $db_userstory_content->deleteField($userstory_id);
        
        $db_userstory_category = new Model_DbTable_UserStoryRelated();
        $db_userstory_category->deleteField($userstory_id);

        $db_userstory_tag = new Model_DbTable_UserStoryTag();
        $db_userstory_tag->deleteField($userstory_id);
    }


}
?>
