<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 17/05/2018
 * Time: 16:17
 */

namespace Iriven\Plugins\Form\Elements;


class Radio extends Checkbox
{
    /**
     * Radio constructor.
     * @param $label
     * @param array $options
     * @param array $attributes
     */
    public function __construct($label, array $options, array $attributes=[])
    {
        parent::__construct($label, $options, $attributes);
        $this->Attributes()->set('type','radio');
    }

}