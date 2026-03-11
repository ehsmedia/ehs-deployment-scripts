<?php

namespace Deployer;

require "recipe/laravel.php";
require "custom_common.php"; // Require AFTER the base.

function setup(?string $version) {
    if(empty($version)) {
        $version = "12";
    }
    set("ehs_type", "laravel version " . $version);
}

set('repository', 'file://.');
set('update_code_strategy', 'local_archive');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hooks

task('laravel:build', function () {
    runLocally('npm ci --include dev');
    runLocally('npm run build');
});

desc("Upload the builded assets folder to the project.");
task('laravel:upload', function () {
    upload('./public/build', '{{release_path}}/{{public_path}}/');
});

desc("Create assets and upload");
task('laravel:publish', [
    'laravel:build',
    'laravel:upload'
]);

// Hooks

after('deploy:update_code', 'laravel:publish');

task('deploy:publish', [
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success'
]);
