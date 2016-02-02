<?php
/**
 * Model_DbTable_Image
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel image
 *
 * @package DbTable Model
 */
class Model_DbTable_Image extends Zend_Db_Table_Abstract {

    //deklarasi tabel yang digunakan dalam model image
    protected $_name = 'gallery';
    protected $_primary = 'gallery_id';
    
    public function insertImage($data)
    {
        $this->insert($data);
        $gallery_id = $this->_db->lastInsertId();
        return $gallery_id;
    }
    
    public function updateImage($data,$gallery_id)
    {
        $where = $this->getAdapter()->quoteInto('gallery_id = ?',$gallery_id);
        $this->update($data,$where);
    }

    public function updateImageByPoiId($poi_id)
    {
        $where = $this->getAdapter()->quoteInto('poi_id = ?',$poi_id);
        $data = array('poi_id' => null);
        $this->update($data,$where);
    }

    public function deleteImage($gallery_id)
    {
        $where = $this->getAdapter()->quoteInto('gallery_id = ?',$gallery_id);
        $this->delete($where);
    }
    
    public function getImageByIdLang($gallery_id,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('g' => $this->_name))
                  ->join(array('gd'=> 'gallerydesc'),'gd.gallery_id = g.gallery_id')
                  ->where('g.gallery_id = ?',$gallery_id)
                  ->where('gd.language_id = ?',$language_id);
        return $this->fetchRow($select);
    }
    
    /**
     * Fungsi untuk mengambil semua data yang merupakan image dari tabel gallery
     * @return array
     */
    public function getAllImage() {
        $data = $this->select()
                ->from($this->_name)
                ->where('type = 0');
        return $this->fetchAll($data);
    }
    
    public function getImageSource($gallery_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('source'))
                  ->where('gallery_id = ?',$gallery_id);
        $source = $this->fetchRow($select);
        return $source['source'];
    }
    
    public function getImageType($gallery_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('type'))
                  ->where('gallery_id = ?',$gallery_id);
        $source = $this->fetchRow($select);
        return $source['type'];
    }
    
    
    /**
     * Fungsi untuk mengambil semua data dari tabel gallery yang meruoakan image,
     * berdasarkan poi_id yang diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getImageSourceById($poi_id) {
        $query  = $this->select()
                ->from($this->_name, array('source'))
                ->where('type = 0 OR type = 1')
                ->where('poi_id = ?', $poi_id)
                ->limit(1, 0);
        $data = $this->fetchRow($query);

        return $data['source'];
    }

    /**
     * Fungsi untuk mendapatkan list gambar berdasarkan destinasi dan bahasa
     * Digunakan untuk menampilkan image gallery destinasi
     *
     * @param integer $poiId
     * @param integer $languageId
     * @return array
     */
    public function getAllImageGalleryByPoiId($poiId, $languageId = 1)
    {
        $query = $this->select()
                ->from(array('g' => $this->_name),
                  array('url' => 'g.source','gallery_id' => 'g.gallery_id'))
                ->join(array('gd' => 'gallerydesc'),
                  'gd.gallery_id = g.gallery_id',
                  array('name' => 'gd.name_language','description' => 'gd.desc_language'))
                ->setIntegrityCheck(FALSE)
                ->where('gd.language_id = ?', $languageId)
                ->where('g.poi_id = ?', $poiId);

        return $this->fetchAll($query);
    }

    /**
     * Fungsi untuk mengambil data source dari tabel eventdesc, name dan description
     * dari tabel gallery berdasarkan poi_id yang diberikan
     * @param integer $poi_id
     * @param integer $index
     * @return array
     * TODO: ga kepake lagi
     */
    /*public function getImagePoiByIndex($poi_id,$index)
    {   
        if($index>0)
        {
            $offsetIndex = $index-1;
            $offsetIndex = $offsetIndex*4;
        }
        $data = $this->select()
                ->from(array('g' => $this->_name),
                  array('url' => 'g.source','gallery_id' => 'g.gallery_id'))
                ->join(array('gd' => 'gallerydesc'),
                  'gd.gallery_id = g.gallery_id',
                  array('name' => 'gd.name_language','description' => 'gd.desc_language'))
                ->setIntegrityCheck(FALSE)
                ->where('gd.language_id = 1')
                ->where('g.poi_id = ?',$poi_id)
                ->limit(4,$offsetIndex);
        //echo $data->__toString();
        return $this->fetchAll($data,$offsetIndex);
    }*/
    
    /**
     * Fungsi untuk mendapatkan jumlah image yag ada di tabel gallery
     * @return array
     */
    /*public function getCountImage() {
        $data = 16;
        return $data;
    }*/

    /**
     * FUngsi untuk mendapatkan jumlah image berdasarkan poi_id yang diberikan
     * @param integer $poi_id
     * @return array
     */
    public function getCountImageByPoi($poi_id) {
        $data = $this->select()
                ->from($this->_name, array(" COUNT(source) as 'count' "))
                ->where('type = 0')
                ->where('poi_id = ?', $poi_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data image(name dan source) berdasarkan
     * poi_id yang diberikan
     * @param integer $poi_id
     * @return array
     */
    public function getAllImageByPoi($poi_id) {
        $count = $this->getCountImageByPoi($poi_id);
        $image = array();
        foreach ($count as $data)
        {
            $image[] = $data['name'.'source'];
        }
        return $image;
    }

    /**
     * Fungsi untuk mengambil map sebuah poi_id
     * @param integer $poi_id
     * @return array
     */
    public function getImageMapById($poi_id) {
        $data = array('source'=>'image map sebuah poi yang diambil berdasarkan poi_id');
        return $data;
    }

    /**
     * Fungsi untuk mendapatkan gallery_id terakhir dan yang merupakan image dari
     * tabel gallery
     *
     * @return array
     */
    public function getLastId() {
        $data = $this->select()
                ->from($this->_name, array('gallery_id'))
                ->where('type = 0')
                ->order('gallery_id DESC')
                ->limit(1, 0);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mendapatkan Main Image dari tabel gallaery
     * @param integer $poi_id
     * @return array
     */
    public function getMainImage($poi_id) {
        $data = $this->select()
                ->from($this->_name)
                ->where('type = 0')
                ->order('gallery_id ASC')
                ->limit(1, 0);
        return $this->fetchAll($data);
    }
	
	/**
     * Fungsi untuk mendapatkan Main Image dari tabel gallery
     * @param integer $poi_id
     * @return array
     */
    public function getMainImageSource($poi_id) {
        $data = $this->select()
                ->from($this->_name, array('source'))
                ->where('poi_id = ?', $poi_id)
                ->where('(type = 0')
                ->orWhere('type = 1)')
                ->order('gallery_id ASC');
                //echo $data;
        return $this->fetchRow($data);
    }

	/**
     * Fungsi untuk mendapatkan query untuk paginator
     * @param integer $filter, string $param, integer $language_id
     * @return object $select
     */
    public function getQueryAllByLang($filter = 0,$param = null,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('g' => $this->_name),array('gallery_id','poi_id','source','type'))
                  ->join(array('gd' => 'gallerydesc'),'gd.gallery_id = g.gallery_id',array('name_language'))
                  ->where('gd.language_id = 1')
                  ->order('g.gallery_id DESC');
        
        switch($filter)
        {
            case 1: $select->where("gd.name_language LIKE '%".$param."%'");
                    break;
            case 2: $select->join(array('pd' => 'poidescription'),'pd.poi_id = g.poi_id');
                    $select->where('pd.language_id = ?',$language_id);
                    $select->where("pd.name LIKE '%".$param."%'");
                    break;
        }
        return $select;
    }

	/**
     * Fungsi untuk mendapatkan 10 image terakhir dari tabel image
     * @return array
     */
     public function getTenLastImage($language_id = 1)
     {
     	$select = $this->select()
     			  ->setIntegrityCheck(FALSE)
     			  ->from(array('g' => $this->_name),array('source'))
     			  ->join(array('gd' => 'gallerydesc'), 'gd.gallery_id = g.gallery_id', array('gd.desc_language'))
				  ->where('gd.language_id = ?', $language_id)
				  ->order('g.gallery_id DESC')
     			  ->limit(15);
 		$result = $this->fetchAll($select);
 		if(sizeof($result) > 0)
 		{
 			return $result->toArray();
 		}
 		else
 		{
 			return null;
 		}
     }



    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -**/
    /* jul                                                                                                  */
    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -**/

    /*
        menampilakan hasil pencarian pada tabel event dan eventdesc berdasarkan
        parameter (kata kunci) yang di request
    
    */
    public function searchGallery($param, $limit=10, $offset=0, $lang_id)
    {
        
        $data = $this->select()
                ->from($this->_name,array('gallery_id','name','source','type'))
                //->where("{$this->_articleDesc}.language_id = ?",$lang_id)
                ->where("{$this->_name}.name like '%$param%'")
                ->limit($limit,$offset);
        return $this->fetchAll($data);
    }

    public function searchGalleryFix($param, $limit=10, $offset=0, $lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('gallery_id','name','source','type'))
                ->limit($limit,$offset);

        $key = explode(' ', $param);
        if(is_array($key))
        {
            $string = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%'";
                }
            }
            $query->where($string);
        }
        else
        {
            $query->where("{$this->_name}.name like '%$param%'");
        }
        
        $result = $this->fetchAll($query);
        
        if(count($result))
        {
            return $result;
            //return $result->toArray();    
        }
        else
        {
            return null;
        }

    }
    
    public function numbRowsGallery($param, $lang_id){
        $query = $this->select()
                ->from($this->_name,array('gallery_id','name','source','type'));
                //->limit($limit,$offset);

        $key = explode(' ', $param);
        if(is_array($key))
        {
            $string = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%'";
                }
            }
            $query->where($string);
        }
        else
        {
            $query->where("{$this->_name}.name like '%$param%'");
        }
        
        $result = $this->fetchAll($query);
        
        if(count($result))
        {
            return count($result);
            //return $result->toArray();    
        }
        else
        {
            return null;
        }

        //$data = $this->select()
        //        ->from($this->_name,array('gallery_id','name','source'))
        //        //->where("{$this->_articleDesc}.language_id = ?",$lang_id)
        //        ->where("{$this->_name}.name like '%$param%'");
        //
        //return count($this->fetchAll($data));        
    }

}

?>
