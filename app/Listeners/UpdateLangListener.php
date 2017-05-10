<?php

namespace App\Listeners;

use App\Events\UpdateLangEvent;
use App\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLangListener
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
     * @param  UpdateLangEvent  $event
     * @return void
     */
    public function handle(UpdateLangEvent $event)
    {
        if( $event->lang->status == 1 )
        {
            $event->lang->order = 1;
            $event->lang->save();
            $user = User::find($event->lang->person);
            \Mail::send('emails.notice', ['user' => $user ], function ($email) use ($user) {
                $email->to($user->email)->subject('待办翻译事项');
            });
            \Log::info(" Send Email to: $user->email 「 有未处理的翻译需求事件 」 at ".Carbon::now()->format("Y-m-d H:i"));
        }
    }
}
