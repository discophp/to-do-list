<?php

Router::get('/logout',function(){
    Session::remove('user');
    Session::regen();
    header('Location: /');
    exit;
});

Router::get('/',function(){
    $data = Array();

    $data['to_do'] = Model::m('to_do')->todos();
    Template::with('user/index',$data); 

    View::script('todo.user.createToDo();');
    View::script('todo.user.finishedToDo();');
    View::script('todo.user.deleteToDo();');
});

Router::post('/create',function(){
    View::isAjax();
    $id = Model::m('to_do')->createToDo(Data::post('create-to-do'));
    if($id){
        Template::with('user/to-do',
            Array(
                'id'=>$id,
                'do'=>Data::post('create-to-do'),
                'created'=>'just now',
                'finished_class'=>'red',
                'finished_display'=>''
            )
        );
    }//if
    else {
        echo 0;
    }//el
});

Router::put('/finished',function(){
    View::isAjax();
    $res = Model::m('to_do')->update(Array('finished'=>Array('raw'=>'NOW()')))
        ->where(Array('user_id'=>Session::get('user'),'id'=>Data::put('finished-to-do')))
        ->finalize();
    if($res)
        echo 1;
    else 
        echo 0;
});

Router::delete('/delete/{id}',function($id){
    View::isAjax();

    if(!$id){
        return;
    }//if

    $res = Model::m('to_do')->delete(
        Array('id'=>$id,'user_id'=>Session::get('user'))
    );

    if($res)
        echo 1;
    else 
        echo 0;

})->where('id','integer');

