<?php
/**
 * Model_Category
 *
 * Model untuk melakukan fungsi2 yang berkaitan dengan
 * category
 *
 * @package Model
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Model_Category extends Budpar_Model_Common
{
    private $_categoriesAll;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fungsi untuk mendapatkan kategori dalam bentuk hierarki
     * @return type 
     */
    public function getAllHierarchyByLanguage()
    {
        // Model
        $categoryDb = new Model_DbTable_Category;
        
        // query category
        $categoryParent = $categoryDb->getAllParentCategoryIdNameByLangId($this->_languageId);
        $categoryChildren = $categoryDb->getAllButNotMainCategoryWithCounter($this->_languageId);
        
        // should be converted to array
        $categoryParent = $categoryParent->toArray();
        $categoryChildren = $categoryChildren->toArray();
        
        $hierarchyCategory = $this->buildCategoryHierarchy($categoryParent, $categoryChildren);
        
        return $hierarchyCategory;
    }
    
    /**
     * Fungsi untuk membangun hierarki dari kategori
     * @param array $categoryParent kategori yang termasuk parent
     * @param array $categoryChildren kategori yang termasuk children
     * @return array kategori dalam bentuk hirarki
     */
    private function buildCategoryHierarchy($categoryParent, $categoryChildren) {
        $result = array();
        foreach($categoryParent as $catParent) {     
            foreach($categoryChildren as $catChild) {
                if($catChild['parent_id'] == $catParent['category_id']) {
                    $catParent['children'][] = $catChild;
                }
            }
            $result[] = $catParent;
        }       
        
        return $result;
    }
    
    /**
     * Fungsi untuk menampilkan data kategori utama ke chart
     * 
     * @param int $language_id
     * @return array
     */
    public function getMainCategoriesForChart($language_id) {
        $categoryDb = new Model_DbTable_Category;
        $categories = $categoryDb->getMainCategoriesWithCounter($language_id)->toArray();
                        
        $result = array();        
        foreach($categories as $category) {
            $result['category'][] = $category['name'];
            $result['total'][] = array('', (int)$category['total_culture'], 
                '/category/see-category/' . $category['category_id']);
        }
                       
        return $result;
    }
    
    /**
     * Fungsi untuk menampilkan data sub kategori berdasarkan parent kategori
     * 
     * @param int $parent_id
     * @param int $language_id
     * @return array
     */
    public function getSubCategoriesForChart($parent_id, $language_id) {
        $categoryDb = new Model_DbTable_Category;
        $categories = $categoryDb->getSubCategoriesWithCounter($parent_id, $language_id)->toArray();
                        
        $result = array();        
        foreach($categories as $category) {
            $result['category'][] = $category['name'];
            $result['total'][] = array('', (int)$category['total_culture'], 
                '/category/' . $parent_id . '/detail/' . $category['category_id']);
        }
                       
        return $result;
    }                

    // Kepake
    public function getAllForMap($languageId)
    {
        $categoryDb = new Model_DbTable_Category;

        //$categoriesAll = $this->getAllByLanguageForMap();
        $categories = $categoryDb->getAllButNotMainCategoryWithCache(
            $languageId);

        $categoriesInfo = array();
        
        foreach($categories as $category) {

            $parentId = $category['parent_id'];
            $categoriesInfo[$category['category_id']] = array();
            $categoriesInfo[$category['category_id']]['name'] = $category['name'];
            $categoriesInfo[$category['category_id']]['image'] = $category['image'];
            $categoriesInfo[$category['category_id']]['status'] = false;
            $categoriesInfo[$category['category_id']]['parent_id'] = $parentId;
            $categoriesInfo[$category['category_id']]['parent_image'] = $categoriesAll[$parentId]['info']['image'];
        }

        //$this->_categoriesAll = $categoriesAll;

        return json_encode($categoriesInfo);
    }

    public function getCategoriesAll()
    {
        return $this->_categoriesAll;
    }


}
?>
