<?php

function getComposerFilesContents($repositories_file)
{
    $result = [];
    if (!file_exists($repositories_file)) {
        return $result;
    }

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
    
    foreach ($composer_files_contents as $composer_file_content) {
        if(!property_exists($composer_file_content, 'require')) continue;        
        $name = $composer_file_content->name;
        $require = (array)$composer_file_content->require ;
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

    //repo1
    $repo['name']="repo1";
    $dependencies=[];
    $dependencies["repo2"]=1.0; //in-house
    $dependencies["repo1001"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo;
    
    //repo2
    $repo['name']="repo2";
    $dependencies=[];
    $dependencies["repo1002"]=1.0; //external
    $dependencies["repo1003"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo;
    
    //repo3
    $repo['name']="repo3";
    $dependencies=[];
    $dependencies["repo1"]=1.0; //in-house
    $dependencies["repo4"]=1.0; //in-house
    $dependencies["repo1004"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo;    
    
    //repo4
    $repo['name']="repo4";
    $dependencies=[];
    $dependencies["repo1003"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo; 
    
    //repo5
    $repo['name']="repo5";
    $dependencies=[];
    $dependencies["repo1003"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo; 

    //repo6
    $repo['name']="repo6";
    $dependencies=[];
    $dependencies["repo5"]=1.0; //in-house
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

function deleteComposer($repositories, $path){
    foreach($repositories as $repo){
        $repoName=$repo['name'];
        $filePath="{$path}{$repoName}/composer.json";
        if (file_exists($filePath)) {
            unlink($filePath);           
        }
        if (file_exists($path.$repoName)) {
            rmdir($path.$repoName);         
        }
        
    }  
}


function saveFile($path, $repositories_file){
    $fp = fopen($path, "w");
    foreach($repositories_file as $value){
        fwrite($fp, $value);
        fwrite($fp, "\r\n");
    }
    fclose($fp);
}


function deleteFile($path){
    if (file_exists($path)) {
        unlink($path);
    }
}

function load_json_file(string $file_path)
{   
    $file_content = file_get_contents($file_path);
    $json_content = json_decode($file_content);
    return $json_content;
}

