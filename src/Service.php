<?php

namespace Subapp\ServiceLocator;

/**
 * Class Service
 * @package Subapp\ServiceLocator
 */
class Service implements ServiceInterface
{
  
  /**
   * @var string
   */
  protected $name;
  
  /**
   * @var mixed
   */
  protected $definition;
  
  /**
   * @var bool
   */
  protected $resolved = false;
  
  /**
   * @param $name
   * @param $definition
   */
  public function __construct($name, $definition)
  {
    $this->name = $name;
    $this->definition = $definition;
  }
  
  /**
   * @return mixed
   */
  public function getDefinition()
  {
    return $this->definition;
  }
  
  /**
   * @param mixed $definition
   * @return static
   */
  public function setDefinition($definition)
  {
    $this->definition = $definition;
    return $this;
  }
  
  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }
  
  /**
   * @param array $parameters
   * @return mixed|null|object
   * @throws ServiceLocatorException
   */
  public function resolve(array $parameters = [])
  {
    $instance = null;
    $definition = $this->definition;
    
    if (gettype($definition) === 'string') {
      
      if (class_exists($definition)) {
        
        try {
          $reflection = new \ReflectionClass($definition);
          
          $instance = count($parameters) > 0
            ? $reflection->newInstanceArgs($parameters)
            : $reflection->newInstance();
          
        } catch (\ReflectionException $e) {
          throw new ServiceLocatorException($e->getMessage());
        }
        
      } else {
        throw new ServiceLocatorException("Class not exists '{$definition}'");
      }
      
    } else {
      if (gettype($definition) === 'object') {
        
        if ($definition instanceOf \Closure) {
          $instance = call_user_func_array($definition, $parameters);
        } else {
          $instance = $definition;
        }
        
      } else if (gettype($definition) === 'array') {
        // @TODO smart build here
        throw new ServiceLocatorException('No implemented yet...');
      }
    }
    
    if ($instance !== null)
      $this->resolved = true;
    
    return $instance;
  }
  
  /**
   * @return bool
   */
  public function isResolved()
  {
    return $this->resolved;
  }
  
}