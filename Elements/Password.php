<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 18/05/2018
 * Time: 10:33
 */

namespace Iriven\Plugins\Form\Elements;


class Password extends Text
{
    public function __construct($label, $attributes=[])
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','password');
        $this->Attributes()->set('minlength','6');
        $this->Attributes()->set('maxlength','64');
        $this->Attributes()->set('required','required');
        $this->Attributes()->set('placeholder','**********');
    }

}