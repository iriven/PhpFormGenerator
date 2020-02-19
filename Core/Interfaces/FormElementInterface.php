<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 16/05/2018
 * Time: 11:35
 */

namespace Iriven\Plugins\Form\Core\Interfaces;


use \Iriven\Plugins\Form\Core\Libs\AttributesBuilder;

interface FormElementInterface
{
    /**
     * @return array|AttributesBuilder
     */
    public function Attributes();

    /**
     * @return string
     */
    public function RenderHtml();
}