<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 16/05/2018
 * Time: 11:00
 */

namespace Iriven\Plugins\Form\Elements;


class Audio extends File
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('accept','audio/*');
    }

}