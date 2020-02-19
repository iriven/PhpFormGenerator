<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 07/05/2018
 * Time: 09:34
 */

namespace Iriven\Plugins\Form\Core\Libs;

use \Iriven\Plugins\Form\Core\Interfaces\AttributesBuilderInterface;
use \Iriven\Plugins\Form\Core\Libs\Traits\KeyNormalizer;

class AttributesBuilder implements AttributesBuilderInterface
{
    use KeyNormalizer;

    private $attributes;
    private $ignore ;

    /**
     * AttributesBuilder constructor.
     *
     * @param array $attributes
     * @param array $ignore
     */
    public function __construct(array $attributes, $ignore = [])
    {
        $this->attributes    = new Collection();
        $this->ignore        = new Collection();
        if(!empty($attributes))
        {
            is_array($attributes) or $attributes = array($attributes);
            $attributes = array_change_key_case($attributes,CASE_LOWER);
            $attributes = $this->array_map_keys([$this,'normalize'],$attributes);
            $this->attributes->add($attributes);
        }
        if(!empty($ignore))
        {
            is_array($ignore) or $ignore = array($ignore);
            $ignore = array_map([$this,'normalize'],$ignore);
            $this->ignore->add($ignore);
        }
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function createElementID($key)
    {
        $key = ucfirst($this->normalize($key));
        if(strpos($key,'input')!==0)
            $key = 'input'.$key;
        $this->set('id',$key);
        return  $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function createFormID($token = null)
    {
        $token or $token = microtime(true);
        $token = $this->normalize($token);
        if(strpos($token,'form-')!==0)
            $token = 'form-'.$token;
        $this->set('name',md5($token));
        return  $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function add(array $attributes)
    {
        is_array($attributes) or $attributes = array($attributes);
        $attributes = $this->array_map_keys([$this,'normalize'],$attributes);
        $this->attributes->add($attributes);
        return $this;
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key,$default=null)
    {
        $key = $this->normalize($key);
        return $this->attributes->get($key,$default);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        $key = $this->normalize($key);
        return $this->attributes->has($key);
    }
    /**
     * @param $ignore
     * @return $this
     */
    public function Ignore($ignore)
    {
        is_array($ignore) or $ignore = array($ignore);
        $ignore = array_merge($this->ignore->all(), array_map([$this,'normalize'],$ignore));
        $this->ignore->replace($ignore);
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function remove($key)
    {
        $key = $this->normalize($key);
        $this->attributes->remove($key);
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key,$value)
    {
        $key = $this->normalize($key);
        $this->attributes->set($key,$value);
        return $this;
    }

    /**
     * @return array
     */
    public function All()
    {
        return $this->attributes->all();
    }

    /**
     * @return bool|null|string
     */
    public function RenderHtml()
    {
        $output = [];
        if($attributes = $this->attributes->all())
        {
            AttributesMapper::filter($this);
            $filtered = array_keys($attributes);
            if($ignore = $this->ignore->all())
                $filtered = array_diff($filtered, $ignore);
            $attributes = array_intersect_key($attributes, array_flip($filtered));
            foreach($attributes as $key=>$value)
            {
                if(is_array($value)):
                    $output[]= $key.'="'.implode(' ',array_values($value)).'"';
                else:
                    if(is_numeric($key)) $output[]= $value;
                    else $output[]= $key.'="'.$value.'"';
                endif;
            }
        }
        return count($output) ? ' ' . implode(' ', $output) : '';
    }
}
