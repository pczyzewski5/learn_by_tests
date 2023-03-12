<?php

namespace Deployer;

require 'contrib/rsync.php';

const APP_DIR = '/home/southpaw/domains/learnbytests.pl';

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
        'var',
        'phpunit.xml',
        'phpunit.xml.dist',
        '.phpunit.result.cache',
        '.idea',
        'docker/',
        'Makefile',
        'docker-compose.yml',
        '.revision',
        '.gitignore',
        'vendor'
    ],
    'exclude-file' => false,
    'include'      => [],
    'include-file' => '.env',
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'rz', // Recursive, with compress
    'options'      => ['delete'],
    'timeout'      => 60,
]);
set('rsync_src', '/data/application');
set('rsync_dest', APP_DIR . '/new_release');

// Hosts
host('s148.cyber-folks.pl')
    ->set('remote_user', 'southpaw')
    ->set('port', 222);

// Tasks
task('create previous_release dir', function() {
    run('rm -rf ' . APP_DIR . '/previous_release &&
    mkdir -p ' . APP_DIR . '/previous_release');
});
task('copy current_release to previous_release', function() {
    run('cp -r ' . APP_DIR . '/current_release/* ' . APP_DIR . '/previous_release/');
});
task('create current_release dir', function() {
    run('rm -rf ' . APP_DIR . '/current_release &&
    mkdir -p ' . APP_DIR . '/current_release');
});
task('copy new_release to current_release', function() {
    run('cp -r ' . APP_DIR . '/new_release/* ' . APP_DIR . '/current_release/');
});
task('copy prod env file', function() {
    run('cp ' . APP_DIR . '/.env.local ' . APP_DIR . '/current_release/');
});
task('install vendors', function() {
    run('cd ' . APP_DIR . '/current_release && composer install');
});


// Hooks
task('deploy', [
    'create previous_release dir',
    'copy current_release to previous_release',
    'rsync',
    'create current_release dir',
    'copy new_release to current_release',
    'copy prod env file',
    'install vendors',
])->desc('Deploy your project');
