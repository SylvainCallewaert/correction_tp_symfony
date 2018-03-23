<?php
/**
 * Created by PhpStorm.
 * User: Formation
 * Date: 23/03/2018
 * Time: 14:56
 */

namespace AppBundle\Util;


class Util
{
    public function generateNumCommande($doctrine) {
        $numCommande = date('Ymd').rand(1, 5000);
        return $numCommande;
    }

    public function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}