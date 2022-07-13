<?php

require __DIR__ . '/vendor/autoload.php';



class CheckRepo3Test extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $repositoriesPath = "/tmp/";
    private $directoriesFilePath = "/tmp/repolist.txt";
    
    protected function _before()
    {
        composer_gen($this->repositoriesPath, $this->directoriesFilePath);
    }

    protected function _after()
    {
        composer_del($this->repositoriesPath, $this->directoriesFilePath);
    }

    // tests
    public function testSomeFeature()
    {
        //check /tmp/repo3
        $total = count(check("/tmp/repo3/", "123", "123", $this->directoriesFilePath));        
        $this->assertEquals($total, 1); //has 1 changes
    }
}