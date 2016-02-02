<?php
/**
 * Model_DbTable_ImageDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel image description
 *
 * @package DbTable Model
 */
class Model_DbTable_ImageDescription extends Zend_Db_Table_Abstract
{
    protected $_name = 'gallerydesc';
    
    public function insertImageDescription($data)
    {
        $this->insert($data);        
    }
    
    public function updateImageDescription($data,$gallery_id)
    {
        $where = $this->getAdapter()->quoteInto('gallery_id = ?',$gallery_id).
        $this->getAdapter()->quoteInto(' AND language_id = ?',$data['language_id']);
        $this->update($data,$where);
    }

    public function deleteImageDescription($gallery_id)
    {
        $where = $this->getAdapter()->quoteInto('gallery_id = ?',$gallery_id);
        $this->delete($where);
    }
}