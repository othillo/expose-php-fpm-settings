<?php

declare(strict_types=1);

namespace Othillo\ExposePhpFpmSettings;
final class PoolConfigParser
{
    /**
     * @return string[]
     */
    public function parse(string $pool, array $config): array
    {
        $unix_socket = $config['listen'] ?? null;
        $pm_max_children = $config['pm.max_children'] ?? null;
        $pm_start_servers = $config['pm.start_servers'] ?? null;
        $pm_min_spare_servers = $config['pm.min_spare_servers'] ?? null;
        $pm_max_spare_servers = $config['pm.max_spare_servers'] ?? null;
        $pm_max_requests = $config['pm.max_requests'] ?? null;

        if (null === $unix_socket) {
            throw new \RuntimeException('missing required unix_socket');
        }

        $result = [];
        if ($pm_max_children) {
            $result[] = sprintf('phpfpm_max_children{pool="%s",scrape_uri="unix://%s;/status"} %d', $pool, $unix_socket, $pm_max_children);
        }

        if ($pm_start_servers) {
            $result[] = sprintf('phpfpm_start_servers{pool="%s",scrape_uri="unix://%s;/status"} %d', $pool, $unix_socket, $pm_start_servers);
        }

        if ($pm_min_spare_servers) {
            $result[] = sprintf('phpfpm_min_spare_servers{pool="%s",scrape_uri="unix://%s;/status"} %d', $pool, $unix_socket, $pm_min_spare_servers);
        }

        if ($pm_max_spare_servers) {
            $result[] = sprintf('phpfpm_max_spare_servers{pool="%s",scrape_uri="unix://%s;/status"} %d', $pool, $unix_socket, $pm_max_spare_servers);
        }

        if ($pm_max_requests) {
            $result[] = sprintf('phpfpm_max_requests{pool="%s",scrape_uri="unix://%s;/status"} %d', $pool, $unix_socket, $pm_max_requests);
        }

        return $result;
    }
}
