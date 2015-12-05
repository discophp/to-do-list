<?php
namespace App\controller;

Class Root {


    public function __construct(){

        if(\Session::has('user')){
            \View::redirect('/');
        }//if

    }//__construct



    public function getLogin(){

        \View::title('Login');

        $data = [];
        $data['flash'] = \Session::flash();

        \Template::with('login', $data);

    }//getLogin



    public function postLogin(){

        $data = \Data::post(Array('email','password'));

        $data['password'] = \Crypt::hash($data['password']);

        $record = \App\record\User::find($data,'id');

        if($record !== false){

            \Session::set('user', $record->id);
            \Session::regen();

            \View::redirect('/');

        }//if

        \Session::setFlash('failedLogin', true);

        \View::redirect('/login');

    }//postLogin



    public function getSignup(){

        \View::title('Signup');

        $data = [];
        $data['flash'] = \Session::flash();

        \Template::with('signup', $data);

    }//getSignup


    public function postSignup(){

        $data = \Data::post(['name','email','password']);

        $data['password'] = \Crypt::hash($data['password']);

        $record = new \App\record\User($data);

        try {

            $record->insert();

            \Session::set('user', $record->id);
            \Session::regen();

            \View::redirect('/');

        } catch(\Disco\exceptions\Record $e){

            \Session::setFlash('failedSignup', $e->getMessage());
            \View::redirect('/signup');

        }//catch


    }//postSignup

}//Index
