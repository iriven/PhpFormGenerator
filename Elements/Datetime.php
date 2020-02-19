<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/05/2018
 * Time: 20:50
 */

namespace Iriven\Plugins\Form\Elements;

class Datetime extends Text
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','datetime');
        $this->Attributes()->set('placeholder','YYYY-dd-MM H:i:s(e.g. ' . date('Y-m-d H:i:s') . ')');
    }

}