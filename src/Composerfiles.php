<?php



function checkout($repository, $commit_or_branch_or_tag) {
    $command = "cd $repository && git checkout $commit_or_branch_or_tag";
    $result = shell_exec($command);
    return $result;
}


function get_tags($repository){
	$command = "cd $repository && git tag";
	$output = shell_exec($command);
	$tags = explode(PHP_EOL, $output);
	return $tags;
}


function isCommitValid($repository, $commitId)
{
    chdir($repository);
    $result = shell_exec("git branch --contains $commitId");
    if (gettype($result) === "string"){
        return true;
    }
    return false;
}


function read_commit_tag($repository, $commit) {
    if (isCommitValid($repository, $commit) == false)  return false;
    checkout($repository, $commit);
    $command = "cd $repository && git describe --tags";
    $result = shell_exec($command);
    $result = str_replace(array(' ', "\n", "\t", "\r"), '', $result);  
    return $result;
}


function getCommitFromTag($repository, $tag)
{
    checkout($repository, $tag);
    $command = "cd $repository && git log --format=%H -n 1 $tag";
    $commit = exec($command);
    $commit = str_replace(array(' ', "\n", "\t", "\r"), '', $commit);  
    return $commit;
}


function set_commit($path_dir, $tag){
    $old_path = getcwd();
    chdir($path_dir);
	$command = 'git init' ;
    $output = shell_exec($command);

    $command = 'git add -A';
    $output = shell_exec($command);

    $command = "git commit -m 'version: $tag'";
    $output = shell_exec($command);

    $command = "git tag $tag" ;
    $output = shell_exec($command);

    chdir($old_path);
}

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
        $repository = str_replace(array(' ', "\n", "\t", "\r"), '', $repository);        
        $composer_file = "$repository$composer_file_name";        
        if (file_exists($composer_file)) {
            $data = [];
            $data['composer_file'] = $composer_file;
            $data['repository'] = $repository;
            $repositories_to_process[] = $data;
        }        
    }

    $composer_files_contents = [];

    foreach ($repositories_to_process as $data) {
        $composer_file = $data['composer_file'];
        $repository = $data['repository'];
        $tags = get_tags($repository);
	    foreach($tags as $tag) {
            if($tag == NULL) continue;
            checkout($repository, $tag);
            $composer_file_content = file_get_contents($composer_file);
            $composer_file_json = json_decode($composer_file_content);
            $data_json = [];
            $data_json['composer_file_json'] = $composer_file_json;
            $data_json['version'] = $tag;
            echo "repository: {$repository}:{$tag}" . PHP_EOL;
            $composer_files_contents[] = $data_json;
        }      

    }
    
    foreach ($composer_files_contents as $data_json) {
        $composer_file_content = $data_json['composer_file_json'];
        if(!property_exists($composer_file_content, 'require')) continue;        
        $name = $composer_file_content->name;
        $version = $data_json['version'];
        $require = (array)$composer_file_content->require ;
        echo "nombre: {$name}:{$version}" . PHP_EOL;
        $result[] = [
            "name" => $name,
            "version" => $version,
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
    $repo['version']="1.0";
    $dependencies=[];
    $dependencies["repo2"]=1.0; //in-house
    $dependencies["repo1001"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo;

    $repo['version']="2.0";
    $dependencies=[];
    $dependencies["repo2"]=2.0; //in-house
    $dependencies["repo1001"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo;
    
    //repo2
    $repo['name']="repo2";
    $repo['version']="1.0";
    $dependencies=[];
    $dependencies["repo1002"]=1.0; //external
    $dependencies["repo1003"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo;

    $repo['version']="2.0";
    $dependencies=[];
    $dependencies["repo1002"]=1.0; //external
    $dependencies["repo1003"]=1.0; //external
    $dependencies["repo6"]=1.0; //in-house
    $repo['require']=$dependencies;
    $repositories[]=$repo;
    
    //repo3
    $repo['name']="repo3";
    $repo['version']="1.0";
    $dependencies=[];
    $dependencies["repo1"]=1.0; //in-house
    $dependencies["repo4"]=1.0; //in-house
    $dependencies["repo1004"]=1.0;
    $repo['require']=$dependencies;
    $repositories[]=$repo;    
    
    //repo4
    $repo['name']="repo4";
    $repo['version']="1.0";
    $dependencies=[];
    $dependencies["repo1003"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo; 
    
    //repo5
    $repo['name']="repo5";
    $repo['version']="1.0";
    $dependencies=[];
    $dependencies["repo1003"]=1.0; //external
    $repo['require']=$dependencies;
    $repositories[]=$repo; 

    //repo6
    $repo['name']="repo6";
    $repo['version']="1.0";
    $dependencies=[];
    $dependencies["repo5"]=1.0; //in-house
    $repo['require']=$dependencies;
    $repositories[]=$repo; 

    $repo['version']="2.0";
    $dependencies=[];
    $dependencies["repo5"]=1.0; //in-house
    $dependencies["repo3"]=1.0; //in-house
    $repo['require']=$dependencies;
    $repositories[]=$repo; 

    return $repositories;
}


function saveComposer($repositories, $path){
    $repositories_file = [];
    foreach($repositories as $repo){
        $version=$repo['version'];
        unset($repo['version']);
        $repoName=$repo['name'];  
        $filePath="{$path}{$repoName}/composer.json";

        $key = "{$path}{$repoName}/";    
        if (!in_array($key, $repositories_file)) {
            $repositories_file[]=$key;   
        }
        

        if (!file_exists($path.$repoName)) {
            mkdir($path.$repoName, 0777, true);
        }        
        file_put_contents($filePath,json_encode($repo));
        set_commit("{$path}{$repoName}/", $version);
    }  
    return $repositories_file;  
}

function deleteAll($str){
    if (is_file($str)){
        return unlink($str);
    }
    elseif (is_dir($str)){
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path){
            deleteAll($path);
        }

        $scan = glob(rtrim($str,'/').'/.git', GLOB_BRACE);
        foreach($scan as $index=>$path){
            deleteAll($path);
        }
        return rmdir($str);
    }
}

function deleteComposer($repositories, $path){
    foreach($repositories as $repo){
        $repoName=$repo['name'];

        if (file_exists($path.$repoName)) {  
            deleteAll($path.$repoName);    
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

