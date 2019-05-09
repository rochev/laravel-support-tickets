<?php

namespace Rochev\Laravel\SupportTickets\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Psr\Log\LoggerInterface;
use Rochev\Laravel\SupportTickets\Entities\Ticket;

/**
 * Class ClearTicketsJob
 */
class ClearTicketsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * Execute the job.
     *
     * @param ConfigRepository $configRepository
     * @param LoggerInterface $logger
     * @return void
     */
    public function handle(
        ConfigRepository $configRepository,
        LoggerInterface $logger
    )
    {
        $logger->debug('Deleting old tickets started...');

        $hours = (int)$configRepository->get('tickets.delete_older');

        $count = Ticket::query()
            ->where('created_at', '<', Carbon::now()->subHours($hours))
            ->delete();

        $logger->debug('Deleting old ' . $count . ' tickets done!');
    }
}
