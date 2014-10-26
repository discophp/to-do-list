<?php

Class StandardView extends Disco\classes\View {

    public function header(){
        if(Session::has('user')){
            return Template::build('user/header');
        }//if
        return Template::build('header');
    }//header

    public function __construct(){

        $this->scriptSrc('http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
        $this->scriptSrc('/scripts/modernizr.js');
        $this->scriptSrc('/scripts/foundation.min.js');
        $this->scriptSrc('/scripts/js.js');
        $this->styleSrc('/css/foundation.min.css');
        $this->styleSrc('/css/css.css');

        $this->bodyStyle('row collapse');

        $this->script('$(document).foundation();');

    }//construct

    public function footer(){
        return "";
    }//footer

}//Standard

?>
