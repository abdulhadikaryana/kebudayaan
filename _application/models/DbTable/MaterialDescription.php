<?php
/**
 * Model_DbTable_MaterialDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel material description
 *
 * @package DbTable Model
 */
class Model_DbTable_MaterialDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'materialdescription';

    /**
     * Fungsi untuk mengambil semua data dari tabel materialdescription
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel materialdescription
     * berdasarkan material_id yang diberikan
     * @param integer $id
     * @return array
     */
    public function getAllById($id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('material_id = ?', $id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel materialdescription
     * KECUALI yang mempunyai material_id seperti yang diberikan
     * @param integer $id
     * @return array
     */
    public function getAllExId($id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('material_id != ?', $id);
        return $this->fetchAll($data);
    }

    /**
     * fungsi untuk mengambil semua data dari tabel materialdescription berdasarkan
     * language_id yang diberikan

     * @param integer $lang_id
     * @return array
     */
    public function getAllByLang($lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel materialdescription berdasarkan
     * material_id yang diberikan
     * 
     * @param integer $id
     * @param integer $lang_id
     * @return array
     */
    public function getAllByIdLang($id, $lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('material_id = ?', $id)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data title
     * @return array
     */
    public function getAllTitle()
    {
        $data = $this->select()
                ->from($this->_name,array('title'));
        return $this->fetchAll($data);
    }

    public function getAllDescription()
    {
        $data = $this->select()
                ->from($this->_name,array('description'));
        return $this->fetchAll($data);
    }

    public function getAllTitleDesc()
    {
        $data = $this->select()
                ->from($this->_name,array('title','description'));
        return $this->fetchAll($data);
    }

    public function getAllByTitle($title)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("title LIKE '%" . $title . "%'");
        return $this->fetchAll($data);
    }

    /**
     * ADDED BY BEMBY (2010-05-22)
     * Fungsi untuk mengambil data title dari tabel materialDescription
     * berdasarkan material_id dan language_id yang diberikan
     * @param integer $material_id
     * @param integer $lang_id
     * @return array
     */
    public function getTitleById($material_id, $lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name, array('title'))
                ->where('material_id = ?', $material_id)
                ->where('language_id = ?', $lang_id);

        $result = $this->fetchRow($data);

        return $result['title'];
    }

    public function getDescriptionById($material_id)
    {
        $data = $this->select()
                ->from($this->_name, array('description'))
                ->where('material_id = ?', $material_id);

        $result = $this->fetchRow($data);

        return $result;
    }

    public function insertMaterial($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function checkForIndo($catId,$langId = 2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('material_id = ?', $catId)
                ->where('language_id = ?',$langId);
        $report = $this->fetchRow($query);
        if($report!=null)
            {
                return true;
        }else
            {
            return false;
        }
    }

    public function updateMaterial($input,$material_id, $language_id = 1)
    {
         $where = $this->getAdapter()->quoteInto('material_id = ?',$material_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
        $this->update($input, $where);
    }

    public function deleteMaterial($material_id)
    {
        $where = $this->getAdapter()->quoteInto('material_id = ?',$material_id);
        $this->delete($where);
    }

    public function deleteMaterial2($material_id, $language_id = 2)
    {
        $where = $this->getAdapter()->quoteInto('material_id = ?',$material_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
        $this->delete($where);
    }

    public function getQueryAll($type = 0, $param = null, $langId=1)
    {
        $select = $this->select()
                ->from(array('md' => $this->_name), array('md.material_id', 'md.title'))
                ->where('language_id = ?',$langId)
                ->order('md.material_id DESC');
        
        if ($type == 1) {
            $select->where("md.title LIKE '%".$param."%'");
        }
        
        return $select;
    }

    public function checkDescIndo($matId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('material_id = ?',$matId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('material_id = ?',$matId);
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