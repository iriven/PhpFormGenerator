<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/05/2018
 * Time: 15:17
 */

namespace Iriven\Plugins\Form\Elements;


use \Iriven\Plugins\Form\Core\FormElement;
use \Iriven\Plugins\Form\Core\Libs\AttributesBuilder;
use \Iriven\Plugins\Form\Core\Libs\LabelGenerator;

class Text extends FormElement
{
    /**
     * Text constructor.
     * @param LabelGenerator|string $label
     * @param AttributesBuilder|array $attributes
     */
    public function __construct($label, $attributes=[])
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','text');
    }

}