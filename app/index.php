<?php

//***************************************
// Setup your application envinornment
// and then start defining some routes!
//***************************************


//Register the Standard View into the application container.
\App::make('View','\App\view\Standard');

Router::get('/login','\App\controller\Root@getLogin');
Router::post('/login','\App\controller\Root@postLogin');

Router::get('/signup','\App\controller\Root@getSignup');
Router::post('/signup','\App\controller\Root@postSignup');



Router::auth('user','/login')->filter('/{*}')->to(function(){

    Router::get('/','App\controller\ToDo@getIndex');
    Router::post('/','App\controller\ToDo@postCreate');
    Router::post('/{id}','App\controller\ToDo@postUpdate')->where('id','integer');
    Router::post('/{id}/delete','App\controller\ToDo@postDelete')->where('id','integer');
    Router::post('/{id}/complete','App\controller\ToDo@postCompleted')->where('id','integer');


    Router::get('/logout', function(){
        \Session::destroy();
        \View::redirect('/login');
    });

});


?>
