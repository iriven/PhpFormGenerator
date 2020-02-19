<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 07/05/2018
 * Time: 09:33
 */

namespace Iriven\Plugins\Form\Core\Libs;


use \Iriven\Plugins\Form\Core\Interfaces\LabelCreatorInterface;
use \Iriven\Plugins\Form\Core\Libs\Traits\KeyNormalizer;

class LabelGenerator implements LabelCreatorInterface
{
    use KeyNormalizer;
    private $item;
    private $attributes;

    /**
     * LabelGenerator constructor.
     *
     * @param string                      $item
     * @param AttributesBuilder|array $attributes
     */
    public function __construct(string $item, $attributes=[])
    {
        $this->item = $item;
        if(!$attributes instanceof AttributesBuilder)
            $attributes  = new AttributesBuilder($attributes);
        $this->attributes = $attributes;
        $this->attributes->set('type','label');
            return $this;
    }

    /**
     * @return AttributesBuilder
     */
    public function Attribute()
    {
        return $this->attributes;
    }

    /**
     * @return bool|mixed|string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return mixed
     */
    public function getItemID()
    {

        if(!$this->attributes->has('for'))
        {
            $this->attributes->createElementID($this->item);
            $id = $this->attributes->get('id');
            $this->attributes->set('for',$id);
            return $id;
        }
        return $this->attributes->get('for');
    }
    /**
     * @return string
     */
    public function RenderHtml()
    {
        $this->attributes->Ignore(['id','label','type']);
        $label =  null;
        $type = $this->attributes->get('fieldtype');
        $this->attributes->set('for',$this->attributes->get('for',$this->attributes->get('id')));
        switch ($type):
            case 'hidden':
            case 'submit':
            case 'reset':
            case 'button':
                break;
            default:
                $label .= '<label'.$this->attributes->RenderHtml().'>';
                $label .= htmlspecialchars(trim($this->item,': '),ENT_COMPAT,'UTF-8');
                // $label .= $this->RenderErrors($label);
                $label .= ': </label>';
                break;

            endswitch;
        return $label;
    }
}