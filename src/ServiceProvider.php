<?php

namespace Rochev\Laravel\SupportTickets;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Config\Repository as ConfigRepo;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Rochev\Laravel\SupportTickets\Console\Commands\ClearTicketsCommand;

/**
 * Class ServiceProvider
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /** @var string */
    private $package_root;

    /**
     * ServiceProvider constructor.
     *
     * @param Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->package_root = dirname(__FILE__, 2);
    }

    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        // Load Container stuff

        /** @var string $path_config */
        $path_config = $this->app->make('path.config');

        /** @var ConfigRepo $config */
        $config = $this->app->make(ConfigRepo::class);

        /** @var Schedule $schedule */
        $schedule = $this->app->make(Schedule::class);


        // Assets stuff

        $this->publishes([
            $this->package_root . '/config/tickets.php' => $path_config . '/tickets.php',
        ], 'config');

        $this->mergeConfigFrom(
            $this->package_root . '/config/tickets.php', 'tickets'
        );

        $this->loadRoutesFrom($this->package_root . '/routes/api.php');

        $this->loadMigrationsFrom($this->package_root . '/database/migrations');


        // App stuff

        $this->commands([
            ClearTicketsCommand::class,
        ]);

        $this->app->booted(function () use ($schedule, $config) {
            $schedule->command('tickets:clear')
                ->cron($config->get('tickets.cron'));
        });
    }
}
