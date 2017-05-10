<?php

namespace App\Listeners;

use App\Events\UpdateWordNameEvent;
use App\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateWordListener
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
     * @param  UpdateWordNameEvent  $event
     * @return void
     */
    public function handle(UpdateWordNameEvent $event)
    {
        if($event->word->status == 1) {
            $event->word->order = 1;
            $event->word->save();
            $user = User::find($event->word->person);
            \Mail::send('emails.notice', ['user' => $user ], function ($email) use ($user) {
                $email->to($user->email)->subject('待办翻译事项');
            });
//            \Mail::send('emails.notice', ['user' => $user], function ($message) use( $user ) {
//                $someOne = $user->email;
//                $file = storage_path("/app/public/avatars/2/LtbVjFRFZ1Nz1MvTjgDgKq9yaapnAbri3NRWrDHL.jpeg");
//                $message->to($someOne)->subject("您有一个新的未处理事件");
//                $message->attach($file, ['as' => 'Dou Bi .jpg']);
//            });
            \Log::info(" Send Email to: $user->email 「 有未处理的翻译事件 」 at ".Carbon::now()->format("Y-m-d H:i"));
        }
    }
}
