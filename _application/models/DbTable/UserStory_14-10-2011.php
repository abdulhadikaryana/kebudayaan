<?php
/**
 * Model_DbTable_UserStory
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStory extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'userstory';
    protected $_tag = 'userstorytag';
    protected $_content = 'userstorycontent';
    protected $_contributor = 'userstorycontributor';
    //protected $_primary = array('id');

    public function insertStory($user_id,$date,$approved,$category){
        
        $data = array(
                    'user_id'   => $user_id,
                    'approved'  => $approved,
                    'date'      => $date,
                    'category'  => $category
                );
        
        $this->insert($data);
    }
    
    public function getAllData($user_id){
        $data = $this->select()
                ->from($this->_name,array('id'))
                ->where("{$this->_name}.user_id = ?",$user_id);
        return count($this->fetchAll($data));
    }

    public function getLastID($user_id){
        $data = $this->select()
                ->from($this->_name,array('id'))
                ->where("{$this->_name}.user_id = ?",$user_id)
                ->order("{$this->_name}.id DESC")
                ->limit(1);
        
        $result = $this->fetchRow($data);
        //$result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /*
        get all data (fungsi ini dipakai oleh data table di viewer list usergenerated content)
    */

    public function getAllDataFix($approved=0, $filter, $filter_lang, $limit = 0, $offset = 0, $sortColumn = 0, $order = 'asc', $search = ''){

        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date','category'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->where("{$this->_name}.approved = ?",$approved)
                ->limit($limit,$offset);

        /*
            filter language, default all
        */

        if($filter_lang != 'all')
        {
            $data->where("{$this->_content}.language_id = ?",$filter_lang);
        }
        
        /*
            filter category
            1 -> category
            2 -> photoessay
                    default all
        */

        if($filter != 'all')
        {
            $data->where("{$this->_name}.category = ?",$filter);
        }

        //filter searching
        if($search != '')
        {
            $data->where("{$this->_content}.title like '%$search%'");
        }

        if(($order == 'asc') || ($order == 'undefined'))
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id ASC'; break;
                case 1 : $string = 'id ASC'; break;
            }
            //$string = 'id ASC';
        }
        else if($order = 'desc')
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id DESC'; break;
                case 1 : $string = 'id DESC'; break;
            }
            //$string = 'id DESC';
        }
        
        $data->order($string);

        $result = $this->fetchAll($data);
        
        if($filter_lang == "all")
        {
            return NULL;            
        }
        else
        {
            if(count($result))
            {
                return $result->toArray();;
            }
            else
            {
                return NULL;
            }
            
        }
    }
    
    /*
        count data
    */
    public function countAllData($approved=0, $filter, $filter_lang, $limit = 0, $offset = 0, $sortColumn = 0, $order = 'asc', $search = '')
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date','category'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->where("{$this->_name}.approved = ?",$approved);
                //->limit($limit,$offset);

        /*
            filter language, default all
        */

        if($filter_lang != 'all')
        {
            $data->where("{$this->_content}.language_id = ?",$filter_lang);
        }
        
        /*
            filter category
            1 -> category
            2 -> photoessay
                    default all
        */

        if($filter != 'all')
        {
            $data->where("{$this->_name}.category = ?",$filter);
        }

        //filter searching
        if($search != '')
        {
            $data->where("{$this->_content}.title like '%$search%'");
        }

        if(($order == 'asc') || ($order == 'undefined'))
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id ASC'; break;
                case 1 : $string = 'id ASC'; break;
            }
            //$string = 'id ASC';
        }
        else if($order = 'desc')
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id DESC'; break;
                case 1 : $string = 'id DESC'; break;
            }
            //$string = 'id DESC';
        }
        
        $data->order($string);

        $result = $this->fetchAll($data);
        
        if($filter_lang == "all")
        {
            return NULL;            
        }
        else
        {
            if(count($result))
            {
                //return count($result);
                return $result->toArray();;
            }
            else
            {
                return NULL;
            }
        }
       
    }    
    
    /*
        select all data
    */

    public function selectAllDataFix($user_id,$approved=0){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','category','date'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                //->where("{$this->_name}.user_id = ?",$user_id)
                ->where("{$this->_name}.approved = ?",$approved);

        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result->toArray();;
        }
        else
        {
            return NULL;
        }
    }

                
    public function selectAllData($user_id,$approved=0){
        $data = $this->select()
                ->from($this->_name,array('id','user_id','approved','category','date'))
                ->where("{$this->_name}.user_id = ?",$user_id)
                ->where("{$this->_name}.approved = ?",$approved);

        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /*
        untuk detail user story content
        param = user_story id
    */
    public function getById($id,$lang_id){

        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id AS article_id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed','rating'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id")
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_name}.user_id",array('nama','contact','foto','email'))
                ->where("{$this->_name}.id = ?",$id)
                ->where("{$this->_content}.language_id = ?",$lang_id);

        $result = $this->fetchRow($data);
        
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }
    
    /*
        update berdasarkan  userstory_id
    */
    public function updateField($userstory_id,$user_contibutorId,$date)
    {
        $data = array(
                      'user_id' => $user_contibutorId,
                      'date'=>$date
                      );

        $where = $this->getAdapter()->quoteInto('id = ?', $userstory_id);
        $this->update($data, $where);
    }
    
    /*
        fungsi get content by language_id
    */
    public function getByLang($user_id,$approved,$lang_id)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->where("{$this->_name}.user_id = ?",$user_id)
                ->where("{$this->_name}.approved = ?",$approved)
                ->where("{$this->_content}.language_id = ?",$lang_id);

        $result = $this->fetchAll($data);
        //$result = $this->fetchRow($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /*
        fungsi get content berdasarkan keyword
    */
    public function getByKeyword($user_id,$approved,$keyword)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->where("{$this->_name}.user_id = ?",$user_id)
                ->where("{$this->_name}.approved = ?",$approved)
                ->where("{$this->_content}.title like '%$keyword%'");
                
            //return $data;

        $result = $this->fetchAll($data);
        //$result = $this->fetchRow($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }


    /*
        fungsi filter content berdasarkan tahun dan user contributor id
    */
    public function filterYear($usercontrib_id,$year,$limit=0,$offset=0)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                //->where("{$this->_name}.user_id = ?",$usercontrib_id)
                ->where("YEAR({$this->_name}.date) = ?",$year)
                ->limit($limit,$offset);
                
        //$result = $data;
        $result = $this->fetchAll($data);
        //$result = $this->fetchRow($data);
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }


    /*
        fungsi filter content berdasarkan bulan dan user contributor
    */
    public function filterMonth($usercontrib_id,$month,$limit=0,$offset=0)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                //->where("{$this->_name}.user_id = ?",$usercontrib_id)
                ->where("MONTH({$this->_name}.date) = ?",$month)
                ->limit($limit,$offset);
                
        $result = $this->fetchAll($data);
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }


    /*
        mengembalikan content yg paling populer
    */
    public function popularPost($lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date','viewed'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->where("{$this->_content}.language_id = ?",$lang_id)
                ->order('viewed DESC')
                ->limit(2);
                
        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
            //return $result->toArray();;
        }
        else
        {
            return NULL;
        }
    }
    
    /* archive per bulan*/
    public function archiveMonth($lang_id)
    {
        //$data = $this->select()
        //        ->from($this->_name,array('DISTINCT(MONTH(date)) AS bulan, YEAR(date) AS tahun'))
        //        ->where("{$this->_content}.language_id = ?",$lang_id)
        //        ->order('bulan ASC');

        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('DISTINCT(MONTH(date)) AS bulan, YEAR(date) AS tahun'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('language_id'))
                ->where("{$this->_content}.language_id = ?",$lang_id)
                ->order('bulan ASC');

        //$result = $this->fetchRow($data);
        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return  $result;
        }
        else
        {
            return NULL;
        }
        
    }
    
    /*
        untuk index user contributor
    */
    public function contentIndex($lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed','rating'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_name}.user_id",array('nama','contact','foto','email'))
                ->where("{$this->_content}.language_id = ?",$lang_id)
                ->order("{$this->_name}.date DESC");
                
        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result->toArray();
        }
        else
        {
            return NULL;
        }
    }

    //fungsi untuk memperoleh data viewed 
    public function viewed($userstory_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','viewed'))
                ->where("{$this->_name}.id = ?",$userstory_id);
                
        $result = $this->fetchRow($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /*
        update viewed
    */
    public function updateViewed($userstory_id,$viewed)
    {
        $data = array('viewed' => $viewed);
        $where = $this->getAdapter()->quoteInto('id = ?', $userstory_id);
        $this->update($data, $where);
    
    }
    
    /*
        untuk detail archive user contributor
    */
    //public function contentArchive($month, $limit, $offset){
    public function contentArchive($month,$lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed','rating'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_name}.user_id",array('nama','contact','foto','email'))
                ->where("MONTH({$this->_name}.date) = ?",$month)
                ->where("{$this->_content}.language_id = ?",$lang_id);
                
        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }


    /*
        untuk detail archive user contributor
    */
    public function filterByType($content_type,$lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed','rating'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_name}.user_id",array('nama','contact','foto','email'))
                ->where("{$this->_name}.category = ?",$content_type)
                ->where("{$this->_content}.language_id = ?",$lang_id)
                ->order("{$this->_name}.date DESC");
                
        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /* detail content author */
    public function getByAuthor($author_id,$lang_id)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('id as id_content','title','short_content','content'))
                ->where("{$this->_name}.user_id = ?",$author_id)
                ->where("{$this->_content}.language_id = ?",$lang_id);

        $result = $this->fetchAll($data);
        
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }        
    }

    public function sortBy($author_id,$sorted,$lang_id)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','date','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id")
                ->where("{$this->_name}.user_id = ?",$author_id)
                ->where("{$this->_content}.language_id = ?",$lang_id);
                
                if($sorted == "date") //sort by date
                {
                    $data->order("date DESC");
                }
                else{ //sort by popular post
                    $data->order("viewed DESC");
                }
                

        $result = $this->fetchAll($data);
        
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }        
    }




    /*
        untuk searching content
    */
    public function searching($keyword,$category,$lang_id){
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','viewed','category','rating'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id",array('title','content','language_id'))
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_name}.user_id",array('nama','contact','foto','email'))

                ->where("{$this->_content}.language_id = ?",$lang_id);
                
                if($category == "photoessay")
                {
                    $query->where("{$this->_name}.category = ?",2);
                }
                elseif($category == "article")
                {
                    $query->where("{$this->_name}.category = ?",1);
                }


        $key = explode(' ', $keyword);
        if(is_array($key))
        {
            $string = '';
            $string2 = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_content}.title like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_content}.content like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_content}.title like '%$key[$i]%'";
                    $string2 .= "{$this->_content}.content like '%$key[$i]%'";
                }
            }
            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }
        else
        {
            $string = "{$this->_content}.title like '%$keyword%'";
            $string2 = "{$this->_content}.content like '%$keyword%'";
            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }

        $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END";
        $query .= $string_order;
        
        ////echo $query;
            
        $q = $this->_db->query($query);
        $result = $q->fetchAll();
        

        //$result = $this->fetchAll($query);
        
        if(count($result))
        {
            //return $query;
            return $result;
        }
        else
        {
            return null;
        }


    }


    /*
        update rating
    */
    public function rating($userstory_id,$score_rating)
    {
        $data = array('rating' => $score_rating);
        $where = $this->getAdapter()->quoteInto('id = ?', $userstory_id);
        $this->update($data, $where);
    }


    /*
        delete data
    */
    public function deleteStory($story_id)
    {
       $where = $this->getAdapter()->quoteInto('id = ?', $story_id);
       $this->delete($where);
    }


    /**
     * Fungsi untuk mengambil semua data dari tabel userstory dan userstory content berdasarkan
     * language_id yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getAllDataWithContent($lang_id)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id as article_id'))
                ->join($this->_content,"{$this->_content}.userstory_id = {$this->_name}.id")
                ->where("{$this->_content}.language_id = ?",$lang_id)
                ->order('date DESC');
                //->limit($limit,$offset);
                
        return $query;
    }

}
?>
