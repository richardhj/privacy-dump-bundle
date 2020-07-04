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

namespace Richardhj\PrivacyDumpBundle\Command;

use Richardhj\PrivacyDump\Config\Config as PrivacyDumpConfig;
use Richardhj\PrivacyDump\Dumper\DumperInterface;
use Richardhj\PrivacyDumpBundle\Config\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends Command
{
    protected static $defaultName = 'privacy-dump';

    private $dumper;
    private $databases;
    private $options;

    public function __construct(DumperInterface $dumper, Config $databases, Config $options)
    {
        $this->dumper    = $dumper;
        $this->databases = $databases;
        $this->options   = $options;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('privacy-dump')
            ->setDescription('Creates an anonymized database dump')
            ->addArgument('database', InputArgument::REQUIRED, 'What database configuration do you want to use?')
            ->addArgument('options', InputArgument::REQUIRED, 'What options configuration do you want to use?')
            ->addOption(
                'compression',
                'c',
                InputOption::VALUE_OPTIONAL,
                'How do you want to compress the file?',
                'null'
            )
            ->addOption('filename', 'name', InputOption::VALUE_OPTIONAL, 'A customized filename', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (null === $filename = $input->getOption('filename')) {
            $filename = (new \DateTime())->format('Y-m-d_H-i-s');
        }

        $databaseKey = $input->getArgument('database');
        $optionsKey  = $input->getArgument('options');

        $config = new PrivacyDumpConfig(
            array_merge(
                $this->options->get($optionsKey),
                ['database' => $this->databases->get($databaseKey)]
            )
        );

        $this->dumper->dump($config, TL_ROOT.'/'.$filename.'.sql');

        return 0;
    }
}
