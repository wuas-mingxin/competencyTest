<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use App\Models\Department;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CreateUserEvent  $event
     * @return void
     */
    public function handle(CreateUserEvent $event)
    {
        $departmentIDs = Department::all()->pluck('id')->toArray();
        $randomIds = array_rand($departmentIDs, 2);
        $event->user->departments()->sync($randomIds);
    }
}
