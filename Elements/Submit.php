<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 19/05/2018
 * Time: 13:41
 */

namespace Iriven\Plugins\Form\Elements;


class Submit extends Button
{
    public function __construct($label, $attributes =[])
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','submit');
    }

}