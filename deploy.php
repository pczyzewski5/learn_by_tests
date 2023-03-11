<?php

namespace Deployer;

require 'recipe/symfony.php';
require 'contrib/rsync.php';

// Config
set('rsync', [
    'exclude'      => [
        '.git',
        'deploy.php',
        '.env.local',
        '.env.local.php',
        '.env.*.local',
        'config/secrets/prod/prod.decrypt.private.php',
        'public/bundles/',
        'var/',
        'phpunit.xml',
        'phpunit.xml.dist',
        '.phpunit.result.cache',
        '.idea',
        'docker/',
        'Makefile',
        'docker-compose.yml',
        '.revision',
        '.gitignore',
        'vendor/'
    ],
    'exclude-file' => false,
    'include'      => [],
    'include-file' => false,
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'rz', // Recursive, with compress
    'options'      => ['delete'],
    'timeout'      => 60,
]);
set('rsync_src', '/data/application');
set('rsync_dest', '/home/southpaw/domains/learnbytests.pl');
set('deploy_path', '/home/southpaw/domains/learnbytests.pl');

// Hosts
host('s148.cyber-folks.pl')
    ->set('remote_user', 'southpaw')
    ->set('port', 222);

// Hooks
task('deploy', [
    'rsync',
])->desc('Deploy your project');
