<?php
/**
 * Model_DbTable_CategoryDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel category description
 *
 * @package DbTable Model
 */
class Model_DbTable_CategoryDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'categorydescription';
    protected $_cat = 'category';

    public function insertCategory($input)
    {
        $this->insert($input);
    }

    public function updateCategory($input,$category_id,$language_id)
    {
        $where = $this->getAdapter()->quoteInto('category_id = ?',$category_id).
                $this->getAdapter()->quoteInto(' AND language_id = ?',$language_id);
        $this->update($input, $where);
    }

    public function deleteCategory($category_id)
    {
        $where = $this->getAdapter()->quoteInto('category_id = ?',$category_id);
        $this->delete($where);
    }

    public function deleteCategory2($category_id,$langId=2)
    {
        $where = $this->getAdapter()->quoteInto('category_id = ?',$category_id).
                $this->getAdapter()->quoteInto(' AND language_id = ?',$langId);
        $this->delete($where);
    }

    public function deleteCategoryEnglish($category_id,$langId=1)
    {
        $where = $this->getAdapter()->quoteInto('category_id = ?',$category_id).
                $this->getAdapter()->quoteInto(' AND language_id = ?',$langId);
        $this->delete($where);
    }

    public function checkForIndo($catId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('category_id = ?', $catId)
                ->where('language_id = 2');
        $report = $this->fetchRow($query);
        if($report!=null)
            {
                return true;
        }else
            {
            return false;
        }
    }

    public function checkForEnglish($catId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('category_id = ?', $catId)
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

    /**
     * Fungsi untuk mengambil data name dan category_id berdasarkan language_id
     *
     * @param integer $langId
     * @return array
     */
    public function getIdNameDescByLang($langId = 1)
    {
        $data = $this->select()
                ->from($this->_name, array('name'))
                ->setIntegrityCheck(false)
                ->join($this->_cat,"{$this->_name}.category_id = {$this->_cat}.category_id",
                array('category_id'))
                ->where('language_id = ?', $langId);
        $report = $this->fetchAll($data);
        $categoryValue[0] = "---Select Activities---";
        foreach ($report as $tempCategory)
        {

            $categoryValue[$tempCategory['category_id']] = $tempCategory['name'];
        }

        //$category = array("multiOptions" => $categoryValue);
        //return $category;
        return $categoryValue;
    }

    public function getNameByLang($category_id,$language_id = 1)
    {
        $select = $this->select()
                ->from($this->_name,array('name'))
                ->where('language_id = ?',$language_id)
                ->where('category_id = ?',$category_id);
        $result = $this->fetchRow($select);
        return $result;
    }

    public function checkDescEnglish($catId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 1')
                ->where('category_id = ?',$catId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('category_id = ?',$catId);
        $result2 = $this->fetchRow($query2);

        if($result2['count'] > '1')
        {
            if($result['description']==' ')
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


    public function checkDescIndo($catId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('category_id = ?',$catId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('category_id = ?',$catId);
        $result2 = $this->fetchRow($query2);
        
        if($result2['count'] > '1')
        {
            if($result['description']==' ')
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

}
?>
