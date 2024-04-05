![logo](http://linkeddata.center/resources/v4/logo/Logo-colori-trasp_oriz-640x220.png)

# A Linked Data lake proxy

A super simple Linked Data lake Proxy for SDaaS application. It is based on the official php:8-apache docker image

It allows the discovery of all rdf data dumps (i.e. files with .ttl, .nt, and .rdf extensions) contained in the directory data/rdf
according with the [void well-known uri specification](https://www.w3.org/TR/void/#well-known).

Just access the URI */.well-known/void* in the root of the web server.


# Quickstart

```
docker compose up -d --build
curl -L http://localhost/.well-known/void
apt-get update -y && apt-get install -y bats raptor2-utils
bats /app/tests/functional
exit
if [ $(curl -L http://localhost/.well-known/void  | wc -l) -eq 23 ]; then echo "INTEGRATION TEST FAILED"; else echo "INTEGRATION OK"; fi
docker compose down
```

## Push to docker hub

To push a new docker image to docker hub:

```
# docker login
# docker buildx create --name multi-arch-builder

NAME="linkeddatacenter/sdaas-lp" MAJOR="2" MINOR="1" PATCH="1"
docker buildx build --builder multi-arch-builder  --platform linux/arm64,linux/amd64 --build-arg MODE=prod --push -t $NAME:$MAJOR.$MINOR.$PATCH .
```


## Credits and license

Copyright (C) 2018-2024 LinkedData.Center SRL
 - All Rights Reserved
 
Permission to copy and modify is granted under the [MIT license](LICENSE)
