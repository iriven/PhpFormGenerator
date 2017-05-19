# PhpFormBuilder
The Ultimate PHP Form Builder Class is developed with the following goals in mind...

  - promotes rapid development of HTML forms through an object-oriented PHP framework.
  - Eliminate the grunt/repetitive work of writing the html when building forms.
  - Reduce human error by using a consistent/tested utility.
  
The Iriven Php FormBuilder adhere to W3C standards. 
Give it a try and let me know what you like, hate, and think needs to be fixed.

## Dependencies

- [x] [Iriven\WorldCountriesDatas](https://github.com/iriven/WorldCountriesDatas)
- [x] [Iriven\OptionsResolver](https://github.com/iriven/PhpOptionsResolver)

## Usage: 

#### Installation And Initialisation
```php
require_once 'PhpFormBuilder.php';
$form = new Iriven\PhpFormBuilder()
```
##### Example 

PhpFormBuilder provides a fluent method of form creation, allowing you to do:

```php
    $form->Create(['method'=>'post'])
    ->OpenFieldset(['legend'=>'Etat-Civil'])
    ->addText('nom')
    ->addText('prenom')
    ->addYesNo('es-tu content?')
    ->addDate('aniversaire')
    ->addCheckbox('votre sexe',['M','F'])
    ->addCountry('votre pays')
    ->CloseFieldset()
    ->OpenFieldset(['legend'=>'Informations Générales'])
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
    ->CloseFieldset()
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

<a href="https://github.com/iriven/PhpFormBuilder" target="_blank">This Project Uses Alfred's TCHONDJO PhpFormBuilder Library.</a>
```
