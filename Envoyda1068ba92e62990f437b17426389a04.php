<?php $exitCode = isset($exitCode) ? $exitCode : null; ?>
<?php $__container->servers(['localhost' => '127.0.0.1']); ?>

<?php $__container->startMacro('code-setup'); ?>
    pull-code
    install-dependencies
    setup-database
    generate-app-key
    clear-and-cache
    generate-docs
<?php $__container->endMacro(); ?>

<?php $__container->startTask('pull-code'); ?>
    git pull origin hamid_dev
<?php $__container->endTask(); ?>

<?php $__container->startTask('install-dependencies'); ?>
    composer install
<?php $__container->endTask(); ?>

<?php $__container->startTask('setup-database'); ?>
    php artisan migrate:refresh --seed
<?php $__container->endTask(); ?>

<?php $__container->startTask('generate-app-key'); ?>
    php artisan key:generate
<?php $__container->endTask(); ?>

<?php $__container->startTask('clear-and-cache'); ?>
    php artisan optimize
<?php $__container->endTask(); ?>

<?php $__container->startTask('generate-docs'); ?>
    php artisan scribe:generate
<?php $__container->endTask(); ?>

<?php $_vars = get_defined_vars(); $__container->finished(function($exitCode = null) use ($_vars) { extract($_vars); 
    if ($exitCode > 0) {
        echo "Done"
    }
}); ?>