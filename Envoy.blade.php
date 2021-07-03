@servers(['localhost' => '127.0.0.1'])

@story('code-setup')
    pull-code
    install-dependencies
    setup-database
    generate-app-key
    clear-and-cache
    generate-docs
@endstory

@task('pull-code')
    git pull origin hamid_dev
@endtask

@task('install-dependencies')
    composer install
@endtask

@task('setup-database')
    php artisan migrate:refresh --seed
@endtask

@task('generate-app-key')
    php artisan key:generate
@endtask

@task('clear-and-cache')
    php artisan optimize
@endtask

@task('generate-docs')
    php artisan scribe:generate
@endtask