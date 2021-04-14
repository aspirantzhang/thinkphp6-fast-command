<?php

declare(strict_types=1);

namespace aspirantzhang\thinkphp6FastCommand\command\misc;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\helper\Str;
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
        $output->writeln('<info>Earsing all table\'s data...</info>');

        $this->emptyTable();

        $output->writeln('<info>...Done.</info>');
    }

    protected function emptyTable()
    {
        $tables = Config::get('model.reserved_table');
        if (!empty($tables)) {
            foreach ($tables as $table) {
                Db::execute("TRUNCATE TABLE " . $table);
            }
        }
    }
}
