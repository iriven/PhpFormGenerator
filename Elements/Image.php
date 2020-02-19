<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/05/2018
 * Time: 20:43
 */

namespace Iriven\Plugins\Form\Elements;


class Image extends File
{
    /**
     * Image constructor.
     * @param $label
     * @param $attributes
     */
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('accept','image/*');
    }

}