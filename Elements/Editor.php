<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 21/05/2018
 * Time: 08:39
 */

namespace Iriven\Plugins\Form\Elements;


class Editor extends Textarea
{
    public function __construct($label, $attributes = [])
    {
        parent::__construct($label, $attributes);
        $class = $this->Attributes()->get('class','');
        $this->Attributes()->set('class',$class? $class.' editor':'editor');
    }

}