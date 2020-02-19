<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 16/05/2018
 * Time: 11:05
 */

namespace Iriven\Plugins\Form\Elements;

use \Iriven\Plugins\Form\Core\Libs\LabelGenerator;

class Button extends Text
{
    public function __construct($label, $attributes=[])
    {
        parent::__construct($label, $attributes);

        $this->Attributes()->set('type','button');
        $this->Attributes()->set('value',(!$label instanceof LabelGenerator)? $label : $label->getItem());
    }

}