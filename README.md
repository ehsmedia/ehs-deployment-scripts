# EHS Specific Deployment Recipes

This repository contains deployment recipes to be used in other projects
in order to simplify the deployment process.

## How to Install

Use Submodules!
`git submodule add git@github.com/ehsmedia/ehs-deployment-scripts.git .deployment`

This will create a new file .submodules that needs to be commited to the repository.

To use the submodule in a pulled repository ensure that you do "git submodule update --init"

If you want to update the submodule ensure to do "git submodule update --remote"

## Create Deployment Script

A Deployment script is written in the file `deploy.php` and should reside in the root folder of the repository.

The base script is as follows:
```php
namespace Deployer;

require ".deployment/ehs_base.php"

define_project_type("laravel/wordpress/typo3"); // Choose one of the available project types.

setup_host("environment", [ // Environment should be either staging or production
    "dedi" => "dediXXXX.your-server.de", // The hosting server.
    "user" => "user", // The SSH user
    "remote_url" => "url", // The url the deployment is accessible under.
    "deploy_folder" => "project_name", // The folder to deploy to. Usually project name.
    // "shared_path" => "project_name/shared", // Optional shared path to use (useful for staging.). Uncomment to use.
    "keep_releases" => 3, // The amount of releases to keep.
]);
```

Use this as a starting point.
Depending on the project you might need to add additional steps.
If that is the case ensure you add your changes AFTER the define_project_type call. Otherwise some base tasks might be missing.

For more information please check out the deployer documentation under https://deployer.org

This scripts expects Deployer version 8 which as I'm writing this, is still in beta / release candidate.