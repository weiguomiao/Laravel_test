<?php

namespace App\Listeners;

use App\Events\OrderPost;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToOrderUser
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
     * @param  \App\Events\OrderPost  $event
     * @return void
     */
    public function handle(OrderPost $event)
    {
        //订单处理
        $order=Order::find($event->id);
        $order->express_type=$event->express_type;
        $order->express_no=$event->express_no;
        $order->status=3;
        $order->save();

        //发送邮件
        Mail::to($order->user)->queue(new \App\Mail\OrderPost($order));
    }
}
