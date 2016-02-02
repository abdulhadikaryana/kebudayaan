<?php
/**
 * Model_DbTable_Material
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel material
 *
 * @package DbTable Model
 */
class Model_DbTable_Material extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'material';
    protected $_matdes = 'materialdescription';
    protected $_link = 'materiallink';

    /**
     * Fungsi untuk mengambil semua data dari tabel material
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel material berdasarkan
     * material_id yang diberikan
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
     * Fungsi untuk mengambil semua data dari tabel material KECUALI yang
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
     * Fungsi untuk mengambil semua data name dari tabel material
     * @return array
     */
    public function getAllName()
    {
        $data = $this->select()
                ->from($this->_name,array('name'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data name berdasarkan poi_id
     * @param integer $id
     * @return array
     */
    public function getNameById($id)
    {
        $data = $this->select()
                ->from($this->_name,array('name'))
                ->where('material_id = ?', $id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel material berdasarkan name
     * yang diberikan
     * @param string $name
     * @return array
     */
    public function getAllByName($name)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("name LIKE '%" . $name . "%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mendapatkan data link berdasarkan material_id yang diberikan
     * @param integer $id
     * @return array
     */
    public function getLinkById($id)
    {
        $data = $this->select()
                ->from($this->_name,array('link'))
                ->where('material_id = ?', $id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     *
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDesc($lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_matdes,"{$this->_matdes}.material_id = {$this->_name}.material_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_matdes}.language_id = ?", $lang_id)
                ->order("{$this->_matdes}.material_id DESC");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel material dan
     * materialdescription berdasarkan material_id dan language_id
     * yang diberikan
     *
     * @param integer $material_id
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDescById($material_id, $lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_matdes,
                "{$this->_matdes}.material_id =
                {$this->_name}.material_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_matdes}.material_id = ?", $material_id)
                ->where("{$this->_matdes}.language_id = ?", $lang_id);

        $return = $this->fetchRow($data);

        return $return;
    }

    public function insertMaterial($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function getQueryAll($type = 0, $param = null)
    {
        $select = $this->select()
                ->from($this->_name)
                ->order('material_id DESC');
        if($type == 1){$select->where("{$this->_name}.name LIKE '%".$param."%'");}
        return $select;
    }

    public function updateMaterial($input,$material_id)
    {
        $where = $this->getAdapter()->quoteInto('material_id = ?',$material_id);
        $this->update($input, $where);
    }

    public function deleteMaterial($material_id)
    {
        $where = $this->getAdapter()->quoteInto('material_id = ?',$material_id);
        $this->delete($where);
    }



}
?>
