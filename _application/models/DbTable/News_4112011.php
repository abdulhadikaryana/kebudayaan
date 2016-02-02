<?php
/**
 * Model_DbTable_News
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel news
 *
 * @package DbTable Model
 */
class Model_DbTable_News extends Zend_Db_Table_Abstract
{
    //deklarasi tabel yang digunakan dalam model news
    protected $_name = 'news';
    protected $_table = 'newsdesc';
    protected $_primary = 'news_id';

    public function insertNews($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }
    
    public function updateNews($input,$news_id)
    {
        $where = $this->getAdapter()->quoteInto('news_id = ?',$news_id);
        $this->update($input, $where);
    }
    
    public function deleteNews($news_id)
    {
        $where = $this->getAdapter()->quoteInto('news_id = ?',$news_id);
        $this->delete($where);
    }
    

    /**
     * Fungsi untuk mengambil semua data dari tabel news dan newsdesc berdasarkan
     * language_id yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDesc($lang_id = 1, $limit = '')
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_table,"{$this->_table}.news_id = {$this->_name}.news_id")
                ->where("{$this->_table}.language_id = ?", $lang_id)
                ->setIntegrityCheck(false)
                ->order('publish_date DESC');

        if( ! empty($limit)) {
            $query->limit($limit, 0);
        }
                
        return $query;
    }

    public function getAllWithDescById($news_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_table,"{$this->_table}.news_id = {$this->_name}.news_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_table}.language_id = ?", $lang_id)
                ->where("{$this->_name}.news_id = ?", $news_id);
        return $this->fetchRow($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel news berdasarkan news_id yang
     * diberikan
     * 
     * @param integer $news_id
     * @return array
     */
    public function getAllById($news_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('news_id = ?', $news_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel news KECUALI yang mempunyai
     * news_id sesuai dengan yang diberikan
     *
     * @param integer $news_id
     * @return array
     */
    public function getAllExId($news_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('news_id != ?', $news_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data news_id,picture,publish_date,title,dan content
     * yang paling terakhir
     * 
     * @return array
     */
    public function getLastNews($languageID = 1)
    {
        $data = $this->select()
                ->from($this->_name,array('news_id', 'picture','publish_date'))
                ->join($this->_table,
                       "{$this->_table}.news_id = {$this->_name}.news_id",
                       array('title','content'))
                ->setIntegrityCheck(false)
                ->where("{$this->_table}.language_id = ?",$languageID)
                ->order('publish_date DESC')
                ->limit(8,0);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil tiga data news terakhir
     * @return array
     */
    public function getThreeListNews($languageID = 1)
    {   
        $data = $this->select()
                ->from($this->_name,array(''))
                ->join($this->_table,"{$this->_table}.news_id = {$this->_name}.news_id",array('title'))
                ->setIntegrityCheck(false)
                ->where("{$this->_table}.language_id = ?",$languageID)
                ->order('publish_date DESC')
                ->limit(3,1);
        return $this->fetchAll($data);
    }

    public function getQueryAllByLanguage($type = 0,$param = null,$month = null,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('n' => $this->_name),array('n.news_id,n.showing,DATE(publish_date) AS date','showing'))    
                  ->join(array('nd' => $this->_table),'nd.news_id = n.news_id',array('title'))
                  ->where('nd.language_id = ?',$language_id);
        switch($type)
        {
            case 1: $select->where("nd.title LIKE '%".$param."%'");
                    break;
            case 2: $select->join(array('pn' => 'poitonews'),'pn.news_id = n.news_id');
                    $select->join(array('p' => 'poi'),'p.poi_id = pn.poi_id');
                    $select->join(array('pd' => 'poidescription'),'pd.poi_id = p.poi_id');
                    $select->where("pd.name LIKE '%".$param."%'");
                    $select->where("pd.language_id = ?",$language_id);
                    $select->group('n.news_id');
                    break;
            case 3: $select->where('MONTH(n.publish_date) = ?',$month);
                    $select->where('YEAR(n.publish_date) = ?',$param);
                    break;
            case 4: $select->where("n.showing = ?", $param);
                    break;
        }
        $select->order('news_id DESC');
        return $select;
    }
    
    public function getPublishYear()
    {
        $select = $this->select()
                  ->from($this->_name,array('YEAR(publish_date) AS year'))
                  ->order('year ASC')
                  ->group('year');
        return $this->fetchAll($select)->toArray();
    }

    public function getPictureById($news_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('picture'))
                  ->where('news_id = ?',$news_id);
        $image = $this->fetchrow($select);
        if(!empty($image)){$image = $image->toArray();}
        return $image['picture'];
    }
    
    public function getStatusById($news_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('showing'))
                  ->where('news_id = ?',$news_id);
        $status = $this->fetchRow($select);
        if(!empty($status)){return $status['showing'];}
    }
    
    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -**/
    /* jul                                                                                                  */
    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -**/

    /*
        menampilakan hasil pencarian pada tabel news dan newsdesc berdasarkan
        parameter (kata kunci) yang di request
    
    */
    public function searchNews($param, $limit=10, $offset=0, $lang_id)
    {
        
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('news_id','picture'))
                ->join($this->_table,"{$this->_table}.news_id = {$this->_name}.news_id",array('title','content'))
                ->where("{$this->_table}.language_id = ?",$lang_id)
                ->where("{$this->_table}.title like '%$param%'")
                ->limit($limit,$offset);
        return $this->fetchAll($data);
    }

   public function searchNewsFix($param, $limit = 10, $offset = 0, $lang_id)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('news_id','picture'))
                ->join($this->_table,"{$this->_table}.news_id = {$this->_name}.news_id",array('title','content'))
                ->where("{$this->_table}.language_id = ?",$lang_id)
                ->limit($limit,$offset);

        $key = explode(' ', $param);
        if(is_array($key))
        {
            $string = '';
            $string2 = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_table}.title like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_table}.title like '%$key[$i]%'";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%'";
                }

            }

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');


        }
        else
        {
            
            
            $string = "{$this->_table}.title like '%$param%'";
            $string2 = "{$this->_table}.content like '%$param%'";
            

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }
        
        $result = $this->fetchAll($query);
        
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
    
    public function numbRowsNews($param, $lang_id){
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('news_id','picture'))
                ->join($this->_table,"{$this->_table}.news_id = {$this->_name}.news_id",array('title','content'))
                ->where("{$this->_table}.language_id = ?",$lang_id);
                //->limit($limit,$offset);

        $key = explode(' ', $param);
        if(is_array($key))
        {
            $string = '';
            $string2 = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_table}.title like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_table}.title like '%$key[$i]%'";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%'";
                }

            }

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');


        }
        else
        {
            
            
            $string = "{$this->_table}.title like '%$param%'";
            $string2 = "{$this->_table}.content like '%$param%'";
            

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }

        $result = $this->fetchAll($query);
        
        if(count($result))
        {
            //return $query;
            return count($result);
        }
        else
        {
            return null;
        }

    }
}
?>
