#!/usr/bin/env bash

find /etc/php/*/fpm/pool.d/ -type f -name *.conf | xargs ./expose-php-fpm-settings.php
