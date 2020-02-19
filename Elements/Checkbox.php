<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 17/05/2018
 * Time: 15:23
 */

namespace Iriven\Plugins\Form\Elements;


use \Iriven\Plugins\Form\Core\Interfaces\FormElementInterface;

class Checkbox extends Text
{
    protected $options;
    private $hiddenInput;

    /**
     * Checkbox constructor.
     * @param $label
     * @param array $options
     * @param array $attributes
     */
    public function __construct($label, array $options, array $attributes=[])
    {
        parent::__construct($label, $attributes);
        $this->options = $options;
        $this->Attributes()->set('type','checkbox');
    }

    /**
     * @return string
     */
    public function RenderHtml()
    {
        $html = '';
        if($this->Types()->has($this->Attributes()->get('type')))
        {
            if(!$this->Attributes()->has('id'))
                $this->Attributes()->createElementID($this->Attributes()->get('name',$this->label()->getItemID()));
            $this->label()->Attribute()->set('fieldtype',$this->Attributes()->get('type'));
            $this->label()->Attribute()->set('for',$this->Attributes()->get('id'));
            if(sizeof($this->options)<2)
            {
                if($this->Attributes()->get('value'))
                    $this->Attributes()->set('checked','checked');
                $this->Attributes()->set('value','1');
                $this->hiddenInput = new Hidden($this->Label(),['value'=>'0']);
            }
            if($this->hiddenInput instanceof FormElementInterface)
                return  parent::RenderHtml().$this->hiddenInput->RenderHtml();
            if($this->Attributes()->has('value'))
            {
                if(!is_array($this->Attributes()->get('value')))
                    $this->Attributes()->set('value',[$this->Attributes()->get('value')]);
            }
            else
                $this->Attributes()->set('value',[]);
            if(substr($this->Attributes()->get('name'), -2) !== '[]')
                $this->Attributes()->set('name',$this->Attributes()->get('name').'[]');
            $count = 0;
            $html .= $this->Label()->RenderHtml();
            $this->Attributes()->Ignore(['id', 'value', 'checked', 'required']);
            foreach($this->options as $index => $details)
            {
                $html .= '<label for="'.$this->Attributes()->get('id').'-'.$count.'">';
                $html .= '<input id="'.$this->Attributes()->get('id').'-'.$count.'"';
                $html .= ' value="'.$index.'"';
                $html .= $this->Attributes()->RenderHtml();
                if(in_array($index , $this->Attributes()->get('value'))) $html .= ' checked="checked"';
                $html .= ' >'.$details.'</label>';
                ++$count;
            }
        }
        return $html;
    }
}
