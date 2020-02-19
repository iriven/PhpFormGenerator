<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/05/2018
 * Time: 20:48
 */

namespace Iriven\Plugins\Form\Elements;

class Date extends Text
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','date');
        $this->Attributes()->set('title','YYYY-dd-MM (e.g. ' . date('Y-m-d') . ')');
    }

}