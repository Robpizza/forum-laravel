<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:Robpizza/laravel-forum.git');

add('shared_files', [
//    '.env'
]);
add('shared_dirs', []);
add('writable_dirs', [
//    'bootstrap/cache',
//    'storage',
//    'storage/app',
//    'storage/app/public',
//    'storage/framework',
//    'storage/framework/cache',
//    'storage/framework/sessions',
//    'storage/framework/views',
//    'storage/logs',
]);

task('artisan:migrate')->disable();

// Hosts
host('192.168.200.28')
    ->set('remote_user', 'deploy')
    ->set('deploy_path', '/var/www/forum-laravel.robpizza.nl')

    // Geleend van EO
    ->set('writable_chmod_recursive', false)
    ->set('writable_chmod_mode', 777)
    ->set('writable_use_sudo', false)
    ->set('keep_releases', 1);
// Hooks

after('deploy:failed', 'deploy:unlock');
