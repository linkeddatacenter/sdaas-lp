# Copyright (C) 2021 LinkedData.Center - All Rights Reserved
FROM php:8-apache

COPY ./webroot /var/www/html
COPY ./webconf/host.conf /etc/apache2/sites-enabled/000-default.conf
RUN mkdir -p /var/www/html/data/rdf && chown -R www-data.www-data /var/www/html/data/rdf

RUN a2enmod rewrite


