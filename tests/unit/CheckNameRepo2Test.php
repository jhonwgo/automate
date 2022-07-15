<?php

require __DIR__ . '/vendor/autoload.php';



class CheckNameRepo1Test extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $repositoriesPath = "/tmp/";
    private $directoriesFilePath = "/tmp/repolist.txt";
    private $repository = "repo2";
    
    
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
        $total = count(checkName($this->repository, $this->directoriesFilePath));        
        $this->assertEquals($total, 6); //has 6 changes
    }
}