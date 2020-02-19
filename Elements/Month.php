<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 18/05/2018
 * Time: 09:54
 */

namespace Iriven\Plugins\Form\Elements;


use \Iriven\Plugins\Form\Core\FormElement;

class Month extends FormElement
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','month');
        $this->Attributes()->set('pattern','\d{4}-\d{2}');
        $this->Attributes()->set('placeholder','YYYY-MM (e.g. ' . date('Y-m') . ')');
    }

}