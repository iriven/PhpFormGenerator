<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 16/05/2018
 * Time: 15:10
 */

namespace Iriven\Plugins\Form\Core;


use \Iriven\Plugins\Form\Core\Libs\AttributesBuilder;

class fieldsetGenerator
{
    private $attributes;
    private $legend;
    private $legendAttributes;
    private $isOpened = false;

    /**
     * fieldsetGenerator constructor.
     *
     * @param $attributes
     */
    public function __construct($attributes)
    {
        if(!$attributes instanceof AttributesBuilder)
            $attributes  = new AttributesBuilder($attributes);
        $this->attributes = $attributes;
        if($this->attributes->has('legend'))
        {
            $this->attributes->Ignore('legend');
            $this->legend = $this->attributes->get('legend');
            if($this->attributes->has('legend-attributes'))
            {
                $this->attributes->Ignore('legend-attributes');
                $this->legendAttributes = new AttributesBuilder($this->attributes->get('legend-attributes'));
            }
        }
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
    public function Open()
    {
        $html  = '<fieldset';
        $html .= $this->attributes->RenderHtml();
        $html .= '>';
        if($this->legend)
        {
            $html .= '<legend';
            if($this->legendAttributes instanceof AttributesBuilder)
            $html .= $this->legendAttributes->RenderHtml();
            $html .= '>';
            $html .= $this->legend;
            $html .= '</legend>';
        }
        $this->isOpened = true;
        return $html;
    }

    /**
     * @return string
     */
    public function Close()
    {
        $html  = '';
        if($this->isOpened)
            $html .= '</fieldset>';
        return $html;
    }

}