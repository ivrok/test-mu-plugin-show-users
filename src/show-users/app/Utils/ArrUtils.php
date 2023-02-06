<?php

namespace Ivrok\ShowUsers\Utils;

class ArrUtils
{
    public static function recursiveImplode($sep, $arr)
    {
        $res = '';

        $index = 0;
        foreach ($arr as $el) {
            if (is_array($el)) {
                $el = static::recursiveImplode($sep, $el);
            }

            if ($index) {
                $res .= $sep;
            }

            $res .= $el;

            $index++;
        }

        return $res;
    }
}
