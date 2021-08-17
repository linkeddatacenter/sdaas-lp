![logo](http://linkeddata.center/resources/v4/logo/Logo-colori-trasp_oriz-640x220.png)

# A Linked Data proxy

A super simple Linked Data Proxy for SDaaS application. It is based on the official php:8-apache docker image

It allows the discovery of all rdf data dumps (i.e. files with .ttl, .nt, and .rdf extensions) contained in the directory data/rdf
according with the [void well-known uri specification](https://www.w3.org/TR/void/#well-known).

Just access the URI */.well-known/void* in the root of the web server.


# Quickstart

```
docker run --rm  -p 80:80 linkeddatacenter:sdaas-lp
curl -L http://localhost:80/.well-known/void
```

Create your customized image substituting the file header.ttl in web root with one of your choice. 

```
FROM linkeddatacenter:sdaas-lp

COPY ./myvoidHeader.ttl /var/www/html/html/header.ttl
```

**WARNING: the default prefix : must be defined** see [example](https://github.com/linkeddatacenter/sdaas-lp/blob/main/webroot/voidHeader.php)


# Developers

Run functional tests:

```
docker run -d --name lp -p 80:80 -v "${PWD}":/app --workdir /app php:8-apache
docker exec -ti lp bash
ln -sf /app/webconf/host.conf /etc/apache2/sites-enabled/000-default.conf && \
ln -sf /app/webroot/* /var/www/html/ && \
a2enmod rewrite
service apache2 reload

# To run functional tests:
apt-get update -y && apt-get install -y bats raptor2-utils
bats tests/functional
exit
docker rm -f lp
```

Run integration tests:

```
docker build -t lp . && \
docker run -d --name lp -p 8080:80 lp && \
test $(curl -L http://localhost:8080/.well-known/void  | wc -l) -eq 23 || echo "😔 INTEGRATION TEST FAILED" && \
docker rm -f lp && \
docker image rm lp && echo "✔ INTEGRATION TEST OK"
```

A new docker image is automatically pushed on any succesfully commit to master branch by codefresh.yaml script.



To push a new docker image to docker hub:

```
docker login
# input the docker hub credentials...
docker build -t linkeddatacenter/sdaas-lp .
docker tag linkeddatacenter/sdaas-lp linkeddatacenter/sdaas-ce:1.0.0
docker push linkeddatacenter/sdaas-lp
docker push linkeddatacenter/sdaas-ce:1.0.0
```


## Credits and license

Copyright (C) 2018-2021 LinkedData.Center SRL
 - All Rights Reserved
 
Permission to copy and modify is granted under the [MIT license](LICENSE)
