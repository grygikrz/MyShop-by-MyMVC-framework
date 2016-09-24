<?php

namespace Core;

/**
 * Validation class
 *
 * 
 */
class Validation
{
    private $passed = false,
            $errors = array();


    public function __construct()
    {

    
    }



    public function check($source, $items = array())
    {
        //var_dump($items);
            foreach($items as $item => $rules)
            {
                foreach($rules as $rule => $rule_value)
                {
                    $value = $source[$item];

                    if($rule === 'required' && empty($value)){

                        $this->addError($item.' is required');
                    }else{

                        switch($rule) {

                            case 'min':
                                if(strlen($value) < $rule_value)
                                {
                                    $this->addError($item." must be a minimum of \"$rule_value\" characters");
                                }
                            break;

                            case 'max':
                                if(strlen($value) > $rule_value)
                                {
                                    $this->addError($item." must be a maximum of \"$rule_value\" characters");
                                }
                            break;
                            
                            case 'matches':
                                if($value != $source[$rule_value])
                                {
                                    $this->addError($rule_value." must matche ".$item);
                                }
                            break;
                            case 'unique':
                                $check = Model::select('SELECT username FROM users WHERE username='.$value);

                                if($check->count())
                                {
                                    $this->addError("Username ".$item." already exists!");
                                }
                            break;

                        }

                    }
                }
            }

            if(empty($this->errors)) {

                $this->passed = true;
            }
            return $this;
    }

    private function addError($error){

        $this->errors[] = $error;

    }

    public function errors(){

        return $this->errors;

    }

    public function passed(){

        return $this->passed;

    }

}

