<?php
/**
 * Budpar_Custom_Common
 *
 * Merupakan kelas untuk mendefinisikan fungsi2 yang digunakan di helper namun
 * digunakan pula di model
 *
 * @package Budpar Library Custom
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Budpar_Custom_Common
{
    /**
     * Fungsi truncate
     *
     * @param string $fullcontent
     * @param integer $character batasan karakter yg mau di-truncate
     *
     * @return string hasil yang sudah di-truncate
     */
    public function truncate($fullcontent, $character = 85)
    {
        $maxlength = $character;

        // Bersihkan ul li
        $fullcontent = preg_replace("/<li>/", "", $fullcontent);
        $fullcontent = preg_replace("/<\/li>/", ", ", $fullcontent);
        $fullcontent = preg_replace("/<ul>/", " ", $fullcontent);
        $fullcontent = preg_replace("/, <\/ul>/", ". ", $fullcontent);

        // Bersihkan tag HTML yg lain
        $content = strip_tags($fullcontent);

        $length = strlen($content);

        if ($length > $maxlength) {
            if (($content[$maxlength] == " ") OR ($content[$maxlength] == ",")
                    OR ($content[$maxlength] == ".")
                    OR ($content[$maxlength] == ";")
                    OR ($content[$maxlength] == ":")) {

                $content = substr($content, 0, $maxlength);
                if ($maxlength != ($length - 1)) {
                    $content .= "...";
                }
            }
            else {
                for ($i = $maxlength; $i > 0; $i--) {
                    if (($content[$i] == " ") OR ($content[$i] == ",")
                            OR ($content[$i] == ".")
                            OR ($content[$i] == ";")
                            OR ($content[$i] == ":")) {

                        $content = substr($content, 0, $i);
                        if ($i != ($length - 1)) {
                            $content .= "...";
                        }
                        break;
                    }
                    }
            }
        }

        return $content;
    }

    /**
     * Fungsi untuk membuat format Url
     * @param string $string
     * @return string
     */
    public function makeUrlFormat($string)
    {
        $string = strtolower($string);

        $pattern[1] = "/\s/"; // karakter spasi
        $pattern[2] = "/[^A-Za-z0-9]/"; //karakter bukan huruf dan angka
        $pattern[3] = "/-+-/"; // dua karakter "-" berurutan
        $pattern[4] = "/-$/"; // karakter "-" yg terletak di belakang kalimat

        $replace[1] = "-";
        $replace[2] = "-";
        $replace[3] = "-";
        $replace[4] = "";

        $result = preg_replace($pattern, $replace, $string);

        return trim($result);
    }

    /**
     * Fungsi untuk html decode
     */
    public function htmlDecode($string, $mode = 1)
    {
        $option = array('quote_style' => ENT_QUOTES, 'charset' => 'UTF-8');

        if($mode == 1)
            return htmlspecialchars_decode($string, $option['quote_style']);
        elseif($mode == 2)
            return html_entity_decode($string, $option['quote_style'], $option['charset']);
    }
    
}