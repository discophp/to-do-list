<?php
namespace App\record;

class User extends \Disco\classes\Record {

    protected $model = '\App\model\User';
    
    

    /**
     * @var null|string $autoIncrementField The autoincrement field name.
    */
    protected $fieldDefinitions = array (
  'id' => 
  array (
    'null' => false,
    'type' => 'int',
    'length' => '11',
  ),
  'name' => 
  array (
    'null' => false,
    'type' => 'varchar',
    'length' => '180',
  ),
  'email' => 
  array (
    'null' => false,
    'type' => 'varchar',
    'length' => '420',
  ),
  'password' => 
  array (
    'null' => false,
    'type' => 'varchar',
    'length' => '180',
  ),
);

    /**
     * @var null|string $autoIncrementField The autoincrement field name.
    */
    protected $autoIncrementField = 'id';




}//User
