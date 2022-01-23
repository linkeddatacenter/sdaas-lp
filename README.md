![logo](http://linkeddata.center/resources/v4/logo/Logo-colori-trasp_oriz-640x220.png)

# A Linked Data proxy

A super simple Linked Data Proxy for SDaaS application. It is based on the official php:8-apache docker image

It allows the discovery of all rdf data dumps (i.e. files with .ttl, .nt, and .rdf extensions) contained in the directory data/rdf
according with the [void well-known uri specification](https://www.w3.org/TR/void/#well-known).

Just access the URI */.well-known/void* in the root of the web server.


# Quickstart

```
docker run -d --name test-lp -p 80:80 -v "${PWD}/tests/data":/var/www/html/data linkeddatacenter/sdaas-lp:1.0.2
curl -L http://localhost:80/.well-known/void
docker rm -f test-lp
```

Create your customized image substituting the file header.php in web root with one of your choice. 

```
FROM linkeddatacenter/sdaas-lp:1.1.1

COPY ./myheader.php /var/www/html/html/header.php
```

**WARNING: the default prefix : must be defined** see [example](https://github.com/linkeddatacenter/sdaas-lp/blob/main/webroot/header.php)


# Developers

Run functional tests:

```
docker run -d --name lp -p 80:80 -v "${PWD}":/app --workdir /app php:8-apache
docker exec -ti lp bash
ln -sf /app/webconf/host.conf /etc/apache2/sites-enabled/000-default.conf && \
ln -sf /app/webroot/* /var/www/html/ && \
ln -sf /app/tests/data /var/www/html/data && \
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
docker build -t lp . && docker run -d --name lp -p 8080:80  lp && sleep 2
if [ $(curl -L http://localhost:8080/.well-known/void  | wc -l) -eq 23 ]; then echo "INTEGRATION TEST FAILED"; else echo "INTEGRATION OK"; fi
docker rm -f lp && docker image rm lp
```

A new docker image is automatically pushed on any successfully commit to master branch by codefresh.yaml script.



To push a new docker image to docker hub:

```
docker login
# input the docker hub credentials...
docker build -t linkeddatacenter/sdaas-lp .
docker tag linkeddatacenter/sdaas-lp linkeddatacenter/sdaas-lp:1.1.1
docker push linkeddatacenter/sdaas-lp
docker push linkeddatacenter/sdaas-lp:1.1.1
```


## Credits and license

Copyright (C) 2018-2022 LinkedData.Center SRL
 - All Rights Reserved
 
Permission to copy and modify is granted under the [MIT license](LICENSE)
