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
        # This function returns a list of all dependencies for a given repository and version.
        # The function takes two parameters: the name of the repository and the version number.
        # First, an empty list and stack are created.
        $list = array();
        $stack = array();
        # Then, the tree is looped through to find the repository and version that were passed in.
        foreach($this->tree as $repo){
            /*
            if($repo->getName() == $repositoryName && $repo->getVersion() == $version){
                # If they are found, the repository is added to the stack.
                $stack[] = $repo;
            }
            */
            if($repo->getName() == $repositoryName){
                # If they are found, the repository is added to the stack.
                $stack[] = $repo;
            }
        }
        # Next, the stack is looped through.
        while(!empty($stack)){
            $repo = array_pop($stack);
            $list[] = $repo->getName();
            foreach($this->tree as $subrepo){
                # For each repository in the stack, its dependencies are looped through.
                foreach($subrepo->getDependencies() as $subsubrepo){
                    # If any of those dependencies match the repository being processed, the dependency is added to the stack.
                    if($subsubrepo->getName() == $repo->getName()){
                        $stack[] = $subrepo;
                    }
                }
            }
        }
        # Finally, the list is returned with any duplicate entries removed.
        return array_unique($list);
    }
}