<?php
/**
 * Model_DbTable_ArticleDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel article description
 *
 * @package DbTable Model
 */
class Model_DbTable_ArticleDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'articledescription';
    protected $_primart = array('article_id','language_id');

    public function insertArticleDescription($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function checkForIndo($catId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('article_id = ?', $catId)
                ->where('language_id = 2');
        $report = $this->fetchRow($query);

        if(sizeof($report))
        {
            return true;
        }
        else{
            return false;
        }


        //if($report!=null)
        //    {
        //        return true;
        //}else
        //    {
        //    return false;
        //}
    }

    public function checkForEnglish($catId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('article_id = ?', $catId)
                ->where('language_id = 1');
        $report = $this->fetchRow($query);
        if($report!=null)
            {
                return true;
        }else
            {
            return false;
        }
    }

    public function updateArticleDescription($input,$article_id,$language_id)
    {
        $where = $this->getAdapter()->quoteInto('article_id = ?',$article_id).$this->getAdapter()->quoteInto(' AND language_id = ?',$language_id);
        $this->update($input, $where);
    }
    
    public function deleteArticleDescription($article_id)
    {
        $where = $this->getAdapter()->quoteInto('article_id = ?',$article_id);
        $this->delete($where);
    }

    public function deleteArticleDescription2($article_id)
    {
        $where = $this->getAdapter()->quoteInto('article_id = ?',$article_id).
                $this->getAdapter()->quoteInto(' AND language_id = 2');
        $this->delete($where);
    }

    public function deleteArticleDescriptionEnglish($article_id)
    {
        $where = $this->getAdapter()->quoteInto('article_id = ?',$article_id).
                $this->getAdapter()->quoteInto(' AND language_id = 1');
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil semua data dati tabel articledescription
     *
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel articledescription berdasarkan
     * article_id yang diberikan
     *
     * @param integer $artId
     * @return array
     */
    public function getAllById($artId)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('article_id = ?', $artId);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel articledescription berdasarkan
     * article_id dan language_id yang diberikan
     *
     * @param integer $artId
     * @param integer $langId
     * @return array
     */
    public function getAllByIdLang($artId, $langId)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('article_id = ?', $artId)
                ->where('language_id = ?', $langId);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel articledescription berdasarkan
     * language_id yang diberikan
     *
     * @param integer $lang_id
     * @return array
     */
    public function getAllByLang($lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data title dari tabel articledescription
     *
     * @return array
     */
    public function getAllTitle()
    {
        $data = $this->select()
                ->from($this->_name,array('title'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel articledescription berdasarkan
     * title yang diberikan
     *
     * @param integer $title
     * @return array
     */
    public function getAllByTitle($title)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("title LIKE '%".$title."%'");
        return $this->fetchAll($data);
    }

    public function checkDescIndo($articleId, $langid)
    {
        $query = $this->select()
                ->from($this->_name,array('content'))
                ->where('language_id = ?',$langid)
                ->where('article_id = ?',$articleId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('article_id = ?',$articleId);
        $result2 = $this->fetchRow($query2);
        
        if($result2['count'] > '1')
        {
            if($result['content']==' ')
            {
                return false;
            }else
            {
                return true;
            }
        }
        else
        {
            return false;
        }

    }

    //get articledesc by id
    public function getArticleName($article_id_id,$lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('article_id','language_id','title'))
                ->where("{$this->_name}.article_id = ?",$article_id_id)
                ->where("{$this->_name}.language_id = ?",$lang_id);
    
        $result = $this->fetchRow($query);
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }        
    }


}
?>