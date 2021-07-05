<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\BookInOrder;
use Modules\Order\Entities\Order;

class CancelOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto cancel order';

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
        Log::info('Start cancel order job');
        $orders = Order::all();
        foreach ($orders as $order) {
            $status = $order->status;
            $createdDate = $order->created_at->format('Y-m-d');
            $pickTime = $order->pick_time;
            $id = $order->id;

            if ($status == Order::BORROW_ORDER_CREATED_STATUS && (strtotime(date("Y-m-d")) - strtotime($createdDate)) == 86400 && empty($pickTime)) {
                Order::where('id', $id)->update(['status' => Order::CANCEL]);
                BookInOrder::where('order_id', $id)->delete();
            }
        }
        Log::info('End cancel order job');
        return 0;
    }
}
