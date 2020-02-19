<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 07/05/2018
 * Time: 14:33
 */

namespace Iriven\Plugins\Form\Core\Interfaces;


interface AttributesBuilderInterface
{
    /**
     * @param array $attributes
     * @return $this
     */
    public function add(array $attributes);

    /**
     * @param $key
     * @return $this
     */
    public function createElementID($key);
    /**
     * @param $token
     * @return $this
     */
    public function createFormID($token = null);
    /**
     * @param $key
     * @return mixed
     */
    public function get($key);
    /**
     * @param $key
     * @return bool
     */
    public function has($key);
    /**
     * @param $ignore
     * @return $this
     */
    public function Ignore($ignore);
    /**
     * @param $key
     * @return $this
     */
    public function remove($key);
    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key,$value);

    /**
     * @return array
     */
    public function All();

    /**
     * @return bool|null|string
     */
    public function RenderHtml();
}