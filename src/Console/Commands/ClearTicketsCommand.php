<?php

namespace Rochev\Laravel\SupportTickets\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Psr\Log\LoggerInterface;
use Rochev\Laravel\SupportTickets\Jobs\ClearTicketsJob;

/**
 * Class ClearTicketsCommand
 */
class ClearTicketsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tickets:clear';

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * ClearTicketsCommand constructor.
     *
     * @param ConfigRepository $configRepository
     * @param LoggerInterface $logger
     * @param Dispatcher $dispatcher
     */
    public function __construct(
        ConfigRepository $configRepository,
        LoggerInterface $logger,
        Dispatcher $dispatcher
    )
    {
        parent::__construct();

        $this->configRepository = $configRepository;
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->logger->debug('Call tickets:clear');

        $job = new ClearTicketsJob();
        $job->onQueue($this->configRepository->get('tickets.queue.name'));
        $job->onConnection(
            $this->configRepository->get('tickets.queue.connection',
                $this->configRepository->get('queue.default')
            )
        );
        $this->dispatcher->dispatch($job);

        return 0;
    }
}
