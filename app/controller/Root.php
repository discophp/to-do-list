<?php
namespace App\controller;

Class Root {


    public function __construct(){

        //if the user is logged in redirect back to index
        if(\App::with('User')->isLoggedIn()){
            \View::redirect('/');
        }//if

    }//__construct



    public function getLogin(){

        \View::title('Login');
        \Template::with('login');

    }//getLogin



    public function postLogin(){

        $data = \Data::post(Array('email','password'));

        if(!\App::with('User')->login($data['email'],$data['password'])){
            \Session::setFlash('failedLogin', true);
            \View::redirect('/login');
        }//if

        \View::redirect('/');

    }//postLogin



    public function getSignup(){

        \View::title('Signup');
        \Template::with('signup');

    }//getSignup


    public function postSignup(){

        $data = \Data::post(['name','email','password','password_verify']);

        $result = \App::with('User')->signup($data);

        if($result !== true){
            \Session::setComplexFlash('failedSignup', $result);
            \Session::setComplexFlash('failedSignupData', $data);
            \View::redirect('/signup');
        }//if

        \View::redirect('/');

    }//postSignup

}//Index
