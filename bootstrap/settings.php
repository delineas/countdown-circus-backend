<?php

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'settings' => [
            'sqlite_path' => 'sqlite:'.getenv('SQLITE_PATH')//'sqlite:database/db.sqlite'
        ]
    ]);
};