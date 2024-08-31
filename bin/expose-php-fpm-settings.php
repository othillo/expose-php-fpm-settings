#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/ConfigFileParser.php';
require_once __DIR__ . '/../src/MultipleConfigFilesParser.php';
require_once __DIR__ . '/../src/PoolConfigParser.php';

echo "# HELP php_fpm_max_children\n";
echo "# TYPE php_fpm_max_children gauge\n";

echo "# HELP phpfpm_start_servers\n";
echo "# TYPE phpfpm_start_servers gauge\n";

echo "# HELP phpfpm_min_spare_servers\n";
echo "# TYPE phpfpm_min_spare_servers gauge\n";

echo "# HELP phpfpm_max_spare_servers\n";
echo "# TYPE phpfpm_max_spare_servers gauge\n";

echo "# HELP phpfpm_max_requests\n";
echo "# TYPE phpfpm_max_requests gauge\n";

$parser = new \Othillo\ExposePhpFpmSettings\MultipleConfigFilesParser(
    new \Othillo\ExposePhpFpmSettings\ConfigFileParser(
        new \Othillo\ExposePhpFpmSettings\PoolConfigParser()
    )
);

$args = array_slice($argv, 1);

foreach($parser->parse($args) as $value) {
    echo "$value\n";
};
