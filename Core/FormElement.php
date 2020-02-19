<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 07/05/2018
 * Time: 09:36
 */

namespace Iriven\Plugins\Form\Core;

use \Iriven\Plugins\Form\Core\Libs\Collection;
use \Iriven\Plugins\Form\Core\Interfaces\FormElementInterface;
use \Iriven\Plugins\Form\Core\Libs\AttributesBuilder;
use \Iriven\Plugins\Form\Core\Libs\Traits\KeyNormalizer;
use \Iriven\Plugins\Form\Core\Libs\LabelGenerator;

class FormElement implements FormElementInterface
{
    use KeyNormalizer;
    private   $label;
    protected $attributes;
    private   $Types;

    /**
     * FormElement constructor.
     * @param LabelGenerator|string $label
     * @param AttributesBuilder|array $attributes
     */
    public function __construct($label, $attributes=[])
    {
        if(!$label instanceof LabelGenerator)
            $label  = new LabelGenerator($label,[]);
        $this->label = $label;

        if(!$attributes instanceof AttributesBuilder)
            $attributes  = new AttributesBuilder($attributes);
        $this->attributes = $attributes;

        if(!$this->attributes->has('name'))
            $this->attributes->set('name',$this->normalize($this->label->getItem()));

        if(!$this->attributes->has('type'))
            $this->attributes->set('type','text');
        if (!$this->attributes->has('id'))
            $this->attributes->createElementID($this->attributes->get('name', $this->label->getItemID()));

        $this->attributes->set('autocomplete','off');

        $this->Types = new Collection(array_flip([
            'button',
            'checkbox',
            'color',
            'date',
            'datetime',
            'datetime-local',
            'email',
            'file',
            'hidden',
            'image',
            'month',
            'number',
            'password',
            'radio',
            'range',
            'reset',
            'search',
            'submit',
            'tel',
            'text',
            'time',
            'url',
            'week']));
    }

    /**
     * @return LabelGenerator|string
     */
    public function Label()
    {
        return $this->label;
    }

    /**
     * @return Collection
     */
    protected function Types()
    {
        return $this->Types;
    }
    /**
     * @return AttributesBuilder
     */
    public function Attributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function RenderHtml()
    {
        $html = '';
        if($this->Types->has($this->attributes->get('type')))
        {
            $this->label->Attribute()->set('fieldtype',$this->attributes->get('type'));
            $this->label->Attribute()->set('for',$this->attributes->get('id'));

            $html .= $this->Label()->RenderHtml();
            $html .= '<input';
            $html .= $this->attributes->RenderHtml();
            $html .= ' >';
        }
        return $html;
    }

}
