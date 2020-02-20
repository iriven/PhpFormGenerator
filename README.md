# PhpFormGenerator

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XDCFPNTKUC4TU)
[![Build Status](https://scrutinizer-ci.com/g/iriven/PhpFormGenerator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/iriven/PhpFormGenerator/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/iriven/PhpFormGenerator/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/iriven/PhpFormGenerator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/iriven/PhpFormGenerator/?branch=master)

The Ultimate PHP Form Generator Class is developed with the following goals in mind...

  - promotes rapid development of HTML forms through an object-oriented PHP framework.
  - Eliminate the grunt/repetitive work of writing the html when building forms.
  - Reduce human error by using a consistent/tested utility.
  
The Iriven Php FormGenerator adhere to W3C standards. 
Give it a try and let me know what you like, hate, and think needs to be fixed.

### Availlable Methods:

- Open($attributes = [])
- addAudio($label,$attributes=[])
- addButton($label,$attributes=[])
- addCaptcha($label,$attributes=[])
- addCheckbox($label,$options = [],$attributes=[])
- addColor($label,$attributes=[])
- addCountries($label,$attributes=[])
- addDatalist($label, $options=[], $attributes = [])
- addDate($label,$attributes=[])
- addDatetime($label,$attributes=[])
- addDatetimeLocal($label,$attributes=[])
- addEditor($label,$attributes=[])
- addEmail($label,$attributes=[])
- addFieldset($attributes=[])
- addFile($label,$attributes=[])
- addHidden($label,$attributes=[])
- addHtml($html)
- addImage($label,$attributes=[])
- addMonth($label,$attributes=[])
- addNumber($label,$attributes=[])
- addPassword($label,$attributes=[])
- addPhone($label,$attributes=[])
- addRadio($label,$options=[],$attributes=[])
- addRange($label,$attributes=[])
- addReset($label,$attributes=[])
- addSearch($label,$attributes=[])
- addSelect($label,array $options = [],$attributes=[])
- addSubmit($label,$attributes=[])
- addText($label,$attributes=[])
- addTextarea($label,$attributes=[])
- addTime($label,$attributes=[])
- addUrl($label,$attributes=[])
- addVideo($label,$attributes=[])
- addWeek($label,$attributes=[])
- addYesNo($label,$attributes=[])
- Close($print=true)

## Usage: 

#### Installation And Initialisation
```php
require_once 'FormGenerator.php';
$form = new Iriven\FormGenerator()
```
##### Example 

PhpFormGenerator provides a fluent method of form creation, allowing you to do:

```php
    $form->Open(['method'=>'post'])
    ->addFieldset(['legend'=>'Etat-Civil'])
    ->addText('nom')
    ->addText('prenom')
    ->addYesNo('es-tu content?')
    ->addDate('aniversaire')
    ->addCheckbox('votre sexe',['M','F'])
    ->addCountry('votre pays')
    ->addFieldset(['legend'=>'Informations Générales'])
    ->addSelect('SimpleSelect',['0'=>'faux','1'=>'vrai'])
    ->addSelect('OptGroupSelect',['collaborateurs'=>['0'=>'aucun','1'=>'1 personne','6'=>'6 personnes'],'auteur'=>['2'=>'alfred','3'=>'iriven','4'=>'iriventeam']],['name'=>'selection2','value'=>'3'])
    ->addSelect('OptGroupMultiSelect',['collaborateurs'=>['0'=>'aucun','1'=>'1 personne','6'=>'6 personnes'],'auteur'=>['2'=>'alfred','3'=>'iriven','4'=>'iriventeam']],['name'=>'selection3','multiple'=>'multiple'])
    ->addPassword('mot de passe')
    ->addCaptcha('Quel est le Resultat de')
    ->addFile('fichier')
    ->addAudio('audio')
    ->addImage('image')
    ->addVideo('video')
    ->addRange('intervalle',['step'=>'5'])
    ->addNumber('numero',['step'=>'5'])
    ->addSearch('recherche')
    ->addButton('bouton')
    ->addEmail('email')
    ->addPhone('telephone',['required'=>'required'])
    ->addTextarea('message')
    ->addSubmit('envoyer')
    ->Close();
```

## Authors

* **Alfred TCHONDJO** - *Project Initiator* - [iriven France](https://www.facebook.com/Tchalf)

## License

This project is licensed under the GNU General Public License V3 - see the [LICENSE](LICENSE) file for details

## Donation

If this project help you reduce time to develop, you can give me a cup of coffee :)

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XDCFPNTKUC4TU)

## Disclaimer

If you use this library in your project please add a backlink to this page by this code.

```html

<a href="https://github.com/iriven/PhpFormGenerator" target="_blank">This Project Uses Alfred's TCHONDJO PhpFormGenerator Library.</a>
```
