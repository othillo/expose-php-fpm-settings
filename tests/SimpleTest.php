<?php

declare(strict_types=1);

namespace Othillo\ExposePhpFpmSettings;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SimpleTest extends TestCase
{
    #[Test]
    public function it_exposes_max_children(): void
    {
        $expected = [
            'phpfpm_max_children{pool="www",scrape_uri="unix:///run/php/php8.3-fpm.sock;/status"} 20',
            'phpfpm_start_servers{pool="www",scrape_uri="unix:///run/php/php8.3-fpm.sock;/status"} 2',
            'phpfpm_min_spare_servers{pool="www",scrape_uri="unix:///run/php/php8.3-fpm.sock;/status"} 1',
            'phpfpm_max_spare_servers{pool="www",scrape_uri="unix:///run/php/php8.3-fpm.sock;/status"} 3',
            'phpfpm_max_requests{pool="www",scrape_uri="unix:///run/php/php8.3-fpm.sock;/status"} 500',
        ];

        $configFile = __DIR__ . '/../fixtures/www.conf';

        $configFileParser = new ConfigFileParser(new PoolConfigParser());
        $result = $configFileParser->parse($configFile);

        self::assertEquals($expected, $result);
    }
}
