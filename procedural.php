<?php  
/**
 *  Jacob Landowski
 *  For testing procedurally generated code.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

interface Type
{
    const PRIMITIVE = 'PRIMITIVE';
    const OBJECT    = 'OBJECT';

    public function getType();
    public function getPassType();
    public function isSameTypeAs($other);
}

class Integer implements Type
{
    public function getType()
    {
        return 'Integer';
    }

    public function getPassType()
    {
        return PRIMITIVE;
    }

    public function isSameTypeAs($other)
    {
        return $other instanceof self;
    }
}

// __invoke() magic method for when object is called as a function 
// __ toString() normal toString method, can't throw exceptions inside though 
// __set(prop, value) when trying to set non-existant/private object prop to something
// __get(prop) when trying to read non-existant/private object prop
// __isset(prop) when checking non-existant/private object prop
// __unset(prop) when deleting non-existant/private object prop

class Value
{
    private $_props = 
    [
        'data' => null,
        'type' => null
    ];

    public function __contruct(Type $type = null, $data = null)
    {
        if(empty($type) || !isset($type))
        {
            $trace = debug_backtrace();
            trigger_error(
                'Undefined Value type when instantiating Value object' .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE);   
        }

        $this->_type = $type;
        $this->_data = $data;
    }

    public function __set($prop, $value)
    {
        if(!array_key_exists($prop, $this->_props))
        {
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __set(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE);
        }

        $this->_props[$prop] = $value;
    }
}

class Variable
{
    private $_identifier;
    private $_value;
    private $_type;

    public function __construct(Type $type = null, $id = '', Value $value = null)
    {
        if(empty($id)   || !isset($id))   
            throw new Exception('Tried to instantiate Variable object without a identifier');
        
        if(empty($type) || !isset($type)) 
            throw new Exception('Tried to instantiate Variable object without a type');

        $this->_type = $type;
        $this->_identifier = $id;
        $this->_value = $value;
    }

    public function showInfo()
    {
        if($this->_value == null) $this->_value = 'null';

        echo "$this->_type $this->_identifier = $this->_value";
    }

    public function assign(Value $value)
    {
        if($value == null || $value.
    }
}

$var = new Variable(new Integer, 'x', 5);

$var->showInfo();