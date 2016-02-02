<?php

class Model_Userstorycategory {

    //put your code here
    private $_languageId;

    /**
     * Constructor
     */
    function __Construct()
    {
        //$this->_languageId = Zend_Registry::get('languageId');
    }


    /*
        fungsi untuk menampilkan list userstory yang belum di approve
    */
    
    public function listNonApproved($user_id,$approved=0)
    {
        $userStory = new Model_DbTable_UserStory();
        $content = $userStory->selectAllDataFix($user_id,$approved);
        
        return $content;
    }

    /*
        fungsi untuk menyimpan categori baru
    */
    public function saveCategory($title,$content,$lang_id)
    {
        $categoryStory = new Model_DbTable_UserStoryCategory();
        $categoryStory->insertStory($title,$content,$lang_id);
    }
    
    /*
        fungsi untuk mendapatkan id terakhir dari tabel
    */
    public function getLastId()
    {
        $id = new Model_DbTable_UserStoryCategory();
        
        return $id->lastID();
    }
    
    /*
        fungsi untuk menampilkan data category
    */
    public function selectAllCategory()
    {
        $category = new Model_DbTable_UserStoryCategory();
        
        return $category->selectAllCategory();
    }
    
    /*
        fungsi untuk menampilkan bahasa
    */
    
    public function listlang()
    {
        $getLang = new Model_DbTable_Language();
        
        $lang = $getLang->getAllLang();
        
        
        return $lang;
        
    }

    /*
        fungsi untuk menyimpan relasi antara tabel userstory dgn tabel userstorycategory
    */

    public function saveRelatedCategory($story_id,$storyCategory_id)
    {
        $relatedStory = new Model_DbTable_UserStoryRelated();
        
        //karena kategori lebih dari satu, jadi di save sebanyak jumlah categori yg di inputkan
        $arr = explode(',',$storyCategory_id);
        if(sizeof($arr) > 0)
        {
            for($i=0;$i<count($arr);$i++){
                $relatedStory->insertRealatedStory($story_id,$arr[$i]);
            }
        }

    }

    /*
        fungsi untuk update field pada table user story
    */
    public function updateUserStory($storyId,$approved)
    {
        $update = new Model_DbTable_UserStory();
        $update->updateField($storyId,$approved);
    }
    
    /*
        fungsi untuk update field pada table user story content
    */
    public function updateUserStoryContent($storyContentId,$title,$content)
    {
        $update = new Model_DbTable_UserStoryContent();
        $update->updateField($storyContentId,$title,$content);
    }
    
    
}
?>
