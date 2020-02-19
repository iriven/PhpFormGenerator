<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 21/05/2018
 * Time: 09:03
 */

namespace Iriven\Plugins\Form\Elements;


class YesNo extends Radio
{
    public function __construct($label, $attributes=[])
    {
        $options = [
            '1' => 'Yes',
            '0' => 'No'
        ];
        parent::__construct($label, $options, $attributes);
    }

}