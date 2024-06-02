<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:order-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $createCallback = function ($msg) {
            $data = json_decode($msg->body, true);
            $user_id = $data['user_id'];
            $product_id = $data['product_id'];

            $product = Product::find($product_id);
            $decrement = $product->qty - 1;
            $product->update(["qty" => $decrement]);
            $order = Order::create([
                "user_id" => $user_id,
                "product_id" => $product_id,
            ]);
            echo ' [x] Berhasil menambahkan order ', $order, "\n";
        };
        $orderCallBack  = function ($msg) {
            $data = json_decode($msg->body, true);
            $order_id = $data['id'];

            $order = Order::find($order_id);
            $order->delete();

            echo ' [x] Berhasil Membatalkan Pemesanan id ', $order_id, "\n";
        };
        $channel->queue_declare('buy_queue', false, false, false, false);
        $channel->basic_consume('buy_queue', '', false, true, false, false, $createCallback);

        $channel->queue_declare('order_queue', false, false, false, false);
        $channel->basic_consume('order_queue', '', false, true, false, false, $orderCallBack);
        echo 'Waiting for new message', " \n";
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}
