<?php
namespace App\record;

class User extends \Disco\classes\Record {

    protected $model = '\App\model\User';
    
    
    /**
    * @var Array $validators The validation rules for the fields.
    */
    public static $validators = null;


    public static function autoIncrementField(){
        return 'id';
    }//autoIncrementField


    /**
     * Get the fields of the record.
     *
     *
     * @return array The fields.
     */
    public static function fieldNames(){
        return Array(
    
                'id',
                'name',
                'email',
                'password'
        );
    }//fields



    /**
     * Get the fields of the record. (Wrapper for `self::fields()`).
     *
     *
     * @return array The fields.
     */
    public function getFieldNames(){
        return self::fieldNames();
    }//getFields



    /**
     * Get the required fields of the record (cannot be NULL).
     *
     *
     * @return array The fields.
     */
    public static function requiredFieldNames(){
        return Array(
    
                    'name',
                    'email',
                    'password'
        );
    }//requiredFields



    /**
     * Get the required fields of the record. (Wrapper for `self::requiredFields()`).
     *
     *
     * @return array The fields.
     */
    public function getRequiredFieldNames(){
        return self::requiredFieldNames();
    }//getRequiredFields



    /**
    * Register the records validators into `self::$validators`.
    *
    *
    * @return void
    */
    public static function registerValidators(){
        if(!self::$validators){
            self::$validators = Array(
    
                'id' => \Respect\Validation\Validator::intType()->between(0,99999999999),
            
                'name' => \Respect\Validation\Validator::stringType()->length(0,180),
            
                'email' => \Respect\Validation\Validator::stringType()->length(0,420),
            
                'password' => \Respect\Validation\Validator::stringType()->length(0,180),
            
            );
        }//if
    }//__registerValidators



    /**
    * Determine if a value is valid for a records particular field.
    *
    *
    * @param string $field The field of the record.
    * @param string $v The value to test against the field.
    *
    * @return boolean Did it validate?
    */
    public static function validate($field, $v){
        self::registerValidators();

        if(is_numeric($v)){
            if(stripos($v,'.') !== false){
                $v = (float)$v;
            } else {
                $v = (int)$v;
            }//el
        }//if

        switch($field){

                case 'id' : 
                    return self::$validators['id']->validate($v) || parent::nullType($v) || parent::rawType($v);
            
                case 'name' : 
                    return self::$validators['name']->validate($v) || parent::rawType($v);
            
                case 'email' : 
                    return self::$validators['email']->validate($v) || parent::rawType($v);
            
                case 'password' : 
                    return self::$validators['password']->validate($v) || parent::rawType($v);
            
                default:
                    throw new \Disco\exceptions\Record("Record validation exception, record does not have a field `{$field}` to validate against");
        }//switch
    }//validate


}//User
