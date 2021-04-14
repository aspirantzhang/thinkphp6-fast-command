<?php

declare(strict_types=1);

namespace aspirantzhang\thinkphp6FastCommand\command\misc;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\helper\Str;
use think\facade\Config;
use think\facade\Db;

class EmptyTable extends Command
{

    protected function configure()
    {
        $this->setName('misc:emptyTable')
            ->setDescription('Empty all tables');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('<info>Erasing reserved table\'s data...</info>');

        Config::load('api/model', 'model');
        $tables = Config::get('model.reserved_table');
        if (!empty($tables)) {
            foreach ($tables as $table) {
                $output->writeln('-> ' . $table);
                Db::execute("TRUNCATE TABLE " . $table);
            }
        }
        Db::execute("DROP TABLE IF EXISTS `unit_test`");

        $output->writeln('<info>...Done.</info>');
    }
}
