<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/05/2018
 * Time: 16:45
 */

namespace Iriven\Plugins\Form\Elements;

class Email extends Text
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','email');
        $this->Attributes()->set('placeholder','mail@domain.com');
        $this->Attributes()->set('pattern','[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})');
    }

}