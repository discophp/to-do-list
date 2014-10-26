<?php
//This Model Class was generated with Disco on: Sat, 25 Oct 14 12:52:24 -0400
Class to_do extends Disco\classes\Model {

    public $table = 'to_do';
    public $ids = Array('id','user_id');


    public function createTable(){
        return DB::query('
            CREATE TABLE `to_do` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `do` blob NOT NULL,
              `created` datetime NOT NULL,
              `finished` datetime DEFAULT NULL,
              `deleted` tinyint(1) NOT NULL DEFAULT 0,
              PRIMARY KEY (`id`,`user_id`)
            )');
    }//createTable


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
