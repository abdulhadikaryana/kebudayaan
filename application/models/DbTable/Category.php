<?php

/**

 * Model_DbTable_Category

 *

 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan

 * tabel category

 *

 * @package DbTable Model

 */
class Model_DbTable_Category extends Zend_Db_Table_Abstract {

    protected $_name = 'category';
    protected $_cattopoi = 'categorytopoi';
    protected $_catdes = 'categorydescription';
    protected $_poi = 'poi';

    public function insertCategory($input) {

        $this->insert($input);

        return $this->_db->lastInsertId();
    }

    public function updateCategory($input, $category_id) {

        $where = $this->getAdapter()->quoteInto('category_id = ?', $category_id);

        $this->update($input, $where);
    }

    public function deleteCategory($category_id) {

        $where = $this->getAdapter()->quoteInto('category_id = ?', $category_id);

        $this->delete($where);
    }

    /**

     * Fungsi untuk mengambil semua data dari tabel category

     * 

     * @return array

     */
    public function getAll() {

        $data = $this->select()
                ->from($this->_name);

        return $this->fetchAll($data);
    }

    /**

     * Fungsi untuk mengambil semua data dari tabel category berdasarkan

     * category_id yang diberikan

     * 

     * @param integer $category_id

     * @return array

     */
    public function getAllById($category_id) {

        $data = $this->select()
                ->from($this->_name)
                ->where('category_id = ?', $category_id);

        return $this->fetchAll($data);
    }

    public function getQueryAllBylanguage($filter = null, $param = null, $language_id = 1) {

        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('c' => $this->_name), array('c.category_id'))
                ->join(array('cd' => $this->_catdes), 'cd.category_id = c.category_id', array('cd.name'))
                ->where('cd.language_id = ?', $language_id);



        if (isset($filter)) {

            switch ($filter) {

                case 1 : $select->where("cd.name LIKE '%" . $param . "%'");

                    break;

                case 2 : $select->where("c.parent_id = ?", $param);

                    break;
            }
        }

        $select->order('category_id DESC');

        return $select;
    }

    public function getAllWithDescByIdLang($category_id, $language_id = 1) {

        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('c' => $this->_name))
                ->join(array('cd' => $this->_catdes), 'c.category_id = cd.category_id')
                ->where('c.category_id = ?', $category_id)
                ->where('cd.language_id = ?', $language_id);

        return $this->fetchRow($select);
    }

    public function getAllCategoryIdNameByLangId($language_id = 1) {

        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('cat' => $this->_name), array('category_id'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name'))
                ->where('catdes.language_id = ?', $language_id)
                ->where('cat.parent_id > 0')
                ->order('catdes.name');

        return $this->fetchAll($select);
    }

    public function getAllCategoryIdNameByLangIdForSelect($language_id, $title = '') {

        $categories = $this->getAllCategoryIdNameByLangId($language_id);



        $data = array("" => "--" . $title . "--");

        foreach ($categories as $row) {

            $data[$row['category_id']] = $row['name'];
        }



        return $data;
    }

    public function getAllParentCategoryIdNameByLangId($language_id) {

        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('category_id'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name'))
                ->where('catdes.language_id = ?', $language_id)
                ->where('cat.parent_id = 0');

        return $this->fetchAll($select);
    }

    /**

     * Fungsi untuk mengambil data category_id dari tabel category dan name dari

     * categorydesc berdasarkan language_id yang diberikan dan mempunyai

     * parent_id = 0

     * 

     * @param integer $language_id

     * @return array

     */
    public function getAllParentIdNameForSelectByLangId($language_id = 1, $use_top = FALSE, $prefix = '', $use_default = FALSE) {

        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('category_id'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name'))
                ->where('catdes.language_id = ?', $language_id)
                ->where('cat.parent_id = 0');

        $data = $this->fetchAll($select);

        if (($use_top) || ($use_default)) {

            if ($use_top) {

                $category_value[0] = 'Top Category';
            }

            if ($use_default) {

                $category_value[0] = 'Select Category';
            }
        }

        foreach ($data as $temp_category) {

            $category_value[$temp_category['category_id']] = $prefix . $temp_category['name'];
        }



        $category = array("multiOptions" => $category_value);

        return $category;
    }

    public function getAllParentIdNameForSelectByLangIdIndo($language_id = 2, $use_top = FALSE, $prefix = '', $use_default = FALSE) {

        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('category_id'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name'))
                ->where('catdes.language_id = ?', $language_id)
                ->where('cat.parent_id = 0');

        $data = $this->fetchAll($select);

        if (($use_top) || ($use_default)) {

            if ($use_top) {

                $category_value[0] = 'Top Category';
            }

            if ($use_default) {

                $category_value[0] = 'Pilih Kategori';
            }
        }

        foreach ($data as $temp_category) {

            $category_value[$temp_category['category_id']] = $prefix . $temp_category['name'];
        }



        $category = array("multiOptions" => $category_value);

        return $category;
    }

    public function getAllParentIdImageName($languageId) {

        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('category_id', 'image'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name'))
                ->where('catdes.language_id = ?', $languageId)
                ->where('cat.parent_id = 0');

        $data = $this->fetchAll($select);

        return $data;
    }

    public function getCategoryChildList($parentId = 1, $languageId = 1) {

        $query = $this->select()
                ->from($this->_name, array('category_id', 'image'))
                ->join($this->_catdes, "{$this->_name}.category_id = {$this->_catdes}.category_id", array('name', 'description'))
                ->setIntegrityCheck(false)
                ->where("{$this->_name}.parent_id = ?", $parentId)
                ->where("{$this->_catdes}.language_id = ?", $languageId);

        $data = $this->fetchAll($query);

        return $data;
    }

    public function getCategoryChildListForForm($parentId, $languageId) {

        $childList = $this->getCategoryChildList($parentId, $languageId);



        $child = array();

        foreach ($childList as $row) {

            $child[] = $row['category_id'];
        }



        return $child;
    }

    public function getListCategory($languageId) {

        $data1 = $this->getAllParentIdImageName($languageId)->toArray();

        $listCategory = array();

        foreach ($data1 as $counter => $row) {

            $listCategory[$counter]['image'] = $row['image'];

            $listCategory[$counter]['category_id'] = $row['category_id'];

            $listCategory[$counter]['name'] = $row['name'];

            $listCategory[$counter]['child'] = $this->getCategoryChildList($row['category_id'], $languageId)->toArray();
        }

        return $listCategory;
    }

    public function getChildCategoriesWithCounter($languageId) {

        $query = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('cat' => $this->_name), array('category_id', 'image'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name'))
                ->join(array('poi' => $this->_poi), 'cat.category_id = poi.main_category', array('COUNT(poi.poi_id) AS total_culture'))
                ->where('catdes.language_id = ?', $languageId)
                ->where('cat.parent_id > 0')
                ->group('cat.category_id')
                ->order('catdes.name');



        $data = $this->fetchAll($query);

        return $data;
    }

    public function randomCategory($limitRandom, $languageId) {

        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('category_id', 'image'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name', 'description'))
                ->where('catdes.language_id = ?', $languageId)
                ->where('cat.parent_id <> 0')
                ->order('RAND()')
                ->limit($limitRandom, 0);





        $data = $this->fetchAll($select);

        return $data;
    }

    public function getAllChildIdNameByParentIdLangId($parent_id = null, $language_id = 1) {

        if ($parent_id == null) {

            $parent_id = $this->getfirstCategoryId();

            $parent_id = $parent_id[0]['category_id'];
        }

        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('category_id'))
                ->join(array('catdes' => $this->_catdes), 'cat.category_id = catdes.category_id', array('name'))
                ->where('catdes.language_id = ?', $language_id)
                ->where('cat.parent_id = ?', $parent_id);

        $data = $this->fetchAll($select);

        foreach ($data as $temp_category) {

            $category_value[$temp_category['category_id']] = $temp_category['name'];
        }



        $category = array("multiOptions" => $category_value);

        return $category;

//        /echo $select->__toString();/
    }

    public function getfirstCategoryId() {

        $select = $this->select()
                ->from($this->_name, array('category_id'))
                ->order('category_id ASC')
                ->limit(1);

        return $this->fetchAll($select);
    }

    public function getAllButNotMainCategory($lang_id = 1) {

        $query = $this->select()
                ->from($this->_name, array('parent_id', 'image'))
                ->setIntegrityCheck(false)
                ->join($this->_catdes, "{$this->_catdes}.category_id = {$this->_name}.category_id")
                ->where("{$this->_catdes}.language_id = ?", $lang_id)
                ->where("{$this->_name}.parent_id != 0")
                ->order("{$this->_catdes}.name ASC");

        //echo $query->__toString();

        return $this->fetchAll($query);
    }

    /**

     * Fungsi untuk mendapatkan kategori yang bukan main category disertai dengan

     * jumlah culture yang terdapat dalam kategori tersebut

     * 

     * @param int $lang_id

     * @return Object

     */
    public function getAllButNotMainCategoryWithCounter($lang_id = 1) {

        $query = $this->select()
                ->from($this->_name, array('parent_id', 'image'))
                ->setIntegrityCheck(false)
                ->join($this->_catdes, "{$this->_catdes}.category_id = {$this->_name}.category_id")
                ->joinLeft(array('poi' => $this->_poi), "{$this->_name}.category_id = poi.main_category", array('COUNT(poi.poi_id) AS total_culture'))
                ->where("{$this->_catdes}.language_id = ?", $lang_id)
                ->where("{$this->_name}.parent_id != 0")
                ->where("poi.status = ?", Model_DbTable_Destination::PUBLISH)
                ->group("{$this->_name}.category_id")
                ->order("{$this->_catdes}.name ASC");



        return $this->fetchAll($query);
    }

    /**

     * Fungsi getAllButNotMainCategory untuk form select

     * 

     * @param integer $langId language

     * @return array

     */
    public function getAllButNotMainCategoryForForm($langId) {

        $category = $this->getAllButNotMainCategory($langId);



        $categoryValue[0] = "---Select Activities---";

        foreach ($category as $tempCategory) {



            $categoryValue[$tempCategory['category_id']] = $tempCategory['name'];
        }



        return $categoryValue;
    }

    public function getAllButNotMainCategoryWithCache($lang) {

        // set up cache

        $cache = Zend_Registry::get('cache');



        $categories = null;



        // dibedakan key cache tiap bahasa

        $key = 'categories_' . $lang;

        // cek apakah categori disimpan di dalam cache
        // jika belum simpan disana

        if (!($categories = $cache->load($key))) {

            $categories = $this->getAllButNotMainCategory($lang);

            $cache->save($categories, $key);
        }



        return $categories;
    }

    public function getparentCategoryId($category_id) {

        $select = $this->select()
                ->from(array('cat' => $this->_name), array('parent_id'))
                ->where('cat.category_id = ?', $category_id);

        $parent_id = $this->fetchRow($select)->toArray();

        return $parent_id['parent_id'];
    }

    public function getAllByLanguage($lang = 1) {

        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('parent_id', 'image'))
                ->join($this->_catdes, "{$this->_catdes}.category_id = {$this->_name}.category_id", array('name', 'category_id'))
                ->where("{$this->_catdes}.language_id = ?", $lang);

        return $this->fetchAll($query);
    }

    public function getByLangAndId($categoryId, $langId) {

        $query = $this->select()
                ->from($this->_name, array('category_id', 'image'))
                ->setIntegrityCheck(false)
                ->join($this->_catdes, "{$this->_name}.category_id = {$this->_catdes}.category_id", array('name', 'description'))
                ->join(array('parent' => $this->_catdes), "parent.category_id = {$this->_name}.parent_id", array('parent_name' => 'parent.name', 'parent_id' => 'parent.category_id'))
                ->where("{$this->_catdes}.language_id = ?", $langId)
                ->where('parent.language_id = ?', $langId)
                ->where("{$this->_name}.category_id = ?", $categoryId);

        $result = $this->fetchRow($query)->toArray();
        return $result;
    }

    /**

     * Fungsi untuk mendapatkan jumlah culture yang tergabung dalam main category

     * termasuk yang di dalam sub category-nya. Dengan asumsi hanya sampai

     * dua kedalaman level category. 

     * 

     * @param int $lang_id

     * @return Object

     */
    public function getMainCategoriesWithCounter($lang_id = 1) {

        $query = $this->select()
                ->from($this->_name, array('category_id', 'image'))
                ->setIntegrityCheck(false)
                ->join($this->_catdes, "{$this->_catdes}.category_id = {$this->_name}.category_id", array('name'))
                ->joinLeft(array('cat2' => $this->_name), "cat2.parent_id = {$this->_name}.category_id", array())
                ->joinLeft(array('poi' => $this->_poi), "{$this->_name}.category_id = poi.main_category OR cat2.category_id = poi.main_category", array('COUNT(DISTINCT(poi.poi_id)) AS total_culture'))
                ->where("{$this->_catdes}.language_id = ?", $lang_id)
                ->where("{$this->_name}.parent_id = 0")
                ->where("poi.status = ?", Model_DbTable_Destination::PUBLISH)
                ->group("{$this->_name}.category_id")
                ->order("{$this->_catdes}.name ASC");



        return $this->fetchAll($query);
    }

    /**

     * Fungsi untuk mendapatkan jumlah culture yang tergabung dalam sub category

     * 

     * @param int $parent_id parent category

     * @param int $lang_id

     * @return Object

     */
    public function getSubCategoriesWithCounter($parent_id = 1, $lang_id = 1) {

        $query = $this->select()
                ->from($this->_name, array('category_id', 'image'))
                ->setIntegrityCheck(false)
                ->join($this->_catdes, "{$this->_catdes}.category_id = {$this->_name}.category_id", array('name'))
                ->joinLeft(array('poi' => $this->_poi), "{$this->_name}.category_id = poi.main_category", array('COUNT(DISTINCT(poi.poi_id)) AS total_culture'))
                ->where("{$this->_catdes}.language_id = ?", $lang_id)
                ->where("{$this->_name}.parent_id = ?", $parent_id)
                ->where("poi.status = ?", Model_DbTable_Destination::PUBLISH)
                ->group("{$this->_name}.category_id")
                ->order("{$this->_catdes}.name ASC");



        return $this->fetchAll($query);
    }

    public function getCategories() {

        $select = $this->select()
                ->from($this->_name, array('category_id', 'name'))
                ->where("parent_id = ?", 0);

        $categories = $this->getAdapter()->fetchPairs($select);

        $categories = $this->getAdapter()->fetchPairs($select);



        $result = array();

        foreach ($categories as $id => $category) {

            $result[$category] = $this->getSubCategories($id);
        }



        return $result;
    }

    public function getSubCategories($parent_id) {

        $select = $this->select()
                ->from($this->_name, array('category_id', 'name'))
                ->where("parent_id = ?", $parent_id);



        $subcategories = $this->getAdapter()->fetchPairs($select);

        return $subcategories;
    }

}
?>

