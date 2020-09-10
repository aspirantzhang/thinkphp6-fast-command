<?php

declare(strict_types=1);

namespace aspirantzhang\thinkphp6FastCommand\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class Model extends Command
{
    protected $appPath;

    protected function configure()
    {
        $this->setName('make:fastModel')
            ->addArgument('model', Argument::OPTIONAL, "")
            ->setDescription('Model Name');
    }

    protected function execute(Input $input, Output $output)
    {
        $modelName = $input->getArgument('model') ?: '';
        $this->appPath = $this->app->getBasePath();

        $this->buildModel($modelName);
        $output->writeln("<info>Successed</info>");
    }

    protected function buildModel(string $modelName): void
    {
        $modelName = ucwords($modelName);
        $instanceName = strtolower($modelName);
        $filename = $this->appPath . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $modelName . '.php';

        if (!is_file($filename)) {
            $content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'controller.stub');
            $content = str_replace(['{%modelName%}', '{%instanceName%}'], [$modelName, $instanceName], $content);
            $this->checkDirBuild(dirname($filename));

            file_put_contents($filename, $content);
        }
    }

    protected function checkDirBuild(string $dirname): void
    {
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
    }
}
