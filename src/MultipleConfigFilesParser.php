<?php

declare(strict_types=1);

namespace Othillo\ExposePhpFpmSettings;

final class MultipleConfigFilesParser
{
    public function __construct(private readonly ConfigFileParser $configFileParser)
    {
    }

    /**
     * @return string[]
     */
    public function parse(array $configFiles): array
    {
        $result = [];

        foreach ($configFiles as $configFile) {
            $result = array_merge($result, $this->configFileParser->parse($configFile));
        }

        return $result;
    }
}
