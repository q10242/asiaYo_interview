<?php

namespace App\Jobs;

use App\Services\OrderInsert\OrderInsertFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


class OrderCreatedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $data) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;
        $currency = $data['currency'];
        $factory = new OrderInsertFactory($currency);
        $orderInsert = $factory->create();
        $orderInsert->orderInsert($data);
    }
}
