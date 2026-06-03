<?php

namespace Deployer;

require "recipe/typo3.php";
require "custom_common.php"; // Require AFTER the base.

function setup(?string $version) {
	if(empty($version)) {
		$version = "13";
	}
	set("ehs_type", "typo3 version " . $version);
}

set('repository', 'file://.');
set('update_code_strategy', 'local_archive');

task("typo3:install:fixfolderstructure")->hidden()->disable();

set('vite_folder', 'public/_assets/vite');
set('vite_remote', '/public/_assets/');

add('clear_files', ["package.json", "package-lock.json", "pnpm-lock.yaml", "pnpm-worspace.yaml", "unlighthouse.config.mjs", "vite.config.mjs"]);

after("deploy:cleanup", "ehs:clear_files");
