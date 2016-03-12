<?php

namespace Hip\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

/**
 *
USAGE:
app/console Hip:rebuild_database --runtests dev
 *
 *
 * Class RebuildDatabaseCommand
 * @package Hip\AppBundle\Command
 */
class RebuildDatabaseCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    private $rootDir;
    /**
     * @var string
     */
    private $env;

    protected function configure()
    {
        $this
            ->setName('Hip:rebuild_database')
            ->setDescription('Purges database, reloads fixtures, optionally runs tests')
            ->addArgument('env', InputArgument::REQUIRED, 'which environment?')
            ->addOption('runtests', null, InputOption::VALUE_NONE, 'Run the tests');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // eg. "--env=dev"
        $this->env = '--env=' . $input->getArgument('env');

        // eg. "/var/www/project/app/"
        $this->rootDir = $this->getContainer()->get('kernel')->getRootDir() . '/';

        /**
         * Flatten all the tables
         */
        $this->processFlattenTables();
        /**
         * Re-create schema
         */
        $this->processReCreateSchema();
        /**
         * Clear any doctrine caches
         */
        $this->processClearDoctrineCaches();
        /**
         * Load the Fixtures
         */
        $this->processLoadFixtures();

        /**
         * Run the tests if the option has been selected
         */
        if ($input->getOption('runtests')) {
            $this->processRunUnitTests();
            $this->processRunApiTests();
        }
    }

    private function processFlattenTables()
    {
        $process = new Process($this->rootDir . 'console doctrine:schema:drop ' . $this->env . ' --force');
        $this->runAndOutputProcess($process);
    }

    private function processReCreateSchema()
    {
        $process = new Process($this->rootDir . 'console doctrine:schema:create ' . $this->env);
        $this->runAndOutputProcess($process);
    }

    private function processClearDoctrineCaches()
    {
        $cacheTypes = ['metadata', 'query', 'result'];
        foreach ($cacheTypes as $cacheType) {
            $process = new Process($this->rootDir . 'console doctrine:cache:clear-' . $cacheType . ' ' . $this->env);
            $this->runAndOutputProcess($process);
        }
    }

    private function processLoadFixtures()
    {
        $process = new Process($this->rootDir . 'console doctrine:fixtures:load -n ' . $this->env);
        $this->runAndOutputProcess($process);
    }

    private function processRunUnitTests()
    {
        $process = new Process($this->rootDir . '../bin/codecept run unit');
        $this->runAndOutputProcess($process);
    }

    private function processRunApiTests()
    {
        $process = new Process($this->rootDir . '../bin/codecept run api');
        $this->runAndOutputProcess($process);
    }

    /**
     * @param Process $process
     *
     * @throws RuntimeException
     * @throws LogicException
     */
    private function runAndOutputProcess(Process $process)
    {
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new RuntimeException($process->getErrorOutput());
        }
        echo $process->getOutput();
    }
}
