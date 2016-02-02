<?php

class Model_UserContributor {

    /**
     * Constructor
     */
    function __Construct()
    {
        
    }
    
    /* -------------------- untuk content side bar ----------------------------*/
    /*
        mengembalikan list userstory category
    */
    public function select_category($lang_id)
    {
        $dbCategory = new Model_DbTable_UserStoryCategory();
        $category = $dbCategory->selectAllCategory($lang_id);
        
        return $category;
    }

    public function select_category_hascontent($lang_id)
    {
        $dbCategory = new Model_DbTable_UserStoryRelated();
        $category = $dbCategory->selectCatHasContent($lang_id);
        return $category;
    }


    /*
        mengembalikan content yang paling banyak di lihat
    */
    public function popular_post($lang_id)
    {
        $db = new Model_DbTable_UserStory();
        $popular_post = $db->popularPost($lang_id);
        
        return $popular_post;
    }    
    
    /*
        mengembalikan list user contributor
        limit 3
    */
    public function user_contributor($limit)
    {
        $db = new Model_DbTable_UserStoryContributor();
        $popular_post = $db->displayUserContributor($limit);
        
        return $popular_post;
    }    


    /*
        mengembalikan data archive per bulan
    */
    public function archive($lang_id)
    {
        $db = new Model_DbTable_UserStory();
        $getArhive = $db->archiveMonth($lang_id);
        
        return $getArhive;
    }    

    /* -------------------- content side bar end ----------------------------*/


    /* -------------------- content index ----------------------------*/
    public function contentIndex($lang_id)
    {
        $db = new Model_DbTable_UserStory();
        $data = $db->contentIndex($lang_id);

        return $data;
    }
    
	public function cekContentByLang($lang_id)
    {
        $db = new Model_DbTable_UserStory();
        return $db->cekContentByLang($lang_id);
    }
	
    public function contentIndexCategory($userstory_category_id)
    {

        $db = new Model_DbTable_UserStoryRelated();
        $data = $db->select_content($userstory_category_id);
        
        if($data == NULL)
        {
            return 0;
        }
        else
        {
            return $data;
        }

    }

    /* -------------------- end content index ----------------------------*/



    /* -------------------- content archive ----------------------------*/
    //public function contentArchive($month, $limit, $offset)
    public function contentArchive($month,$lang_id)
    {
        $db = new Model_DbTable_UserStory();
        $data = $db->contentArchive($month,$lang_id);
        //$data = $db->contentArchive($month, $limit, $offset);
        
        return $data;
    }



    /* -------------------- detail content ----------------------------*/
    public function getViewed($userstory_id)
    {
        $db = new Model_DbTable_UserStory();
        $data = $db->viewed($userstory_id);
        
        return $data;
    }
    public function updateViewed($userstory_id,$viewed)
    {
        $db = new Model_DbTable_UserStory();
        $db->updateViewed($userstory_id,$viewed);
    }

    //detail content
    public function contentDetail($userstory_id,$lang_id)
    {
        $db = new Model_DbTable_UserStory();
        
        $data = $db->getById($userstory_id,$lang_id);
        
        return $data;
    }


    /* -------------------- filter content ----------------------------*/
    /*
        param content_type 
        values = all category 
        values = artice category 
        values = photoessay category 
     
    */
    public function filterContent($content_type,$lang_id)
    {
        $db = new Model_DbTable_UserStory();
        
        switch($content_type)
        {
            case "all" : $data = $db->filterByType(0,$lang_id); break;
            case "article" : $data = $db->filterByType(1,$lang_id); break;
            case "photoessay" : $data = $db->filterByType(2,$lang_id); break;
            case "Photo Essays" : $data = $db->filterByType(2,$lang_id); break;
        }
        
        return $data;
    }
    
    /*-------------------------- author ---------------------------------*/    

    public function listAuthor()
    {
        $db = new Model_DbTable_UserStoryContributor();
        $list = $db->selectAll();
        
        return $list;
    }

 
    public function detailAuthor($author_id)
    {
        $db = new Model_DbTable_UserStoryContributor();
        $detail = $db->getById($author_id);
        
        return $detail;
    }

    public function detailContentAuthor($author_id,$lang_id)
    {
        $db = new Model_DbTable_UserStory();
        $detail_content = $db->getByAuthor($author_id,$lang_id);

        return $detail_content;
    }

    public function sortBy($author_id,$sorted,$lang_id)
    {
        $db = new Model_DbTable_UserStory();
        $detail_content = $db->sortBy($author_id,$sorted,$lang_id);

        return $detail_content;
    }

    /*-------------------------- searching ---------------------------------*/    
    public function searching($keyword,$category,$lang_id)
    {
        $db = new Model_DbTable_UserStory();
        $data = $db->searching($keyword,$category,$lang_id);
        
        return $data;
        
    }


    /*-------------------------- rating ---------------------------------*/    
    /*
    * rating_status = 1 > rating content
    * rating_status = 2 > rating author
    */    
    public function updateRating($id,$score_rating,$rating_status)
    {
        if($rating_status == 1) //rating content
        {
            $db = new Model_DbTable_UserStory();
            $db->rating($id,$score_rating);
        }
        else //rating author
        {
            $db = new Model_DbTable_UserStoryContributor();
            $db->rating($id,$score_rating);
        }
        
    }

}
?>
