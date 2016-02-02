<?php
/**
 * Model_Sorter
 * 
 * Kelas Model yang menangani pengambilan parameter untuk sorting.
 * Parameter untuk sorting berdasarkan nama kolom di tabel RAB
 * 
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Model_Sorter
{
    public function getSorter($titleSorter, $sortBy, $sortOrder)
    {
        return array(
            'sortby' => $titleSorter,
            'sortorder' =>
                ($sortBy == $titleSorter AND $sortOrder == 'asc')? 'desc' : 'asc',
            'page' => 1,
        );
    }
}