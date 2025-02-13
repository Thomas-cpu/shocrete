<?php

namespace Workdo\Hrm\Events;

use Illuminate\Queue\SerializesModels;

class CreateTransfer
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $request;
    public $transfer;

    public function __construct($request, $transfer)
    {
        $this->request = $request;
        $this->transfer = $transfer;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
