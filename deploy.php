<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'laenen.me');

// Project repository
set('repository', 'git@github.com:runelaenen/laenen.me.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', [
    '.env.local'
]);

set('shared_dirs', [
    'var/log',
    'var/sessions'
]);

set('shared_files', [
    '.env.local'
]);

set('writable_dirs', [
    'var'
]);

// Hosts
// For more information, please visit the Deployer docs: https://deployer.org/docs/configuration.html
host('srv1.laenen.me')
    ->stage('production')
    ->user('laenen')
    ->set('deploy_path', '/home/laenen/laenen.me')
    ->set('writable_mode', 'chmod');

desc('Build assets');
task('build', function () {
    run('composer install --no-dev');
    //run('yarn && yarn build');
})->local();

task('upload', function () {
    upload(__DIR__ . "/", '{{release_path}}');
});

desc('Clear cache');
task('deploy:cache:clear', function () {
    // composer install scripts usually clear and warmup symfony cache
    // so we only need to do it if composer install was run with --no-scripts
    if (false !== strpos(get('composer_options', ''), '--no-scripts')) {
        run('bin/console cache:clear');
    }
});

task('release', [
    'deploy:prepare',
    'deploy:release',
    'upload',
    'deploy:shared',
    'deploy:writable',
    'deploy:cache:clear',
    'deploy:symlink',
]);

task('deploy', [
    'build',
    'release',
    'cleanup',
    'success'
]);
