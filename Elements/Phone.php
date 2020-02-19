<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 18/05/2018
 * Time: 10:40
 */

namespace Iriven\Plugins\Form\Elements;


class Phone extends Text
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','tel');
    }

}