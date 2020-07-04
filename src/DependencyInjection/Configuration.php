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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('richardhj_privacy_dump');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                // Database configuration
                ->arrayNode('database')
                    ->prototype('array')
                        ->children()
                            // Connection parameters
                            ->scalarNode('host')->end()
                            ->scalarNode('port')->end()
                            ->scalarNode('user')->end()
                            ->scalarNode('password')->end()
                            ->scalarNode('database')->end()
                            ->scalarNode('dsn')->end()
                        ->end()
                    ->end()
                ->end()

                // Export configuration
                ->arrayNode('options')
                    ->prototype('array')
                        ->children()
                            // Table to include or exclude
                            ->arrayNode('tables_include')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('tables_exclude')
                                ->prototype('scalar')->end()
                            ->end()

                            // Table settings
                            ->arrayNode('tables')
                                ->prototype('array')
                                    ->children()
                                        ->booleanNode('truncate')->end()
                                        ->integerNode('limit')->end()
                                        ->arrayNode('filters')
                                            ->prototype('scalar')->end()
                                        ->end()

                                        // Converters
                                        ->arrayNode('converters')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('converter')->cannotBeEmpty()->end()
                                                    ->booleanNode('unique')->end()
                                                    ->scalarNode('cache_key')->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
