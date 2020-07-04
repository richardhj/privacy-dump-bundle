<?php

declare(strict_types=1);

/*
 * This file is part of richardhj/privacy-dump-bundle.
 *
 * Copyright (c) 2020-2020 Richard Henkenjohann
 *
 * @package   richardhj/privacy-dump-bundle.
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2020-2020 Richard Henkenjohann
 * @license   MIT
 */

namespace Richardhj\PrivacyDumpBundle\Config;

class Config
{
    private $configs;

    public function __construct(array $config)
    {
        $this->configs = $config;
    }

    public function get($name)
    {
        if (!\array_key_exists($name, $this->configs)) {
            throw new \LogicException("Could not find configuration for connection {$name}");
        }

        return $this->configs[$name];
    }
}
