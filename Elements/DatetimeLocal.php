<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 18/05/2018
 * Time: 09:31
 */

namespace Iriven\Plugins\Form\Elements;


class DatetimeLocal extends Datetime
{
    public function __construct($label, $attributes)
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','datetime-local');
        $this->Attributes()->set('pattern','[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}');
        $this->Attributes()->set('placeholder','YYYY-dd-MMTHH:i(e.g. ' . date('Y-m-dTH:i') . ')');
    }

}