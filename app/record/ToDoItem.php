<?php
namespace App\record;

class ToDoItem extends \Disco\classes\Record {

    protected $model = '\App\model\ToDoItem';
    
    

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
  'user_id' => 
  array (
    'null' => false,
    'type' => 'int',
    'length' => '11',
  ),
  'title' => 
  array (
    'null' => false,
    'type' => 'varchar',
    'length' => '600',
  ),
  'description' => 
  array (
    'null' => true,
    'type' => 'text',
  ),
  'created_on' => 
  array (
    'null' => false,
    'type' => 'datetime',
  ),
  'completed_on' => 
  array (
    'null' => true,
    'type' => 'datetime',
  ),
);

    /**
     * @var null|string $autoIncrementField The autoincrement field name.
    */
    protected $autoIncrementField = 'id';




}//ToDoItem
