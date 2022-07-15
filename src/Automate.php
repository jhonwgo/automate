<?php

require_once('classes/DependenciesTree.php');
require_once('classes/Repository.php');
require_once('classes/Dependency.php');
require_once('Composerfiles.php');




function check($repositoriePath, $commit, $branch, $directoriesFilePath){
    #Check Whether the File exists or not
    $composerFilePath="{$repositoriePath}/composer.json";
    if (!file_exists($composerFilePath)) {
        return array();
    }

    #Checkout to the required commit
    checkout($repositoriePath, $commit);

    #Read the commit tag
    $version = read_commit_tag($repositoriePath, $commit);
    #Check whether the commit tag exists or not
    if ($version == false){
        echo "invalid commit" . PHP_EOL;
    #If the commit tag does not exist, no data will be fetched
        return array();
    }

    #Get the composer files from the directories
    $repositories = getComposerFilesContents($directoriesFilePath);

    #Create an object of DepedenciesTree class
    $depsTree = new DependenciesTree();

    #Traverse through all the repositories
    foreach($repositories as $key => $repo){
        $repoName = isset($repo['name']) ? $repo['name'] : '';
        $repoVersion = isset($repo['version']) ? $repo['version'] : '';
        $repository = new Repository($repoName, $repoVersion);

        #Create a key for the dependencies for each repository
        $deps = isset($repo['require']) ? $repo['require'] : array();
        #Traverse through all the dependencies for each repository
        foreach($deps as $key => $dep){ 
                $depName = $key;
                $depVersion = $dep;
                $dependency = new Dependency($depName, $depVersion);
                $repository->addDependency($dependency);
                
        }
        $depsTree->addRepository($repository);
    }       

    #Load the composer file
    $repoChange = load_json_file($composerFilePath);
    echo "version: $version" . PHP_EOL;
    echo "name: $repoChange->name" . PHP_EOL;
    echo "all dependencies: " . PHP_EOL;
    #Return the required data
    return $depsTree->getAllDependencies($repoChange->name, $version);
}


function checkName($composerName, $directoriesFilePath){
    #Get the composer files from the directories
    $repositories = getComposerFilesContents($directoriesFilePath);

    #Create an object of DepedenciesTree class
    $depsTree = new DependenciesTree();

    #Traverse through all the repositories
    foreach($repositories as $key => $repo){
        $repoName = isset($repo['name']) ? $repo['name'] : '';
        $repoVersion = isset($repo['version']) ? $repo['version'] : '';
        $repository = new Repository($repoName, $repoVersion);

        #Create a key for the dependencies for each repository
        $deps = isset($repo['require']) ? $repo['require'] : array();
        #Traverse through all the dependencies for each repository
        foreach($deps as $key => $dep){ 
            $depName = $key;
            $depVersion = $dep;
            $dependency = new Dependency($depName, $depVersion);
            $repository->addDependency($dependency);
            
        }
        $depsTree->addRepository($repository);
    }    
    echo "name: $composerName" . PHP_EOL;
    echo "all dependencies: " . PHP_EOL;
    #Return the required data
    return $depsTree->getAllDependenciesName($composerName);
}

function composer_gen($repositoriesPath, $directoriesFilePath){
    $repositories = generateComposer();
    deleteComposer($repositories, $repositoriesPath);
    $repositories_file = saveComposer($repositories, $repositoriesPath);
    saveFile($directoriesFilePath, $repositories_file);
}

function composer_del($repositoriesPath, $directoriesFilePath){
    $repositories = generateComposer();
    deleteComposer($repositories, $repositoriesPath);
    deleteFile($directoriesFilePath);
}

function composer_check($directoriesFilePath){
    $repositories = getComposerFilesContents($directoriesFilePath);    
    return count($repositories);
}


