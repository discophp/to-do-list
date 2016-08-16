<?php
namespace App\view;

Class Standard extends \Disco\classes\View {

    public function header(){
        return \Template::render('header');
    }//header

    public function __construct(){

        $this->scriptSrc('http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
        $this->scriptSrc('/js/modernizr.js');
        $this->scriptSrc('/js/foundation.min.js');
        $this->scriptSrc('/js/js.js');

        $this->styleSrc('/css/foundation.min.css');
        $this->styleSrc('/css/css.css');

    }//construct

    public function footer(){
        return \Template::build('footer.html');
    }//footer


    public function callout($text, $type = 'alert', $close = ''){

        $button = '';

        if(is_string($close)){
            $button = '<button class="close-button" aria-label="Dismiss alert" type="button" data-close> <span aria-hidden="true">&times;</span></button>';
        }//if

        return "<div class='{$type} callout' data-closable='{$close}'><div>{$text}</div>{$button}</div>";

    }//callout

}//Standard

?>
