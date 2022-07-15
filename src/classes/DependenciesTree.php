<?php

class DependenciesTree
{
    private $tree;

    public function __construct()
    {
        $this->tree = array();
    }

    public function getTree()
    {
        return $this->tree;
    }

    public function setTree($tree)
    {
        $this->tree = $tree;
    }

    public function addRepository($repository)
    {
        $this->tree[] = $repository;
    }



    public function getAllDependencies($repositoryName, $version){
        $list = array();
        $stack = array();

        #Add the root node to the stack of nodes to be treated.
        foreach($this->tree as $repo){
            if($repo->getName() == $repositoryName && $repo->getVersion() == $version){

                $stack[] = $repo;
                break;
            }
        }
        $first = false;

        #Treating the nodes while there are nodes in the stack.
        while(!empty($stack)){
            $repo = array_pop($stack);

            #Add the dependencies of the root node to the result list.
            if($first == true){
                $list[] = "{$repo->getName()}:{$repo->getVersion()}";
            }            

            $first = true;
            
            #Adding the child nodes of the node being treated to the stack to be treated later.
            foreach($this->tree as $subrepo){              

                foreach($subrepo->getDependencies() as $subsubrepo){
                    if($subsubrepo->getName() == $repo->getName() && $subsubrepo->getVersion()  == $repo->getVersion()){
                        $stack[] = $subrepo;
                    }                
                }
            }
        }
        return array_unique($list);
    }


    public function getAllDependenciesName($repositoryName){
        $list = array();
        $stack = array();

        #Add the root node to the stack of nodes to be treated.
        foreach($this->tree as $repo){
            if($repo->getName() == $repositoryName){
                $stack[] = $repo;
            }
        }
        $first = false;

        #Treating the nodes while there are nodes in the stack.
        while(!empty($stack)){
            $repo = array_pop($stack);

            #Add the dependencies of the root node to the result list.
            if($first == true){
                $key = "{$repo->getName()}:{$repo->getVersion()}";
                if (in_array($key, $list)) {
                    continue;
                }
                $list[] = $key;
            }            
            $first = true;
            
            #Adding the child nodes of the node being treated to the stack to be treated later.
            foreach($this->tree as $subrepo){      
                foreach($subrepo->getDependencies() as $subsubrepo){
                    if($subsubrepo->getName() == $repo->getName()){
                        $stack[] = $subrepo;
                    }                
                }
            }
        }
        return $list;
    }

}