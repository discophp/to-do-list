<?php

//We are forcing the use of CSRF token for all `POST`,`DELETE`, and `PUT` operations,
//validate that we recieved a valid token
if(!Data::validateCSRFToken()){

    //If non-valid token was found, set a flash and redirect to previous page
    Session::setFlash('badToken',true);
    View::redirect($_SERVER['REQUEST_URI']);

}//if


//Register the Standard View into the application container.
\App::make('View','\App\view\Standard');


//Handle routes to login
Router::multi('/login', Array(
        'get'   => '\App\controller\Root@getLogin',
        'post'  => '\App\controller\Root@postLogin',
    ));

//Handle routes to signup 
Router::multi('/signup',Array(
        'get'   => '\App\controller\Root@getSignup',
        'post'  => '\App\controller\Root@postSignup',
    ));

//Filter routes to the authenicated portion of the app.
//If one of the routers nested routes matches but there is no `user` session going, redirect to `/login`.
Router::auth(\App\service\User::SESSION_KEY,'/login')->filter('/{*}')->to(function(){

    //Get main listing of to-dos 
    //Allow creation of to-do
    Router::multi('/',Array(
            'get'   => 'App\controller\ToDo@getIndex',
            'post'  => 'App\controller\ToDo@postCreate',
        ));

    //Handle routes for updating, deleting, and completing a to-do.
    Router::post('/{id}','App\controller\ToDo@postUpdate')
        ->where('id','integer_positive')
        ->children(Array(
            '/delete' => Array(
                'type' => 'post',
                'action' => 'App\controller\ToDo@postDelete',
            ),
            '/complete' => Array(
                'type' => 'post',
                'action' => 'App\controller\ToDo@postCompleted',
            ),
        ));

    //Allow updating profile information, changing password, and deleting account.
    Router::multi('/profile/',Array(
            'get'   => 'App\controller\Profile@getEdit',
            'post'  => 'App\controller\Profile@postEdit',
        ))
        ->children(Array(
            'password' => Array(
                'type'      => 'post',
                'action'    => 'App\controller\Profile@postUpdatePassword',
            ),
            'delete' => Array(
                'type'      => 'post',
                'action'    => 'App\controller\Profile@postDelete',
            ),
        ));

    //Handle route to log a user out, destroying their sesssion and sending them to the `/login` screen.
    Router::get('/logout', function(){
        Session::destroy();
        View::redirect('/login');
    });

});


?>
