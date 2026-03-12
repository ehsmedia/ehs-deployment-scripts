<?php

namespace Deployer;

/**
 * @param string $env The environment type.
 * @param array{dedi: string, user: string, url: string, deploy_folder: string, keep_releases: int, shared_deploy?: string} $config Host configuration
 * @return void
 */
function setup_host(string $env, array $config) {
    host($env)
        ->set('hostname', $config["dedi"])
        ->set('port', 222)
        ->set('remote_user', $config["user"])
        ->set('remote_url', $config["url"])
        ->set('deploy_path', '~/public_html/' . $config["deploy_folder"])
        ->setLabels(['stage' => $env])
        ->set('keep_releases', $config["keep_releases"])
        ->set('shared_path', '~/public_html/' . ($config['shared_deploy'] ?? $config["deploy_folder"] ) . "/shared")
        ->set("http_user", "www-data")
        ;
}


/**
 * @param "laravel"|"typo3"|"wordpress" $type
 * @param string|null $version
 * @return void
 */
function define_project_type(string $type, ?string $version = null) {
    switch ($type) {
        case "laravel":
            require_once "ehs_laravel.php";
            break;
        case "typo3":
            require_once "ehs_typo3.php";
            break;
        case "wordpress":
            require_once "ehs_wordpress.php";
            break;
        default:
            throw new \Exception("Type " . $type . " is not defined as a possible option.");
    }

    setup($version);
    after("deploy:failed", "deploy:unlock");
}


add('clear_paths', [".deployment", ".ddev"]);
set('clear_files', ["deployer.php", "README.md"]);

desc("Clear files using the find -delete command.");
task("ehs:clear_files", function() {
    foreach (get("clear_files") as $file) {
        run("find {{release_path}} -type f -name \"".$file."\" -delete");
    }
});


desc("Validate if the deployment is set up for the correct type.");
task("ehs:validate", function() {
    writeln("EHS Set up for: " . get("ehs_type"));
});