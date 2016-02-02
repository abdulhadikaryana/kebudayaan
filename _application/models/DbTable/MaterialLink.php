<?php
/**
 * Model_DbTable_MaterialLink
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel material link
 *
 * @package DbTable Model
 */
class Model_DbTable_MaterialLink extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'materiallink';

    /**
     * Fungsi untuk mengambil semua data dari tabel materiallink
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel materiallink berdasarkan
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
     * Fungsi untuk mengambil semua data dari tabel materiallink KECUALI yang
     * mempunyai material_id seperti yang diberikan
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

    public function insertMaterial($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function updateMaterial($input,$material_id,$file_number)
    {
        $where[] = $this->getAdapter()->quoteInto('material_id = ?',$material_id);
        $where[] = $this->getAdapter()->quoteInto('file_number = ?',$file_number);
        $this->update($input, $where);
    }

    public function deleteMaterial($material_id,$file_number)
    {
        $where[] = $this->getAdapter()->quoteInto('material_id = ?',$material_id);
        $where[] = $this->getAdapter()->quoteInto('file_number = ?',$file_number);
        $this->delete($where);
    }
    
    public function deleteAllMaterial($material_id)
    {
        $where = $this->getAdapter()->quoteInto('material_id = ?',$material_id);
        $this->delete($where);
    }

    public function getAllNameLinkByMaterialId($materialId)
    {
        $query = $this->select()
                ->from($this->_name,array('file','link'))
                ->where('material_id = ?', $materialId);
        $count = $this->fetchAll($query);
        $return = $count->toArray();
        return $return;
    }
}
?>
