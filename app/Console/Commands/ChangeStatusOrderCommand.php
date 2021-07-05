<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\Order;

class ChangeStatusOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:change_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto change status order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Start update order status');
        $orders = Order::all();
        foreach($orders as $order) {
            $status = $order->status;
            $id = $order->id;

            if($status == Order::BORROWING && ((strtotime($order->restore_deadline)) - strtotime(date("Y-m-d")) == 259200)) {
                Order::where('id', $id)->update(['status' => Order::DEADLINE_IS_COMMING]);
            }
            if($status == Order::DEADLINE_IS_COMMING && strtotime(date("Y-m-d")) > strtotime($order->restore_deadline)) {
                Order::where('id', $id)->update(['status' => Order::OVERDUE]);
            }
        }
        Log::info('End update order status');
        return 0;
    }
}
