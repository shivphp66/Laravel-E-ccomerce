<?php

namespace App\Listeners;
use App\Mail\OrderEmail as OrderEmailMailable;
use App\Events\OrderEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;

class NotifyUsersOrderEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */

    public function handle(OrderEmail $event): void
    {

        $order = Order::where('id',$event->orderId)->with('items')->first();
            if($event->userType=="customer"){
                $subject = "Thanks for your order";
                $email = $order->email;
            }
            else{
                    $subject = "You have rivieved ad order";
                    $email = env('ADMIN_EMAIL');
            }
            $mailData = ['subject' =>$subject,'order'=>$order,'userType'=>$event->userType];
            Mail::to($email)->send(new OrderEmailMailable($mailData));
    }
}
