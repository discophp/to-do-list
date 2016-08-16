<?php
namespace App\controller;

class Profile extends \Disco\classes\Controller {



    public function getEdit(){
        return $this->template('profile.html');
    }//getEdit



    public function postEdit(){

        $data = \Data::post(Array('name','email'));

        $result = \App::with('User')->update($data);

        if($result !== true){
            \Session::setComplexFlash('failedProfile', $result);
            \View::redirect('/profile/');
        }//if

        \Session::setFlash('successProfile', true);
        \View::redirect('/profile/');

    }//postEdit



    public function postUpdatePassword(){

        $data = \Data::post(Array('password','password_verify'));

        $result = \App::with('User')->updatePassword($data);

        if($result !== true){
            \Session::setComplexFlash('failedProfile', $result);
            \View::redirect('/profile/');
        }//if

        \Session::setFlash('successProfile', true);
        \View::redirect('/profile/');

    }//postUpdatePassword



    public function postDelete(){

        if(\App::with('User')->delete()){
            \Session::flush();
            \Session::setFlash('profileDeleted', true);
            \View::redirect('/login');
        }//if

        \Session::setComplexFlash('failedProfile', Array('_general' => 'Cannot delete your profile at this time!'));
        \View::redirect('/profile/');

    }//postDelete



}//Profile
