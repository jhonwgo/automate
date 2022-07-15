<?php

require_once('classes/DependenciesTree.php');
require_once('classes/Repository.php');
require_once('classes/Dependency.php');
require_once('Composerfiles.php');

function check($repositoriePath, $commit, $branch, $directoriesFilePath){
    $composerFilePath="{$repositoriePath}/composer.json";
    if (!file_exists($composerFilePath)) {
        return array();
    }

    checkout($repositoriePath, $commit);
    $version = read_commit_tag($repositoriePath, $commit);
    if ($version == false){
        echo "invalid commit" . PHP_EOL;
        return array();
    }

    $repositories = getComposerFilesContents($directoriesFilePath);

    $depsTree = new DependenciesTree();

    foreach($repositories as $key => $repo){
        $repoName = isset($repo['name']) ? $repo['name'] : '';
        $repoVersion = isset($repo['version']) ? $repo['version'] : '';
        $repository = new Repository($repoName, $repoVersion);

        $deps = isset($repo['require']) ? $repo['require'] : array();
        foreach($deps as $key => $dep){ 
            $depName = $key;
            $depVersion = $dep;
            $dependency = new Dependency($depName, $depVersion);
            $repository->addDependency($dependency);
            
        }
        $depsTree->addRepository($repository);
    }       

    $repoChange = load_json_file($composerFilePath);
    echo "version: $version" . PHP_EOL;
    echo "name: $repoChange->name" . PHP_EOL;
    echo "all dependencies: " . PHP_EOL;
    return $depsTree->getAllDependencies($repoChange->name, $version);
}


function checkName($composerName, $directoriesFilePath){

    $repositories = getComposerFilesContents($directoriesFilePath);
    $depsTree = new DependenciesTree();

    foreach($repositories as $key => $repo){
        $repoName = isset($repo['name']) ? $repo['name'] : '';
        $repoVersion = isset($repo['version']) ? $repo['version'] : '';
        $repository = new Repository($repoName, $repoVersion);

        $deps = isset($repo['require']) ? $repo['require'] : array();
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


