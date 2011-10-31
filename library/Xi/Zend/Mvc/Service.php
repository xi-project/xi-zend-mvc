<?php
namespace Xi\Zend\Mvc;

/**
 * Marker interface for classes that provide Domain services to the Controller
 * layer.
 */
interface Service
{
    /**
     * @param DependencyInjection\AbstractLocator $serviceLocator
     */
    public function __construct($serviceLocator);
}