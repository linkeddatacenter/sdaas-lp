<?php 
header('Content-Type: text/turtle');
include __DIR__."/header.php";

$scheme = $_GET["scheme"] ?? "http";
$host= $_GET["host"] ?? "lp";
$rootdir = 'data/rdf';

$dir = new RecursiveDirectoryIterator($rootdir);
$iterator = new RecursiveIteratorIterator($dir);
$regexIterator = new RegexIterator($iterator, '/^.+\.(ttl|rdf|nt)$/i', RecursiveRegexIterator::GET_MATCH);
$newestTimeStamp=0;
foreach ($regexIterator as $matches) {
    $filepath= $matches[0];
    $timestamp=filemtime($filepath);
    $newestTimeStamp=max($newestTimeStamp,$timestamp);
    $fileDate = date('c',filemtime($filepath));
    
    echo ":knowledge void:dataDump <$scheme://${host}/$filepath> .". PHP_EOL;
    echo "<$scheme://${host}/$filepath> dct:modified \"$fileDate\"^^xsd:dateTime ." . PHP_EOL;
}

$lastUpdated= date('c',$newestTimeStamp);

echo "\n<$scheme://${host}/.well-known/void> a void:DatasetDescription; foaf:primaryTopic :knowledge .\n";
echo ":knowledge dct:modified \"$lastUpdated\"^^xsd:dateTime.\n";