<?php

namespace app\Listeners;

use Illuminate\Auth\Events\Login;

class SetUserSession
{
    /**
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        
    }
}