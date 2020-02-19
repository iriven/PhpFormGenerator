<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/05/2018
 * Time: 20:37
 */

namespace Iriven\Plugins\Form\Elements;
use \Iriven\Plugins\Form\Core\FormElement;

class Datalist extends FormElement
{
    private $options;
    private $listname;
    public function __construct($label, array $options = [], $attributes)
    {
        parent::__construct($label, $attributes);
        $this->listname = 'datalist-' . $this->Attributes()->get('id');
        $this->Attributes()->set('list', $this->listname);
        $this->options = array_values($options);
    }

    /**
     * @return string
     */
    public function RenderHtml(): string
    {
        $html = parent::RenderHtml();
        $html .= '<datalist id="'. $this->listname.'">';
        foreach( $this->options as $option)
        {
            if(!$option = trim(strip_tags($option))) continue;
            $html .= '<option value="'.$option.'">';
        }
        $html .= '</datalist>';
        return $html;
    }

}
