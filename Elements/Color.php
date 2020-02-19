<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 18/05/2018
 * Time: 09:11
 */

namespace Iriven\Plugins\Form\Elements;


use \Iriven\Plugins\Form\Core\FormElement;

class Color extends FormElement
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','color');
        $this->Attributes()->set('title','6-digit hexidecimal color (e.g. #000000)');
        $this->Attributes()->set('pattern','#[a-g0-9]{6}');
    }

}