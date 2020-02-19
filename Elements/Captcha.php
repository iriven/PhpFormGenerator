<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 17/05/2018
 * Time: 14:17
 */

namespace Iriven\Plugins\Form\Elements;


class Captcha extends Text
{
    public function __construct($label='Security Code', $attributes)
    {
        $operators = ['+','x','-'];
        $operator = $operators[rand(0,2)];
        switch($operator):
            case 'x':
                do{
                    $firstnumber = rand(3,7);
                    $secondnumber = rand(2,6);
                    $response = $firstnumber * $secondnumber;
                } while($response > 35);
                break;
            case '-':
                do{
                    $firstnumber = rand(6,11);
                    $secondnumber = rand(1,8);
                    $response = $firstnumber - $secondnumber;
                } while($response < 2);
                break;
            default:
                $firstnumber = rand(3,8);
                $secondnumber = rand(1,7);
                $response = $firstnumber + $secondnumber;
                break;
        endswitch;
        $label .= ". $firstnumber $operator $secondnumber";
        parent::__construct($label, $attributes);
        $this->Attributes()->set('name', str_replace(". $firstnumber $operator $secondnumber",'',$label));
        $this->Attributes()->createElementID($this->Attributes()->get('name'));
        $this->Attributes()->set('maxlength',2);
        $this->Attributes()->set('required','required');
        $this->Attributes()->set('pattern','[0-9]{1,2}');
        $this->Attributes()->set('placeholder','Enter result');
        $this->Attributes()->set('capresponse',$response);
      /*  $this->Attributes()->set('capfirstnumber',$firstnumber);
        $this->Attributes()->set('capsecondnumber',$secondnumber);
        $this->Attributes()->set('capoperator',$operator);*/
    }

}