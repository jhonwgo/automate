<?php

class Repository
{
    private $name;
    private $version;
    private $dependencies;

    public function __construct($name, $version)
    {
        $this->name = $name;
        $this->version = $version;
        $this->dependencies = array();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getDependencies()
    {
        return $this->dependencies;
    }

    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
    }

    public function addDependency($dependency)
    {
        $this->dependencies[] = $dependency;
    }
}