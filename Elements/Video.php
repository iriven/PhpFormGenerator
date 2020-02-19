<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 17/05/2018
 * Time: 13:17
 */

namespace Iriven\Plugins\Form\Elements;


class Video extends File
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('accept','video/*');
    }

}