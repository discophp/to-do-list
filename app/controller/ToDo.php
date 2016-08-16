<?php
namespace App\controller;

class ToDo {

    public function getIndex(){

        \View::title('Your To Dos');

        $model = new \App\model\ToDoItem;

        $data = [];

        $data['completed_total'] = $model->select('COUNT(*) AS total')
            ->where('completed_on IS NOT NULL AND user_id=?', \Session::get('user'))
            ->first()['total'];

        $data['toDos'] = $model->select('
                id,
                title,
                description,
                DATE_FORMAT(created_on,"%a %m/%d/%y %h:%i %p") AS created_on_pretty
            ')
            ->where('user_id=? AND completed_on IS NULL', \Session::get('user'))
            ->order('created_on DESC')
            ->asArray();

        \Template::with('index', $data);

    }//getIndex



    public function postCreate(){

        $data = \Data::post(['title','description']);

        $data['user_id'] = \Session::get('user');
        $data['created_on'] = ['raw' => 'NOW()'];

        $record = new \App\record\ToDoItem($data);

        try {

            $record->insert();

        } catch(\Disco\exceptions\Record $e){
            error_log($e->getMessage());            
            \Session::setFlash('toDoItemError', $e->getMessage());
        }//catch

        \View::redirect('/');

    }//postIndex



    public function postUpdate($id){

        $data = \Data::post(['title','description']);

        $data['id'] = $id;

        $record = new \App\record\ToDoItem($data);

        try {

            $record->update();

        } catch(\Disco\exceptions\Record $e){
            error_log($e->getMessage());            
            \Session::setFlash('toDoItemError', $e->getMessage());
        }//catch

        \View::redirect('/');

    }//putIndex



    public function postDelete($id){

        $record = new \App\record\ToDoItem(['id' => $id]);

        try {

            $record->delete();

        } catch(\Disco\exceptions\Record $e){
            error_log($e->getMessage());            
            \Session::setFlash('toDoItemError', $e->getMessage());
        }//catch

        \View::redirect('/');

    }//postDelete



    public function postCompleted($id){

        $record = new \App\record\ToDoItem(['id' => $id]);

        $record->completed_on = ['raw' => 'NOW()'];

        try {

            $record->update();

        } catch(\Disco\exceptions\Record $e){
            error_log($e->getMessage());            
            \Session::setFlash('toDoItemError', $e->getMessage());
        }//catch

        \View::redirect('/');

    }//postCompleted



}//ToDo
