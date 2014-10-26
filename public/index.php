<?php
/**
 * Require the composer autoloader. 
*/
require(dirname(dirname(__FILE__)).'/vendor/autoload.php');

/**
 * YOUR APPLICATION LOGIC GOES BELOW
 * ---------------------------------
*/

$app = new Disco;


// Swap the View Facade With an Extended View Class.
Disco::make('View','StandardView');


//filter all authenticated requests to user router
Router::filter('/{*}')->to('user')->auth('user');

//filter all normal requests to the root router
Router::filter('/{*}')->to('root');


/**
 * ---------------------------------
 * YOUR APPLICATION LOGIC STAYS ABOVE 
*/
Disco::tearDownApp();
