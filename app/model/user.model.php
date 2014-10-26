<?php
//This Model Class was generated with Disco on: Sat, 25 Oct 14 12:52:13 -0400
Class user extends Disco\classes\Model {

    public $table = 'user';
    public $ids = 'id';


    public function signup($data){
        $data['password'] = Crypt::hash($data['password']);

        if($this->emailInUse($data['email'])){
            return -1;
        }//if

        $id = $this->insert($data);

        if($id)
            return $id;

        return 0;

    }//signup

    public function signin($email,$password){
        $row = $this->select('id')
            ->where(Array('email'=>$email,'password'=>Crypt::hash($password)))
            ->data()->fetch_assoc(); 

        if($row['id']){
            Session::set('user',$row['id']);
            Session::regen();
            return true;
        }//if

        return false;
    }//signin


    public function emailInUse($email){
        $result = $this->select('email')->where(Array('email'=>$email))->data();
        if($result->num_rows != 0){
            return true;
        }//if
        return false;
    }//emailInUse



}//user   
?>
