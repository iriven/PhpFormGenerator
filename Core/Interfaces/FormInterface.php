<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 16/05/2018
 * Time: 11:35
 */

namespace Iriven\Plugins\Form\Core\Interfaces;


use \Iriven\Plugins\Form\Core\FormElement;
use \Iriven\Plugins\Form\Core\Libs\AttributesBuilder;

interface FormInterface
{
    /**
     * @return AttributesBuilder
     */
    public function Attributes();
    /**
     * @param $token
     * @return $this
     */
    public function addName($token = null);
    /**
     * @param $element
     * @return FormElement|string $this
     */
    public function append($element);

    /**
     * @return string
     */
    public function RenderHtml(): string;
}