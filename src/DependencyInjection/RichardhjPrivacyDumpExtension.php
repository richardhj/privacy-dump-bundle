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

namespace Richardhj\PrivacyDumpBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class RichardhjPrivacyDumpExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $config['database'] = $config['database'] ?? [];
        $config['options']  = $config['options'] ?? [];

        $container->getDefinition('privacy_dump.config_databases')
            ->replaceArgument(0, $config['database']);
        $container->getDefinition('privacy_dump.config_options')
            ->replaceArgument(0, $config['options']);
    }
}
