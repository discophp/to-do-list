<?php

Router::get('/',function(){

    View::title('To Do List | Sample Disco PHP Framework Application');

    $data = Array();

    $data['signup'] = Form::from('user')->with(Array('email','password'))
        ->submitButton('<div class="signup button radius">Sign Up</div>')
        ->props('password',Array('type'=>'password'))
        ->props(Array('required'=>'required'))
        ->make();

    $data['signin'] = Form::from('user')->with(Array('email','password'))
        ->submitButton('<div class="signin button radius">Sign In</div>')
        ->props('password',Array('type'=>'password'))
        ->props(Array('required'=>'required'))
        ->make();


    Template::with('index',$data);

    View::script('user.signup();');
    View::script('user.signin();');

});

Router::post('/signup',function(){
    View::isAjax();
    echo Model::m('user')->signup(Data::post()->all());
});

Router::post('/signin',function(){
    View::isAjax();
    if(Model::m('user')->signin(Data::post('email'),Data::post('password'))){
        echo 1;
    }//if 
    else {
        echo 0;
    }//el
});

