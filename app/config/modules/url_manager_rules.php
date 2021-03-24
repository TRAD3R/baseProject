<?php

use App\App;

$project_rules = [
    App::PROJECT_ID_TRAD3R => [
        //MAIN

        //ADMIN
        'admin/introduce'           => 'admin/auth/login',
        'admin/logout'              => 'admin/auth/logout',
        'admin/'                    => 'admin/site/index'

    ]
];

return $project_rules[PROJECT_ID];