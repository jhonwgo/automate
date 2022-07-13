<?php

require __DIR__ . '/vendor/autoload.php';



class CheckRepo4Test extends \Codeception\Test\Unit
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
        //check /tmp/repo4
        $total = count(check("/tmp/repo4/", "123", "123", $this->directoriesFilePath));        
        $this->assertEquals($total, 2); //has 2 changes
    }
}