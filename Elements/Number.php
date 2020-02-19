<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 18/05/2018
 * Time: 10:00
 */

namespace Iriven\Plugins\Form\Elements;


use \Iriven\Plugins\Form\Core\FormElement;

class Number extends FormElement
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);

        $this->attributes->set('type','number');

        if(!$this->attributes->has('min'))
            $this->attributes->set('min','0');

        if(!$this->attributes->has('max'))
            $this->attributes->set('max','100');

        if(!$this->attributes->has('step'))
            $this->attributes->set('step','1');
    }

}