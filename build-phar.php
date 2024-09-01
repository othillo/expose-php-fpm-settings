#!/usr/bin/env php
<?php

declare(strict_types=1);

$pharFile = 'bin/expose-php-fpm-settings.phar';

if (file_exists($pharFile)) {
    unlink($pharFile);
}

$phar = new Phar($pharFile);
$phar->setSignatureAlgorithm(Phar::SHA512);
$phar->startBuffering();
$phar->addFile(__DIR__ . '/src/ConfigFileParser.php', '/src/ConfigFileParser.php');
$phar->addFile(__DIR__ . '/src/MultipleConfigFilesParser.php','/src/MultipleConfigFilesParser.php');
$phar->addFile(__DIR__ . '/src/PoolConfigParser.php','/src/PoolConfigParser.php');
$phar->addFile(__DIR__ . '/bin/expose-php-fpm-settings.php','/bin/expose-php-fpm-settings.php');

$phar->setStub("#!/usr/bin/env php\n" . $phar->createDefaultStub('bin/expose-php-fpm-settings.php'));
$phar->stopBuffering();

chmod($pharFile, 0755);
