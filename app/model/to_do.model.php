<?php
//This Model Class was generated with Disco on: Sat, 25 Oct 14 12:52:24 -0400
Class to_do extends Disco\classes\Model {

    public $table = 'to_do';
    public $ids = Array('id','user_id');


    public function todos(){
        $result = $this->select('id,do,created,finished')
            ->where(Array('user_id'=>Session::get('user'),'deleted'=>'0'))
            ->order('created DESC')
            ->data();

        $data = Array();
        while($row = $result->fetch_assoc()){
            $row['finished_display']='';
            if($row['finished']){
                $row['finished_display'] = Html::p('finished: '.Util::timeSince($row['finished']));
            }//if

            $row['created'] = Util::timeSince($row['created']);

            $row['finished_class'] = ($row['finished']) ? 'green' : 'red';
            $row['finished_class1'] = $row['finished_class'];
            $data[] = $row;
        }//while

        return $data;

    }//todos

    public function createToDo($do){
        $id = $this->insert(
            Array(
                'do'=>$do,
                'user_id'=>Session::get('user'),
                'created'=>Array('raw'=>'NOW()')
            )
        );
        return $id;
    }//create


}//to_do   
?>
