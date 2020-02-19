<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 09/05/2018
 * Time: 09:54
 */

namespace Iriven\Plugins\Form\Core;


use \Iriven\Plugins\Form\Core\Interfaces\FormInterface;
use \Iriven\Plugins\Form\Core\Libs\AttributesBuilder;

class form implements FormInterface
{
    private $attributes;
    private $Content = '';
    /**
     * form constructor.
     *
     * @param AttributesBuilder|array $attributes
     */
    public function __construct($attributes = [])
    {
        if(!$attributes instanceof AttributesBuilder)
            $attributes  = new AttributesBuilder($attributes);
        $this->attributes = $attributes;
        if(!$this->attributes->has('name'))
            $this->addName(date('Ymd H:i:s'));
        else
            $this->addName($this->attributes->get('name'));

        $this->attributes->set('type','form');

        if(!$this->attributes->has('enctype'))
        $this->attributes->set('enctype','application/x-www-form-urlencoded');

        if(!$this->attributes->has('method'))
        $this->attributes->set('method','post');

        if(!$this->attributes->has('action'))
            $this->attributes->set('action',$_SERVER['REQUEST_URI']);

        $this->attributes->set('autocomplete','off');

        $this->attributes->Ignore('form');
    }

    /**
     * @return AttributesBuilder
     */
    public function Attributes()
    {
        return $this->attributes;
    }
    /**
     * @param $token
     * @return $this
     */
    public function addName($token = null)
    {
        $token .= microtime(true);
        if(strpos($token,'form-')!==0)
            $token = 'form-'.$token;
        $this->attributes->set('name',md5($token));
        return  $this;
    }
    /**
     * @param $element
     * @return FormElement|string $this
     */
    public function append($element)
    {
        if($element instanceof FormElement)
            $this->Content .= $element->RenderHtml();
        else
            $this->Content .=  $element;
        return $this;
    }

    /**
     * @return string
     */
    public function RenderHtml(): string
    {
        if(strcasecmp($this->attributes->get('method'),'get') == 0)
            $this->attributes->remove('enctype');
        $html  = '<form';
        $html .= $this->attributes->RenderHtml();
        $html .= ' >';
        $html .= $this->Content;
        $html .= '</form>';
        return $html;
    }

}