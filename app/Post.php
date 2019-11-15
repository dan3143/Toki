<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public static function format($string){
        $string = preg_replace('/\*\*(.*)\*\*/', '<b>$1</b>', $string);
        $string = preg_replace('/__(.*)__/', '<i>$1</i>', $string);
        $string = preg_replace('/\\[img src=\"(.*)\" (?:size="(.*)")?\](.*)\[\/img\]/', '<img src="$1" width="$2%" height="$2%" alt="$3">', $string);
        return strip_tags($string, '<b><i><img><br><div>');
    }
}
