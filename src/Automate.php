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

    $repositories = getComposerFilesContents($directoriesFilePath);

    $depsTree = new DependenciesTree();

    foreach($repositories as $key => $repo){
        $repoName = isset($repo['name']) ? $repo['name'] : '';
        //$repoVersion = isset($repo['version']) ? $repo['version'] : '';
        $repoVersion = '';
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
    echo "changes: " . PHP_EOL;
    return $depsTree->getAllDependencies($repoChange->name, '');
}


function checkName($composerName, $directoriesFilePath){

    $repositories = getComposerFilesContents($directoriesFilePath);
    $depsTree = new DependenciesTree();

    foreach($repositories as $key => $repo){
        $repoName = isset($repo['name']) ? $repo['name'] : '';
        //$repoVersion = isset($repo['version']) ? $repo['version'] : '';
        $repoVersion = '';
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

    echo "changes: " . PHP_EOL;
    return $depsTree->getAllDependencies($composerName, '');
}

function composer_gen($repositoriesPath, $directoriesFilePath){
    $repositories = generateComposer();
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


