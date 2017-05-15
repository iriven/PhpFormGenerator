<?php
/**
 * Created by PhpStorm.
 * User: Iriven France
 * Date: 08/04/2017
 * Time: 05:37
 */

namespace Iriven;

use Iriven\Interfaces\FormBuilderInterface;
use Iriven\Dependencies\PhpOptionsResolver;
use Iriven\Dependencies\WorldCountriesDatas;

class PhpFormBuilder implements FormBuilderInterface
{
    private $FormHtml=null;
    private $GlobalAttributes=['accesskey','class','contenteditable', 'contextmenu','dir','draggable','dropzone','hidden','id','lang','spellcheck','style','tabindex','title','translate'];
    private $AllowedEvents = ['onblur','onchange','oncontextmenu','onfocus','oninput','oninvalid','onreset','onsearch','onselect','onsubmit','onkeydown','onkeypress','onkeyup','onclick','ondblclick','ondrag','ondragend','ondragenter','ondragleave','ondragover','ondragstart','ondrop','onmousedown','onmousemove','onmouseout','onmouseover','onmouseup','onmousewheel','onscroll','onwheel'];
    private $AllowedAttributes= [
        'button'=>['autofocus','disabled','form','formaction','formenctype','formmethod','formnovalidate','formtarget','framename','name','type','value'],
        'checkbox'=>['autofocus','checked','defaultChecked','defaultvalue','disabled','form','indeterminate','name','required','type','value'],
        'color'=>['autocomplete','autofocus','defaultvalue','disabled','form','list','name','type','value'],
        'date'=>['autocomplete','autofocus','defaultvalue','disabled','form','list','max','min','name','readonly','required','step','type','value'],
        'fieldset'=>['disabled','form','name','legend','legend-attributes'],
        'file'=>['accept','autofocus','defaultvalue','disabled','files','form','multiple','name','required','type','value'],
        'form'=>['accept','accept-charset','action','autocomplete','enctype','method','name','novalidate','target'],
        'hidden'=>['form','name','type','value'],
        'image'=>['alt','autofocus','defaultvalue','disabled','form','formaction','formenctype','formmethod','formnovalidate','formtarget','height','name','src','type','value','width'],
        'label'=>['for','form'],
        'option'=>['disabled','label','value','selected'],
        'range'=>['autocomplete','autofocus','defaultvalue','disabled','form','list','max','min','name','step','type','value'],
        'reset'=>['autofocus','defaultvalue','disabled','form','name','type','value'],
        'select'=>['autofocus','disabled','form','multiple','name','required','size','selected','optgroup-attributes','option-attributes','value'],
        'text'=>['autocomplete','autofocus','defaultvalue','disabled','form','list','minlength','maxlength','name','pattern','placeholder','readonly','required','size','type','value'],
        'textarea'=>['autofocus','cols','dirname','disabled','form','maxlength','name','placeholder','readonly','required','rows','wrap','value']
    ];
    public $ValidationErrors = [];
    private $OptionResolver;
    private $RequestMethod = null;

    /**
     * PhpFormBuilder constructor.
     * @param string $method
     */
    public function __construct($method = 'post'){
        try{
            $method = strtolower(trim($method));
            if(!in_array($method,['get','post'],true))
                $method = $_SERVER['REQUEST_METHOD'];
            $this->RequestMethod = $method;
            $this->OptionResolver= new PhpOptionsResolver();
            return $this;
        }
        catch(\Exception $e){echo $e->getMessage();}
        return false;
    }
    /* COMMON METHODS */
    /**
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function Create($attributes=[]){
        $attributes = array_change_key_case($attributes,CASE_LOWER);
        $this->OptionResolver->setDefaults([
            'method'=>'post',
            'action'=>basename($_SERVER["SCRIPT_NAME"]),
            'enctype'=>'application/x-www-form-urlencoded',
            'name'=>md5($_SERVER['REQUEST_URI'].microtime(true))
        ]);
        $this->OptionResolver->addAllowedValues('method',['post','get']);
        $this->OptionResolver->addAllowedValues('enctype',[
            'application/x-www-form-urlencoded',
            'multipart/form-data',
            'text/plain']);
        $this->OptionResolver->addAllowedTypes('action','string');
        $this->OptionResolver->addAllowedTypes('name','string');
        $attributes=$this->OptionResolver->resolve($this->FilterAttributes($attributes,'form'));
        if(strcasecmp($attributes['method'],'get') == 0) unset($attributes['enctype']);
        $html  = '<form';
        $html .= $this->BuildAttributes($attributes);
        $html .= '>';
        return $this->Save($html);
    }

    /**
     * @return mixed
     */
    public function Close(){
        $this->Save($html = '</form>');
        $html = $this->FormHtml;
        $this->FormHtml=null;
        return print_r($html);
    }

    /**
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function OpenFieldset($attributes=[]){
        $attributes = array_change_key_case($attributes,CASE_LOWER);
        $this->OptionResolver->setDefaults([
            'legend'=>null,
            'name'=>md5($_SERVER['REQUEST_URI'].microtime(true))
        ]);
        $attributes = $this->OptionResolver->resolve($this->FilterAttributes($attributes,'fieldset'));
        $html ='<fieldset';
        if($attributes)
            $html.= $this->BuildAttributes($attributes,array('legend','label','id','legend-attributes'));
        $html .= ' >';
        if(isset($attributes['legend']))
        {
            $attributes['legend-attributes']?:[];
            is_array($attributes['legend-attributes']) or $attributes['legend-attributes']=[$attributes['legend-attributes']];
            $legendAttributes=$this->FilterAttributes($attributes['legend-attributes'],'legend');
            $html .= '<legend';
            $html .= $this->BuildAttributes($legendAttributes);
            $html .= '>';
            $html .= $attributes['legend'];
            $html .= '</legend>';
        }
        return $this->Save($html);
    }

    /**
     * @return PhpFormBuilder
     */
    public function CloseFieldset(){
        return $this->Save($html='</fieldset>');
    }

    /* INPUT TYPES */
    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addAudio($label,$attributes=[])
    {
       // $attributes['accept']='audio/*;capture=microphone';
        $attributes['accept']='audio/*';
        return $this->addFile($label,$attributes);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addButton($label,$attributes=[]){
        $attributes['type'] = 'button';
        $attributes['value'] = $attributes['value']?:$label;
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addCaptcha($label,$attributes=[]){
        $attributes = array_change_key_case($attributes,CASE_LOWER);
        $this->OptionResolver->setDefaults([
            'value'=>null,
            'maxlength'=>2,
            'required'=>'required',
            'type'=>'text',
            'id'=>'inputCaptcha',
            'name'=>'Captcha'
        ]);
        $label=$label?:'Entrez le résultat de';
        $attributes['name'] = $this->normalize($attributes['name']);
        $attributes = $this->OptionResolver->resolve($this->FilterAttributes($attributes,'text'));
        $operators = array('+','-','x');
        shuffle($operators);
        $operator = $operators[0];
        switch($operator):
            case 'x':
                do{
                    $num1 = rand(2,6);
                    $num2 = rand(3,7);
                    $response = $num2 * $num1;
                } while($response > 35);
                break;
            case '-':
                do{
                    $num1 = rand(1,8);
                    $num2 = rand(6,11);
                    $response = $num2 - $num1;
                } while($response < 2);
                break;
            default:
                $num1 = rand(1,7);
                $num2 = rand(3,8);
                $response = $num1 + $num2;
                break;
        endswitch;
        $label .= ": $num2 $operator $num1";
        $_SESSION[md5($attributes['name'])] = $response;
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addColor($label,$attributes=[])
    {
        $attributes['pattern'] = '#[a-g0-9]{6}';
        $attributes['title'] = '6-digit hexidecimal color (e.g. #000000)';
        $attributes['type'] = 'color';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }
    /**
     * @param $label
     * @param array $options
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addCheckbox($label,$options=[],$attributes=[]){
        $attributes = array_change_key_case($attributes,CASE_LOWER);
        $this->OptionResolver->setDefaults([
            'value'=>$this->getDefaultValue($label),
            'type'=>'checkbox',
            'id'=>'input'.$this->normalize($label),
            'name'=>$this->normalize($label)
        ]);
        $this->OptionResolver->addAllowedValues('type',['radio','checkbox']);
        $type = $attributes['type']?:'checkbox';
        $attributes = $this->OptionResolver->resolve($this->FilterAttributes($attributes,$type));
        if(strpos($attributes['id'],'input')!==0)
            $attributes['id'] = $this->normalize($attributes['id']);

        if(sizeof($options)<2)
        {
            empty($attributes['value']) or $attributes['checked'] ='checked';
            $attributes['value'] = '1';
            $attributes['type'] = 'checkbox';
            $this->addHidden($label,array('value'=>'0'));
            $html = $this->CreateInput($label,$attributes);
        }
        else
        {
            if(isset($attributes['value']))
            {
                if(!is_array($attributes['value'])) $attributes['value'] = array($attributes['value']);
            }
            else
                $attributes['value'] = [];
            if(substr($attributes['name'], -2) !== '[]')
                $attributes['name'] .= '[]';
            $count = 0;
            $html = $this->InsertLabel($label,array('for'=>$attributes['id']));
            foreach($options as $value => $text)
            {
                $html .= '<label for="'.$attributes['id'].'-'.$count.'">';
                $html .= '<input id="'.$attributes['id'].'-'.$count.'"';
                $html .= ' value="'.$value.'"';
                $html .= $this->BuildAttributes($attributes,array('id', 'value', 'checked', 'required'));
                if(in_array($value, $attributes['value'])) $html .= ' checked="checked"';
                $html .= ' >'.$text.'</label>';
                ++$count;
            }
        }
        return $this->Save($html);
    }
    /**
     * @param $label
     * @param array $attributes
     * @return mixed
     */
    public function addCountry($label,$attributes=[])
    {
        $default = array('placeholder'=>'Choose a Country...','required'=>'required');
        $attributes = array_merge($default,$attributes);
        $Dataset = new WorldCountriesDatas();
        return $this->addSelect($label,$Dataset->getAllCountriesCodeAndName(),$attributes);
    }
    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addDate($label,$attributes=[]){
        // $attributes['pattern'] = '\d{4}-\d{2}-\d{2}';
        //  $attributes['placeholder'] = 'YYYY-dd-MM (e.g. ' . date('Y-m-d') . ')';
        $attributes['type'] = 'date';
        $attributes['title'] = $attributes['placeholder'];
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addDatetime($label,$attributes=[]){
        $attributes['type'] = 'datetime';
        $attributes['placeholder'] = 'YYYY-dd-MM H:i:s(e.g. ' . date('Y-m-d H:i:s') . ')';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addDatetimeLocal($label,$attributes=[]){
        $attributes['type'] = 'datetime-local';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addEmail($label,$attributes=[]){
        $attributes['type'] = 'email';
        $attributes['required'] = 'required';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addFile($label,$attributes=[]){
        $attributes['type'] = 'file';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addHidden($label,$attributes=[]){
        $attributes['type'] = 'hidden';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addImage($label,$attributes=[]){
        $attributes['accept']='image/*';
       // $attributes['accept']='image/*;capture=camera';
        return $this->addFile($label,$attributes);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addMonth($label,$attributes=[]){
        $attributes['type'] = 'month';
        $attributes['pattern'] = '\d{4}-\d{2}';
        $attributes['placeholder'] = 'YYYY-MM (e.g. ' . date('Y-m') . ')';
        $attributes['title'] = $attributes['placeholder'];
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addNumber($label,$attributes=[]){
        $default = array('min'=>'0','max'=>'100','step'=>'1');
        $attributes = array_merge($default,$attributes);
        $attributes['type'] = 'number';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addPassword($label,$attributes=[]){
        $default = array('placeholder'=>'**********','minlength'=>'6','maxlength'=>'25','required'=>'required');
        $attributes = array_merge($default,$attributes);
        $attributes['type'] = 'password';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addPhone($label,$attributes=[]){
        $attributes['type'] = 'tel';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $options
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addRadio($label,$options=[],$attributes=[]){
        $attributes['type'] = 'radio';
        return $this->addCheckbox($label,$options,$attributes);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addRange($label,$attributes=[]){
        $default = array('min'=>'0','max'=>'100','step'=>'1');
        $attributes = array_merge($default,$attributes);
        $attributes['type'] = 'range';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addReset($label,$attributes=[]){
        $attributes['type'] = 'reset';
        $attributes['value'] = $attributes['value']?:$label;
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addSearch($label,$attributes=[]){
        $attributes['type'] = 'search';
        $attributes['required'] = 'required';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $options
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addSelect($label,$options=[],$attributes=[]){
        $attributes = array_change_key_case($attributes,CASE_LOWER);
        $this->OptionResolver->setDefaults([
            'value'=>$this->getDefaultValue($label),
            'id'=>'input'.$this->normalize($label),
            'name'=>$this->normalize($label),
            'type'=>'select',
            'placeholder'=>'Make a Choise...'
        ]);
        $this->OptionResolver->addAllowedValues('type','select');
        $attributes = $this->OptionResolver->resolve($this->FilterAttributes($attributes,'select'));
        $multiple=false;
        if(strpos($attributes['id'],'input')!==0)
            $attributes['id'] = $this->normalize($attributes['id']);
        if($attributes['value'])
        {
            if(!is_array($attributes['value']))
                $attributes['value'] = array($attributes['value']);
        }
        else
            $attributes['value'] = [];
        if(isset($attributes['multiple']) and ($attributes['multiple']==='multiple'))
            $multiple=true;
        if($multiple)
        {   $attributes['size']= $attributes['size']?:3;
            if(substr($attributes['name'], -2) !== '[]')
                $attributes['name'] .= '[]';
        }

        $html = $this->InsertLabel($label,array('for'=>$attributes['id']));
        $html .= '<select'.$this->BuildAttributes($attributes,array('value','selected','optgroup-attributes','option-attributes','placeholder')).'>';
        if(!$attributes['value'] and isset($attributes['placeholder']))
        {
            $html .= '<option value="" disabled selected>'.$attributes['placeholder'].'</option>';
            unset($attributes['placeholder']);
        }
        $selected = false;
        foreach($options as $OptionValue=>$OptionLabel):

            if(is_array($OptionLabel))
            {
                $html .= call_user_func_array($OptGroupHtml = function($groupName,$groupOptions) use (&$OptGroupHtml,&$attributes,&$selected)
                {
                    $output='<optgroup label="'.$groupName.'">';
                    foreach($groupOptions as $key=>$optLabel)
                    {
                        if(is_array($optLabel))$output .= $OptGroupHtml($key,$optLabel);
                        else
                        {
                            $output .= '<option value="'.$key.'"';
                            if(!$selected and in_array($key,$attributes['value']))
                            {
                                $output .= ' selected="selected"';
                                $selected = true;
                            }
                            $output .= '>';
                            $output .= $optLabel.'</option>';
                        }
                    }
                    $output.='</optgroup>';
                    return$output;
                },[$OptionValue,$OptionLabel]);
            }
            else
            {
                $html .= '<option value="'.$OptionValue.'"';
                if(!$selected and in_array($OptionValue,$attributes['value']))
                {
                    $html .= ' selected="selected"';
                    $selected = true;
                }
                $html .= '>';
                $html .= $OptionLabel.'</option>';
            }
        endforeach;
        $html .= '</select>';
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addSubmit($label,$attributes=[]){
        $this->addHidden('token',array('value'=>sha1(session_id())));
        $attributes['type'] = 'submit';
        $attributes['value'] = $attributes['value']?:$label;
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addText($label,$attributes=[]){
        $attributes['type'] = 'text';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addTextarea($label,$attributes=[]){
        $attributes = array_change_key_case($attributes,CASE_LOWER);
        $this->OptionResolver->setDefaults([
            'id'=>'input'.$this->normalize($label),
            'autocomplete'=>'off',
            'rows'=>6,
            'cols'=>60,
            'value' => $this->getDefaultValue($label),
            'name' => $this->normalize($label)
        ]);
        $attributes = $this->OptionResolver->resolve($this->FilterAttributes($attributes,'textarea'));
        if(strpos($attributes['id'],'input')!==0)
            $attributes['id'] = $this->normalize($attributes['id']);
        $html  = $this->InsertLabel($label,array('for'=>$attributes['id']));
        $html .= '<textarea'. $this->BuildAttributes($attributes,array('value')).'>';
        $html .= $attributes['value'];
        $html .= '</textarea>';
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addTextEditor($label,$attributes=[])
    {
        $attributes['class'] = 'editor';
        return $this->addTextarea($label, $attributes);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addTime($label,$attributes=[]){
        $attributes['type'] = 'time';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addUrl($label,$attributes=[]){
        $attributes['type'] = 'url';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addVideo($label,$attributes=[]){
        //$attributes['accept']='video/*;capture=camcorder';
        $attributes['accept']='video/*';
        return $this->addFile($label,$attributes);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addWeek($label,$attributes=[]){
        $attributes['type'] = 'week';
        $html = $this->CreateInput($label,$attributes);
        return $this->Save($html);
    }

    /**
     * @param $label
     * @param array $attributes
     * @return PhpFormBuilder
     */
    public function addYesNo($label,$attributes=[]){
        $options = array(
            '1' => 'Yes',
            '0' => 'No'
        );
        return $this->addRadio($label,$options,$attributes);
    }

    /* PRIVATES METHODS */
    /**
     * @param $attributes
     * @param null $ignore
     * @return bool|null|string
     */
    private function BuildAttributes($attributes,$ignore = null){
        if(!$attributes) return false;
        is_array($attributes) or $attributes = array($attributes);
        $filtered = array_keys($attributes);
        if($ignore)
        {
            if (!is_array($ignore)) $ignore = array($ignore);
            $filtered = array_diff($filtered, $ignore);
        }
        $output = null;
        foreach($attributes as $key=>$value)
        {
            if(!in_array($key,$filtered)) continue;
            $output .= ' ';
            $key = $this->normalize($key);
            if(is_array($value)):
                $output .= $key.'="'.implode(' ',array_values($value)).'"';
            else:
                if(is_numeric($key)) $output .= $value;
                else $output .= $key.'="'.$value.'"';
            endif;
        }
        return $output;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return bool|string
     */
    private function CreateInput($label,$attributes=[]){
        $attributes = array_change_key_case($attributes,CASE_LOWER);
        $this->OptionResolver->setDefaults([
            'value' => $this->getDefaultValue($label),
            'type' => 'text',
            'id' => 'input' . $this->normalize($label),
            'autocomplete' => 'off',
            'name' => $this->normalize($label)
        ]);
        $this->OptionResolver->setAllowedValues('type',[
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
            'week']);
        $type = $attributes['type']?:'text';
        $attributes = $this->OptionResolver->resolve($this->FilterAttributes($attributes,$type));
        $notLabeled = array('hidden','submit','reset','button');
        if(strpos($attributes['id'],'input')!==0)
            $attributes['id'] = $this->normalize($attributes['id']);
        $html  = !in_array($attributes['type'],$notLabeled)?$this->InsertLabel($label,array('for'=>$attributes['id'])):'';
        $html .= '<input';
        $html .= $this->BuildAttributes($attributes);
        $html .= ' >';
        return $html;
    }

    /**
     * @param $label
     * @return bool|string
     */
    private function DisplayError($label)
    {
        if (!$label) return false;
        $label = $this->normalize($label);
        $errorMsg = null;
        !isset($this->ValidationErrors[$label]) OR $errorMsg = $this->ValidationErrors[$label];
        if (!$errorMsg) return '';
        if (is_array($errorMsg))
        {
            $html='';
            foreach ($errorMsg as $error){
                $html .= '<li class="hint"><span class="error">';
                $html .= $error;
                $html .= '</span></li>';
            }
        }
        else
        {
            $html = '<li class="hint"><span class="error">';
            $html .= $errorMsg;
            $html .= '</span></li>';
        }
        return $html;
    }

    /**
     * @param $attributes
     * @param string $element
     * @return array
     */
    private function FilterAttributes($attributes,$element='text'){
        is_array($attributes) or $attributes=[$attributes];
        $attributes=array_change_key_case($attributes,CASE_LOWER);
        $AcceptedAttributes = array_merge($this->AllowedEvents,$this->GlobalAttributes);
        $element = strtolower($element);
        switch ($element):
            case 'date':
            case 'datetime':
            case 'datetime-local':
            case 'month':
            case 'number':
            case 'time':
            case 'week':
                if($element === 'number') $AcceptedAttributes[]='placeholder';
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['date']);
                break;
            case 'color':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['color']);
                break;
            case 'file':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['file']);
                break;
            case 'image':
            case 'video':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['image']);
                break;
            case 'radio':
            case 'checkbox':
                $tmpAttributesList=$this->AllowedAttributes['checkbox'];
                if($element === 'radio')
                {
                    $bannedIndex=array_search('indeterminate', $tmpAttributesList,true);
                    if(isset($tmpAttributesList[$bannedIndex]))unset($tmpAttributesList[$bannedIndex]);
                }
                $AcceptedAttributes = array_merge($AcceptedAttributes,array_values($tmpAttributesList));
                break;

            case 'submit':
            case 'button':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['button']);
                break;

            case 'reset':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['reset']);
                break;
            case 'range':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['range']);
                break;
            case 'textarea':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['textarea']);
                break;
            case 'option':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['option']);
                break;
            case 'label':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['label']);
                break;
            case 'select':
                $AcceptedAttributes[]='placeholder';
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['select']);
                break;
            case 'form':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['form']);
                break;
            case 'fieldset':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['fieldset']);
                break;
            case 'hidden':
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['hidden']);
                break;
            default:
                if($element === 'email') $AcceptedAttributes[]='multiple';
                $AcceptedAttributes = array_merge($AcceptedAttributes,$this->AllowedAttributes['text']);
                break;
        endswitch;
        $AcceptedAttributes = array_unique($AcceptedAttributes);
        $attributesKeys=array_keys($attributes);
        foreach ($attributesKeys as $attribute):
            !is_numeric($attribute) or $attribute=$attributes[$attribute];
            if(!in_array($attribute,$AcceptedAttributes)){
                if(substr($attribute,0,5)!=='data-')
                    $AcceptedAttributes[] +=$attribute;
                else
                    unset($attributes[$attribute]);
            }

        endforeach;
        $this->OptionResolver->setDefined($AcceptedAttributes);
        return $attributes;
    }
    /**
     * @param $label
     * @return bool|string
     */
    private function getDefaultValue($label){
        if(!$label) return false;
        $label = $this->normalize($label);
        $request = strcasecmp($this->RequestMethod,'get')==0 ? $_GET : $_POST;
        if(!$value = $request[$label]) return '';
        return $value;
    }

    /**
     * @param $label
     * @param array $attributes
     * @return bool|string
     */
    private function InsertLabel($label,$attributes=[]){
        if(!$label or is_array($label)) return false;
        $labelAttributes = $this->FilterAttributes($attributes,'label');
        $html = '<label'.$this->BuildAttributes($labelAttributes).'>';
        $html .= $label;
        $html .= $this->DisplayError($label);
        $html .= '</label>';
        return $html;
    }
    /**
     * @param $keys
     * @return bool|mixed|string
     */
    private function normalize($keys)
    {
        if(is_array($keys)) return false;
        foreach (array(' ', '&nbsp;', '\n', '\t', '\r', '"','\'','_') as $strip)
            $keys = str_replace($strip, '', (string) $keys);
        $keys = trim(preg_replace('/\W+/', '-', $keys), '-');
        $keys = strtolower(str_ireplace('input','',$keys));
        return $keys;
    }

    /**
     * @param $html
     * @return $this
     */
    private function Save($html){
        $this->FormHtml .= $html;
        return $this;
    }

}
