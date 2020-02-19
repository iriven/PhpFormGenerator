<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 07/05/2018
 * Time: 14:30
 */

namespace Iriven\Plugins\Form\Core\Interfaces;


interface LabelCreatorInterface
{
    public function Attribute();
    public function RenderHtml();
    public function getItem();
}