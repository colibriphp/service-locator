<?php

namespace Subapp\ServiceLocator;

/**
 * Interface ServiceInterface
 * @package Subapp\ServiceLocator
 */
interface ServiceInterface
{
  
  /**
   * @return mixed
   */
  public function getDefinition();
  
  /**
   * @param $definition
   * @return mixed
   */
  public function setDefinition($definition);
  
  /**
   * @return mixed
   */
  public function getName();
  
  
  /**
   * @param array $parameters
   * @return mixed
   */
  public function resolve(array $parameters = []);
  
}