<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/05/2018
 * Time: 16:25
 */

namespace Iriven\Plugins\Form;

use \Bundle\Core\CoreController;
use \Iriven\Plugins\Form\Core\Libs\Collection;
use \Iriven\Plugins\Form\Elements\Audio;
use \Iriven\Plugins\Form\Elements\Button;
use \Iriven\Plugins\Form\Elements\Captcha;
use \Iriven\Plugins\Form\Elements\Checkbox;
use \Iriven\Plugins\Form\Elements\Color;
use \Iriven\Plugins\Form\Elements\Country;
use \Iriven\Plugins\Form\Elements\Datalist;
use \Iriven\Plugins\Form\Elements\Date;
use \Iriven\Plugins\Form\Elements\Datetime;
use \Iriven\Plugins\Form\Elements\DatetimeLocal;
use \Iriven\Plugins\Form\Elements\Editor;
use \Iriven\Plugins\Form\Elements\Email;
use \Iriven\Plugins\Form\Elements\File;
use \Iriven\Plugins\Form\Elements\Hidden;
use \Iriven\Plugins\Form\Elements\Image;
use \Iriven\Plugins\Form\Elements\Month;
use \Iriven\Plugins\Form\Elements\Number;
use \Iriven\Plugins\Form\Elements\Password;
use \Iriven\Plugins\Form\Elements\Phone;
use \Iriven\Plugins\Form\Elements\Radio;
use \Iriven\Plugins\Form\Elements\Range;
use \Iriven\Plugins\Form\Elements\Reset;
use \Iriven\Plugins\Form\Elements\Search;
use \Iriven\Plugins\Form\Elements\Select;
use \Iriven\Plugins\Form\Elements\Submit;
use \Iriven\Plugins\Form\Elements\Text;
use \Iriven\Plugins\Form\Elements\Textarea;
use \Iriven\Plugins\Form\Elements\Time;
use \Iriven\Plugins\Form\Elements\Url;
use \Iriven\Plugins\Form\Elements\Video;
use \Iriven\Plugins\Form\Elements\Week;
use \Iriven\Plugins\Form\Elements\YesNo;
use \Iriven\Plugins\Form\Core\fieldsetGenerator;
use \Iriven\Plugins\Form\Core\form;
use \Iriven\Plugins\Form\Core\Libs\Traits\KeyNormalizer;
use \Iriven\Plugins\Form\Core\FormElement;


class FormGenerator
{
    use KeyNormalizer;
    public  $Errors;
    private $Form;
    private $Fieldset;
    private $Request;

    /**
     * FormGenerator constructor.
     *
     * @param CoreController $App
     */
    public function __construct(CoreController $App)
    {
        $this->Request = $App->Request();
        $formErrors = $App->get('errors',[]);
        is_array($formErrors) OR $formErrors = [$formErrors];
        $this->Errors = new Collection($formErrors);
    }

    /**
     * @param       $label
     * @param array $attributes
     * @return $this
     */
    public function addAudio($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Audio($label,$attributes);
            $item->Attributes()->set('accept','audio/*');
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->Attributes()->set('enctype','multipart/form-data');
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param       $label
     * @param array $attributes
     * @return $this
     */
    public function addButton($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Button($label,$attributes);
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param       $label
     * @param array $attributes
     * @return $this
     */
    public function addCaptcha($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Captcha($label,$attributes);
            //$this->Request->getSession()->set(md5($item->Attributes()->get('name')), $item->Attributes()->get('capresponse'));
           // $this->Request->Session->set(md5($item->Attributes()->get('name')),$item->Attributes()->get('capresponse'));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $options
     * @param array $attributes
     * @return $this
     */
    public function addCheckbox($label,$options = [],$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Checkbox($label,$options ,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addColor($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Color($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addCountries($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Country($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */   
    public function addDatalist($label, $options=[], $attributes = [])
    {
        if ($this->Form instanceof form) {
                $item = new Datalist($label, $options, $attributes);
                $item->Attributes()->set('value', $this->getDefaultValue($item));
                $this->Form->append($item);
            }
        return $this;
    }
    
    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addDate($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Date($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addDatetime($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Datetime($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addDatetimeLocal($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new DatetimeLocal($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addEditor($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Editor($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addEmail($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Email($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param array $attributes
     * @return $this
     */
    public function addFieldset($attributes=[])
    {
        if($this->Form instanceof form)
        {
            if($this->Fieldset instanceof fieldsetGenerator)
                $this->Form->append($this->Fieldset->Close());
            $this->Fieldset = new fieldsetGenerator($attributes);
            $this->Fieldset->Attributes()->set('name', $this->Form->Attributes()->get('name'));
            $this->Form->append($this->Fieldset->Open());
        }
        return $this;  
    }
    /**
     * @param       $label
     * @param array $attributes
     * @return $this
     */
    public function addFile($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new File($label,$attributes);
            $this->Form->Attributes()->set('enctype','multipart/form-data');
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addHidden($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Hidden($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $html
     * @return $this
     */
    public function addHtml($html)
    {
        if($this->Form instanceof form)
        {
            if(gettype($html) === 'string')
            $this->Form->append($html);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addImage($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Image($label,$attributes);
            $this->Form->Attributes()->set('enctype','multipart/form-data');
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addMonth($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Month($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addNumber($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Number($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addPassword($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Password($label,$attributes);
            $item->Attributes()->set('value', '');
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addPhone($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Phone($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $options
     * @param array $attributes
     * @return $this
     */
    public function addRadio($label,$options=[],$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Radio($label,$options,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addRange($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Range($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addReset($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Reset($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addSearch($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Search($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param $label
     * @param array $options
     * @param array $attributes
     * @return $this
     */
    public function addSelect($label,array $options = [],$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Select($label,$options,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addSubmit($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Submit($label,$attributes);
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addText($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Text($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addTextarea($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Textarea($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addTime($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Time($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addUrl($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Url($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addVideo($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Video($label,$attributes);
            $this->Form->Attributes()->set('enctype','multipart/form-data');
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addWeek($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new Week($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return $this
     */
    public function addYesNo($label,$attributes=[])
    {
        if($this->Form instanceof form)
        {
            $item = new YesNo($label,$attributes);
            $item->Attributes()->set('value', $this->getDefaultValue($item));
            $this->Form->append($item);
        }
        return $this;
    }
    /**
     * @param bool $print
     * @return null|string
     */
    public function Close($print=true)
    {
        $html = null;
        if ($this->Form instanceof form)
        {
            if($this->Fieldset instanceof fieldsetGenerator)
                $this->Form->append($this->Fieldset->Close());
            $html = $this->Form->RenderHtml();
            $this->Form = null;
            if($print)
                print_r($html);
        }
        return $html;
    }
    /**
     * @return mixed
     */
    public function Errors()
    {
        return $this->Errors;
    }
    /**
     * @param $element
     * @param null $default
     * @return mixed
     */
    private function getDefaultValue(FormElement $element,$default=null)
    {
        $name = $element->Attributes()->get('name');
        $method = strtoupper($this->Request->getMethod());
        switch($method){
            case 'POST':
            case 'PUT':
            case 'DELETE':
            case 'PATCH':
                $Request = $this->Request->request;
            break;           
            default:
                $Request = $this->Request->query; 
            break;
        }
        if(!$value = $Request->get($name, $default))
        $value = $element->Attributes()->get('value', $default);
        return $value;
    }
    /**
     * @param array $attributes
     * @return $this
     */
    public function Open($attributes = [])
    {
        if($this->Form instanceof form)
            $this->Close();
        $this->Form = new form($attributes);
        return $this;
    }
}