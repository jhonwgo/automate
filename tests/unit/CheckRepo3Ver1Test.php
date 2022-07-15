<?php

require __DIR__ . '/vendor/autoload.php';



class CheckRepo3Ver1Test extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $repositoriesPath = "/tmp/";
    private $directoriesFilePath = "/tmp/repolist.txt";
    private $repository = "/tmp/repo3";
    private $version = "1.0";
    private $commitId = "";    
    
    
    protected function _before()
    {
        composer_gen($this->repositoriesPath, $this->directoriesFilePath);
        $this->commitId = getCommitFromTag($this->repository, $this->version);
    }

    protected function _after()
    {
        composer_del($this->repositoriesPath, $this->directoriesFilePath);
    }

    // tests
    public function testSomeFeature()
    {
        $total = count(check($this->repository, $this->commitId, "123", $this->directoriesFilePath));        
        $this->assertEquals($total, 1); //has 1 changes
    }
}