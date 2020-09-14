<?php

declare(strict_types=1);

namespace aspirantzhang\thinkphp6FastCommand;

use think\Service as BaseService;

class Service extends BaseService
{
    public function boot()
    {
        $this->commands([
            'make:buildModel' => command\Model::class,
            'make:removeModel' => command\Remove::class,
        ]);
    }
}
