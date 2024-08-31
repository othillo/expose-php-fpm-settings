<?php

declare(strict_types=1);

namespace Othillo\ExposePhpFpmSettings;

final class ConfigFileParser
{
    public function __construct(
        private readonly PoolConfigParser $poolConfigParser
    ) {
    }

    /**
     * @return string[]
     */
    public function parse(string $configFile): array
    {
        $config = parse_ini_file($configFile, true);

        $result = [];

        foreach ($config as $pool => $poolConfiguration) {
            try {
                $result = array_merge($result, $this->poolConfigParser->parse($pool, $poolConfiguration));
            } catch (\RuntimeException) {
                continue;
            }
        }

        return $result;
    }
}
