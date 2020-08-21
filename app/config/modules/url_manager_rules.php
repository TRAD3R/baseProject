<?php
$project_rules = [
    \App\App::PROJECT_ID_TRAD3R => [
        //MAIN

        //ADMIN
        'admin/introduce'         => 'admin/auth/login',
        'admin/logout'            => 'admin/auth/logout',

    ]
];

return $project_rules[PROJECT_ID];