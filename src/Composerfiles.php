<?php

function getComposerFilesContents($repositories_file)
{
    $repositories_file_content = file_get_contents($repositories_file);
    $repositories = explode("\n", $repositories_file_content);
    $repositories_to_process = [];
    $composer_file_name = "composer.json";

    foreach ($repositories as $repository) {
        $repository = str_replace(array('.', ' ', "\n", "\t", "\r"), '', $repository);
        $composer_file = "$repository$composer_file_name";
        
        if (file_exists($composer_file)) {
            $repositories_to_process[] = $composer_file;
        }        
    }

    $composer_files_contents = [];

    foreach ($repositories_to_process as $composer_file) {
        $composer_file_content = file_get_contents($composer_file);
        $composer_file_json = json_decode($composer_file_content);
        $composer_files_contents[] = $composer_file_json;
    }

    
    $result = [];

    foreach ($composer_files_contents as $composer_file_content) {
        $name = $composer_file_content->name;
        $require = (array)$composer_file_content->require;
        $result[] = [
            "name" => $name,
            "require" => $require
        ];        
       
    }
    
    return $result;
}

function generateComposer(){
    $repositories=[];

    $repo=[];
    $repo['name']="repo1";
    $repo['description']="Tests for a CI/CD system";
    $repo['type']="project";
    $repo['license']="MIT";
    $repo['autoload']=[
            'psr-4'=>[
                "src\\"=>"src/"
            ],
            'files'=>[
                "src/helpers.php"
            ]
        ];
    $repo['authors']=[
            [
                "name"=>"developer",
                "email"=>"developer@gmail.com"
            ]
        ];
    $repo['minimum-stability']="stable";
    $dependencies=[];
    $dependencies["repo2"]=1.0;
    $dependencies["repo1001"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo;

    $repo['name']="repo2";
    $dependencies=[];
    $dependencies["repo1002"]=1.0;
    $dependencies["repo1003"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo;

    $repo['name']="repo3";
    $dependencies=[];
    $dependencies["repo1"]=1.0;
    $dependencies["repo4"]=1.0;
    $dependencies["repo1004"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo;    
    
    $repo['name']="repo4";
    $dependencies=[];
    $dependencies["repo1003"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo; 

    $repo['name']="repo5";
    $dependencies=[];
    $dependencies["repo1003"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo; 

    $repo['name']="repo6";
    $dependencies=[];
    $dependencies["repo5"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo; 

    return $repositories;
}


function saveComposer($repositories, $path){
    $repositories_file = [];
    foreach($repositories as $repo){
        $repoName=$repo['name'];
        $filePath="{$path}{$repoName}/composer.json";
        $repositories_file[]="{$path}{$repoName}/";
        if (!file_exists($path.$repoName)) {
            mkdir($path.$repoName, 0777, true);
        }
        file_put_contents($filePath,json_encode($repo));
    }  
    return $repositories_file;  
}


function saveFile($path, $repositories_file){
    $fp = fopen($path, "w");
    foreach($repositories_file as $value){
        fwrite($fp, $value);
        fwrite($fp, "\r\n");
    }
    fclose($fp);
}


function load_json_file(string $file_path)
{
    $file_content = file_get_contents($file_path);
    $json_content = json_decode($file_content);
    return $json_content;
}

