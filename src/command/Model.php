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
            ->addArgument('model', Argument::OPTIONAL, "Model Name")
            ->setDescription('Model Name');
    }

    protected function execute(Input $input, Output $output)
    {
        $modelName = $input->getArgument('model') ?: '';
        $this->appPath = $this->app->getBasePath();

        $this->buildModel($modelName);
        $output->writeln("<info>...Done.</info>");
    }

    protected function buildModel(string $modelName): void
    {
        $modelName = parse_name($modelName, 1);
        $instanceName = parse_name($modelName);

        $type = ['controller', 'model', 'logic', 'service', 'route', 'validate'];

        foreach ($type as $type) {
            $filename = $this->appPath . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $modelName . '.php';

            if (!is_file($filename)) {
                $content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $type . '.stub');
                $content = str_replace(['{%modelName%}', '{%instanceName%}'], [$modelName, $instanceName], $content);
                $this->checkDirBuild(dirname($filename));
                file_put_contents($filename, $content);
            }
        }
    }

    protected function checkDirBuild(string $dirname): void
    {
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
    }
}
