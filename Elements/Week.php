<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 21/05/2018
 * Time: 09:00
 */

namespace Iriven\Plugins\Form\Elements;


class Week extends Text
{
    public function __construct($label, $attributes = [])
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','week');
    }

}