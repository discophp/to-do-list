<?php
namespace App\service;

class User {


    const SESSION_KEY = 'user';


    private $loggedIn = false;

    private $id;

    private $cache;


    public function __construct(){
        if(\Session::has(self::SESSION_KEY)){
            $this->loggedIn = true; 
            $this->id = \Session::get(self::SESSION_KEY);
        }//if
    }//__construct



    /**
     * Whether the user is logged in.
     *
     * @return boolean
    */
    public function isLoggedIn(){
        return $this->loggedIn;
    }//loggedIn



    /**
     * Get the users id.
     *
     * @return int
    */
    public function id(){
        return $this->id;
    }//id



    /**
     * Get the name and email of the user.
     *
     * @return array
    */
    public function getData(){

        if($this->cache === null && $this->isLoggedIn()){
            $this->cache = (new \App\model\User)
                ->select('name,email')
                ->where('id=?',$this->id())
                ->first();
        }//if 

        return $this->cache;

    }//getData



    /**
     * Attempt to log a user in.
     *
     * @param string $email The users email.
     * @param string $password The users password.
     *
     * @return boolean
    */
    public function login($email,$password){

        $password = \Crypt::hash($password);

        $data = Array('email' => $email, 'password' => $password);

        $record = \App\record\User::find($data,'id');

        if($record !== false){

            \Session::set(self::SESSION_KEY, $record->id);
            \Session::regen();

            return true;

        }//if

        return false;

    }//login



    /**
     * Create/signup an account for a user.
     *
     * @param array $data An array containing the user data.
     *
     * @return boolean|array `true` when success, else an array of errors.
    */
    public function signup($data){


        $validate = $this->validateData($data);
        $validate = array_merge($validate,$this->validatePassword($data));

        if(count($validate)){
            return $validate;
        }//if

        $duplicate = \App\record\User::find(Array('email' => $data['email']),'id');

        if($duplicate !== false){
            return Array(
                'email' => 'That email address is already in use!'
            );            
        }//if

        $data['password'] = \Crypt::hash($data['password']);

        $record = new \App\record\User($data);

        try {

            $record->insert();

            \Session::set(self::SESSION_KEY, $record->id);
            \Session::regen();

            return true;

        } catch(\Disco\exceptions\Record $e){

            error_log($e->getMessage());
            return Array('_general' => 'Something went wrong creating your account, please try again');

        }//catch

    }//signup



    /**
     * Update a user.
     *
     * @param array $data An array containing the user data.
     *
     * @return boolean|array `true` when success, else an array of errors.
    */
    public function update($data){
        
        $validate = $this->validateData($data);

        if(count($validate)){
            return $validate;
        }//if

        $duplicate = \App\record\User::find(Array('email' => $data['email']),'id');

        if($duplicate !== false && $duplicate['id'] != $this->id()){
            return Array(
                'email' => 'That email address is already in use!'
            );            
        }//if


        $data['id'] = $this->id();

        $record = new \App\record\User($data);

        try {
            $record->update();
            return true;
        } catch(\Disco\exceptions\Record $e){
            error_log($e->getMessage());
            return Array('_general' => 'Something went wrong updating your account, please try again');
        }//catch

    }//update



    /**
     * Update a users password.
     *
     * @param array $data An array containing the user data.
     *
     * @return boolean|array `true` when success, else an array of errors.
    */
    public function updatePassword($data){
        
        $validate = $this->validatePassword($data);

        if(count($validate)){
            return $validate;
        }//if

        $data['id'] = $this->id();

        unset($data['password_verify']);

        $data['password'] = \Crypt::hash($data['password']);

        $record = new \App\record\User($data);

        try {
            $record->update();
            return true;
        } catch(\Disco\exceptions\Record $e){
            error_log($e->getMessage());
            return Array('_general' => 'Something went wrong updating your password, please try again');
        }//catch

    }//updatePassword



    /**
     * Delete the user.
     *
     * @return boolean
    */
    public function delete(){

        $record = new \App\record\User(Array('id' => $this->id()),'id');

        try {

            return $record->delete();

        } catch(\Disco\exceptions\Record $e){
            error_log($e->getMessage());
            return false;
        }//catch

    }//delete



    /**
     * Validate user data.
     *
     * @param array $data The users data to validate.
     *
     * @return array An array containing the errors.
    */
    private function validateData($data){

        $errors = Array();

        if(!$data['name'] || strlen($data['name']) < 2 || strlen($data['name']) > 180){
            $errors['name'] = 'Name is required and must be between 2 and 180 characters';
        }//if

        if(!$data['email'] || strpos($data['email'],'@',1) === false || strlen($data['name']) > 420){
            $errors['email'] = 'Email is required and must contain `@` and be less than 420 characters';
        }//if

        return $errors;
        
    }//validateData



    /**
     * Validate user password.
     *
     * @param array $data The users passwords to validate.
     *
     * @return array An array containing the errors.
    */
    private function validatePassword($data){

        $errors = Array();

        if(!$data['password'] || strlen($data['password']) < 4){
            $errors['password'] = 'Password is required and must be at least 4 characters long';
        }//if

        if($data['password'] !== $data['password_verify']){
            $errors['password_verify'] = 'Passwords do not match!';
        }//if

        return $errors;

    }//validatePassword



}//User
