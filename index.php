<?php
define("ROOT", __DIR__ ."/");

require ROOT . 'vendor/autoload.php';

if(!$argv || count($argv) <= 1) {
    echo "Usage: php index.php [command] [--options]" . "\n" . "\n";
    echo "Give the following commands" . "\n";
    echo str_repeat("=", 50) . "\n" . "\n";
    $fileList = glob('app/cmds/*.php');
    foreach($fileList as $filename){
        //Use the is_file function to make sure that it is not a directory.
        if(is_file($filename)){
            echo str_replace(array("app/cmds/", ".php"), "", $filename) . "\n"; 
        }   
    }
    echo "\n";
    die;
}

$cmdTxt = $argv[1];
$cmdFile = ROOT . 'app/cmds/' . $cmdTxt . ".php";
if(file_exists($cmdFile)) {
    require $cmdFile;
    try {
        $cmd = new $cmdTxt(array_slice($argv, 2));
        $cmd->exec();
    } catch(Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "Given command not found!";
}