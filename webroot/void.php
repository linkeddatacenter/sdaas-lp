<?php 
header('Content-Type: text/turtle');

$scheme = $_GET["scheme"] ?? "http";
$host= $_GET["host"] ?? "lp";
$rootdir = 'data/rdf';
$dataLakeURI = 'urn:sdaas:lp:datalake';

$header= <<<EOD
@prefix void: <http://rdfs.org/ns/void#> .
@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix dct: <http://purl.org/dc/terms/> .
@prefix foaf: <http://xmlns.com/foaf/0.1/> .
@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .

<$scheme://$host/.well-known/void> a void:DatasetDescription; 
    foaf:primaryTopic <$dataLakeURI> 
.
<$dataLakeURI> a void:Dataset;
    dct:title "SDaaS linked data lake"@en;
    dct:description "Smart Data as a Service linked data lake, a collection of RDF resources to build a KEES knowledge base."@en;
    void:feature <http://www.w3.org/ns/formats/Turtle>, <http://www.w3.org/ns/formats/N-Triples>, <http://www.w3.org/ns/formats/RDF_XML>
.

EOD;
echo $header;

// Get last modification of linked data files:
$dir = new RecursiveDirectoryIterator($rootdir);
$iterator = new RecursiveIteratorIterator($dir);
$regexIterator = new RegexIterator($iterator, '/^.+\.(ttl|rdf|nt)$/i', RecursiveRegexIterator::GET_MATCH);
$newestFileTimeStamp=0;
foreach ($regexIterator as $matches) {
    $filepath= $matches[0];
    $timestamp=filemtime($filepath);
    $newestFileTimeStamp=max($newestFileTimeStamp,$timestamp);
    $fileDate = date('c',$timestamp);
    
    echo "<$dataLakeURI> void:dataDump <$scheme://$host/$filepath> .". PHP_EOL;
    echo "<$scheme://$host/$filepath> dct:modified \"$fileDate\"^^xsd:dateTime ." . PHP_EOL . PHP_EOL;
}


// Get last modification of dirs:
$lastUpdatedDirTimeStamp=filemtime($rootdir);
$dirs = array_filter(glob("$rootdir/*"), 'is_dir');
foreach ($dirs as $dir) {
    $dirTimeStamp = filemtime($dir);
    $lastUpdatedDirTimeStamp = max($lastUpdatedDirTimeStamp,$dirTimeStamp);
}
$lastUpdated= date('c',$lastUpdatedDirTimeStamp);
echo "#### \n";
echo "<$dataLakeURI> dct:modified \"$lastUpdated\"^^xsd:dateTime." . PHP_EOL;
