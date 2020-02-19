<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 21/05/2018
 * Time: 08:04
 */

namespace Iriven\Plugins\Form\Elements;


class Textarea extends Text
{
    public function __construct($label, $attributes = [])
    {
        parent::__construct($label, $attributes);
        $this->Attributes()->set('type','textarea');
        $this->Attributes()->set('rows',$this->Attributes()->get('rows',6));
        $this->Attributes()->set('cols',$this->Attributes()->get('cols',60));
        $this->Attributes()->Ignore('value');
        $this->Label()->Attribute()->add(['style'=>'vertical-align: top;']);
    }

    /**
     * @return string
     */
    public function RenderHtml(): string
    {
        if (!$this->Attributes()->has('id'))
            $this->Attributes()->createElementID($this->Attributes()->get('name', $this->label()->getItemID()));
        $this->label()->Attribute()->set('fieldtype', $this->Attributes()->get('type'));
        $this->label()->Attribute()->set('for', $this->Attributes()->get('id'));

        $html  = $this->Label()->RenderHtml();
        $html .= '<textarea'. $this->Attributes()->RenderHtml().'>';
        $html .= $this->Attributes()->get('value','');
        $html .= '</textarea>';
        return $html;
    }

}