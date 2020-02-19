<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 07/05/2018
 * Time: 14:20
 */

namespace Iriven\Plugins\Form\Core\Libs;


class AttributesMapper
{
    const COMMON = ['accesskey','class','contenteditable', 'contextmenu','dir','draggable','dropzone','hidden','id','lang','spellcheck','style','tabindex','title','translate'];
    const EVENTS = ['onblur','onchange','oncontextmenu','onfocus','oninput','oninvalid','onreset','onsearch','onselect','onsubmit','onkeydown','onkeypress','onkeyup','onclick','ondblclick','ondrag','ondragend','ondragenter','ondragleave','ondragover','ondragstart','ondrop','onmousedown','onmousemove','onmouseout','onmouseover','onmouseup','onmousewheel','onscroll','onwheel'];
    const BUTTON = ['autofocus','disabled','form','formaction','formenctype','formmethod','formnovalidate','formtarget','framename','name','type','value'];
    const CHECKBOX = ['autofocus','checked','defaultChecked','defaultvalue','disabled','form','indeterminate','name','required','type','value'];
    const COLOR = ['autocomplete','autofocus','defaultvalue','disabled','form','list','name','type','value'];
    const DATE = ['autocomplete','autofocus','defaultvalue','disabled','form','list','max','min','name','readonly','required','step','type','value'];
    const FIELDSET = ['disabled','form','name','legend','legend-attributes'];
    const FILE = ['accept','autofocus','defaultvalue','disabled','files','form','multiple','name','required','type','value', 'data-max-size'];
    const FORM = ['accept','accept-charset','action','autocomplete','enctype','method','name','novalidate','target'];
    const HIDDEN = ['form','name','type','value'];
    const IMAGE = ['alt','autofocus','defaultvalue','disabled','form','formaction','formenctype','formmethod','formnovalidate','formtarget','height','name','src','type','value','width'];
    const LABEL = ['for','form'];
    const OPTGROUP = ['disabled','label'];
    const OPTION = ['disabled','label','value','selected'];
    const RANGE = ['autocomplete','autofocus','defaultvalue','disabled','form','list','max','min','name','step','type','value'];
    const RESET = ['autofocus','defaultvalue','disabled','form','name','type','value'];
    const SELECT = ['autofocus','disabled','form','multiple','name','required','size','selected','optgroup-attributes','option-attributes','value'];
    const TEXT = ['autocomplete','autofocus','defaultvalue','disabled','form','list','minlength','maxlength','name','pattern','placeholder','readonly','required','size','type','value'];
    const TEXTAREA = ['autofocus','cols','dirname','disabled','form','maxlength','name','placeholder','readonly','required','rows','wrap','value'];

    /**
     * @param AttributesBuilder $Attributes
     * @return array
     */
    public static function filter(AttributesBuilder $Attributes)
    {
        $aAttributes = array_change_key_case($Attributes->All(),CASE_LOWER);
        $Type = $Attributes->get('type','text');
        $AcceptedAttributes = array_merge(self::EVENTS, self::COMMON);
        switch ($Type):
            case 'date':
            case 'datetime':
            case 'datetime-local':
            case 'month':
            case 'number':
            case 'time':
            case 'week':
                if($Type === 'number') $AcceptedAttributes[]='placeholder';
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::DATE);
                break;
            case 'color':
                $AcceptedAttributes = array_merge($AcceptedAttributes, self::COLOR);
                break;
            case 'file':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::FILE);
                break;
            case 'image':
            case 'video':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::IMAGE);
                break;
            case 'radio':
            case 'checkbox':
                $tmpAttributesList=self::CHECKBOX;
                if($Type === 'radio')
                {
                    $bannedIndex = array_search('indeterminate', $tmpAttributesList,true);
                    if(isset($tmpAttributesList[$bannedIndex])) unset($tmpAttributesList[$bannedIndex]);
                }
                $AcceptedAttributes = array_merge($AcceptedAttributes,array_values($tmpAttributesList));
                break;

            case 'submit':
            case 'button':
                $AcceptedAttributes = array_merge($AcceptedAttributes, self::BUTTON);
                break;

            case 'reset':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::RESET);
                break;
            case 'range':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::RANGE);
                break;
            case 'textarea':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::TEXTAREA);
                break;
            case 'optgroup':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::OPTGROUP);
                break;
            case 'option':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::OPTION);
                break;
            case 'label':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::LABEL);
                break;
            case 'select':
                $AcceptedAttributes[]='placeholder';
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::SELECT);
                break;
            case 'form':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::FORM);
                break;
            case 'fieldset':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::FIELDSET);
                break;
            case 'hidden':
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::HIDDEN);
                break;
            default:
                if($Type === 'email') $AcceptedAttributes[]='multiple';
                $AcceptedAttributes = array_merge($AcceptedAttributes,self::TEXT);
                break;
        endswitch;

        $AcceptedAttributes = array_unique($AcceptedAttributes);
        $attributesKeys = array_keys($aAttributes);
        $ignore = array_diff($attributesKeys,$AcceptedAttributes);
        foreach ($ignore as $key=>$attribute)
        {
            if(is_numeric($attribute))
            {
                unset($ignore[$key]);
                $attribute = $aAttributes[$attribute];
                $ignore[$key] = $attribute;
            }
            if(substr($attribute,0,5)==='data-')
            {
                $AcceptedAttributes[] += $attribute;
                unset($ignore[$key]);
                continue;
            }
        }
        if($ignore) $Attributes->Ignore($ignore);
        return $ignore;
    }
}