<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 07/05/2018
 * Time: 10:34
 */

namespace Iriven\Plugins\Form\Core\Libs\Traits;


trait KeyNormalizer
{
    /**
     * @param $keys
     * @return bool|mixed|string
     */
    private function normalize($keys)
    {
        if(is_array($keys)) return false;
        foreach (array(' ', '&nbsp;', '\n', '\t', '\r', '"','\'','_') as $strip)
            $keys = str_replace($strip, '', (string) $keys);
        $keys = trim(preg_replace('/\W+/', '-', $keys), '-');
        $keys = strtolower(str_ireplace('input','',$keys));
        return $keys;
    }

    /**
     * @param callable $callable
     * @param array    $array
     * @return array
     */
    private function array_map_keys (callable $callable, array $array) : array
    {
        $map = [];
        foreach ($array as $key => $value)
        {
            $key = call_user_func($callable,$key);
            $map[$key] = $value;
        }
        return $map;
    }

}