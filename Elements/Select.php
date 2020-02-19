<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 18/05/2018
 * Time: 10:57
 */

namespace Iriven\Plugins\Form\Elements;


use \Iriven\Plugins\Form\Core\Libs\AttributesBuilder;

class Select extends Checkbox
{
    private $selected = false;

    /**
     * Select constructor.
     * @param $label
     * @param array $options
     * @param array $attributes
     */
    public function __construct($label, array $options, array $attributes =[])
    {
        parent::__construct($label, $options, $attributes);
        $this->Attributes()->set('type','select');
        $this->Attributes()->set('placeholder',$this->Attributes()->get('placeholder','Make a choise ...'));
        $this->Attributes()->Ignore('select');
    }
    /**
     * @return string
     */
    public function RenderHtml()
    {

        $html = '';
        $multiple=false;

        if (!$this->Attributes()->has('id'))
            $this->Attributes()->createElementID($this->Attributes()->get('name', $this->label()->getItemID()));
        $this->label()->Attribute()->set('fieldtype', $this->Attributes()->get('type'));
        $this->label()->Attribute()->set('for', $this->Attributes()->get('id'));


        if($this->Attributes()->has('value'))
        {
            if(!is_array($this->Attributes()->get('value')))
                $this->Attributes()->set('value',[$this->Attributes()->get('value')]);
        }
        else
            $this->Attributes()->set('value',[]);

        if($this->Attributes()->has('multiple') AND $this->Attributes()->get('multiple')==='multiple')
            $multiple=true;

        if($multiple)
        {   $this->Attributes()->set('size',$this->Attributes()->get('size',3));
            if(substr($this->Attributes()->get('name'), -2) !== '[]')
                $this->Attributes()->set('name',$this->Attributes()->get('name').'[]');
        }
        $html .= $this->Label()->RenderHtml();
        $this->Attributes()->Ignore(['value','selected','optgroup-attributes','option-attributes','placeholder']);

        $html .= '<select'.$this->Attributes()->RenderHtml().'>';
        if(empty($this->Attributes()->get('value')[0]) and $this->Attributes()->has('placeholder'))
            $html .= '<option value="" disabled selected>'.$this->Attributes()->get('placeholder').'</option>';

        foreach($this->options as $index=>$datas):

            if(is_array($datas))
                $html .= $this->createOptgroup($index,$datas);
            else
            {
                $optionAttr = null;
                if($this->Attributes()->has('option-attributes'))
                {
                    $oOption = new AttributesBuilder($this->Attributes()->get('option-attributes'));
                    $oOption->Ignore(['value','selected','placeholder']);
                    $oOption->set('type','option');
                    $optionAttr .= $oOption->RenderHtml();
                }
                $html .= '<option value="'.$index.'"';
                if(!$this->selected and in_array($index,$this->Attributes()->get('value')))
                {
                    $html .= ' selected="selected"';
                    $this->selected = true;
                }
                if($optionAttr) $html .= ' '.$optionAttr ;
                $html .= '>';
                $html .= $datas.'</option>';
            }
        endforeach;
        $html .= '</select>';
        return $html;
    }

    /**
     * @param string $label
     * @param array $options
     * @return string
     */
    private function createOptgroup($label,$options = [])
    {
        $groupAttr = null;
        $optionAttr = null;
        if($this->Attributes()->has('optgroup-attributes'))
        {
            $oGroup = new AttributesBuilder($this->Attributes()->get('optgroup-attributes'));
            $oGroup->set('type','optgroup');
            $oGroup->Ignore('label');
            $groupAttr .= $oGroup->RenderHtml();
        }
        if($this->Attributes()->has('option-attributes'))
        {
            $oOption = new AttributesBuilder($this->Attributes()->get('option-attributes'));
            $oOption->Ignore(['value','selected','placeholder']);
            $oOption->set('type','option');
            $optionAttr .= $oOption->RenderHtml();
        }
        $output='<optgroup label="'.$label.'"';
        if($groupAttr) $output .= ' '.$groupAttr ;
        $output .= '>';
        foreach($options as $key=>$optLabel)
        {
            if(is_array($optLabel))
                $output .= call_user_func_array([$this,__METHOD__],[$optLabel]);
            else
            {
                $output .= '<option value="'.$key.'"';
                if(!$this->selected and in_array($key,$this->Attributes()->get('value')))
                {
                    $output .= ' selected="selected"';
                    $this->selected = true;
                }
                if($optionAttr) $output .= ' '.$optionAttr ;
                $output .= '>';
                $output .= $optLabel.'</option>';
            }
        }
        $output.='</optgroup>';
        return$output;
        
    }
}