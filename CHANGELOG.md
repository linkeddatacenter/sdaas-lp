# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/). 

## unreleased



## 2.0.1

### Fixed
- issue #5 (void.ttl should be in root)

## 2.0.0

### changed
- php version moved to 8.2
- the knowledge base dct:modified attribute now takes into consideration also file deletion in dir and subdirs
- the uri of the datalake is fixed to <urn:sdaas:lp:datalake> 

### removed
- inclusion of header.php

## 1.1.1

### fixed
- issue #4 : rewind... https should run as root

### changed
- issue #2 now runs as www-data user (not root)

## 1.1.0

### changed
- issue #2 now runs as www-data user (not root)

### fixed
- issue #3 : creates data/rdf dir if not exists


## 1.0.3

### fixed
- issue #1

## 1.0.2

### Changed
- README and Header in webroot
## 1.0.1

### Removed
- test data from distribution

## 1.0.0

First release

