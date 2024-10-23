<?php

namespace App\Http\Repositories;

use App\Events\OrderSucceeded;
use App\Http\Filters\DatePipeline;
use App\Http\Filters\PaginationPipeline;
use App\Http\Filters\SortPipeline;
use App\Http\Filters\StatusPipeline;
use App\Http\Helpers\Traits\ApiPaginator;
use App\Http\Resources\Order\OrderResource;
use App\Http\Response\Response;
use App\Listeners\PlaceOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Pipeline\Pipeline;

class OrderRepository implements BaseRepositoryInterface
{
    use ApiPaginator;
    public $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function find($id)
    {
        $order = Order::find($id);
        return new OrderResource($order);
    }

    public function all()
    {
        $orders = app(Pipeline::class)
            ->send(Order::query()->where("user_id",auth()->id()))
            ->through([
                PaginationPipeline::class,
                SortPipeline::class,
                DatePipeline::class,
                StatusPipeline::class,
            ])
            ->thenReturn();
        $collection = OrderResource::collection($orders);
        $data = $this->getPaginatedResponse($orders, $collection);
        return $this->response->statusOk($data);
    }

    public function create(array $data)
    {
        try {
            \DB::beginTransaction();
            $orderData = ["total" => 0];
            $orderData["user_id"] = auth()->id();
            $orderData["status"] = Order::PENDING;
            $order = Order::create($orderData);
            foreach ($data["items"] as $item) {
                $product = Product::find($item["product_id"]);
                $order->total = $order->total + ($item["quantity"] * $product->price);
                $order->products()->attach($product->id,["quantity" => $item["quantity"], "unit_price" => $product->price]);
                $product->quantity = $product->quantity - $item["quantity"];
                $product->save();
            }
            $order->save();
            \DB::commit();
            event(new OrderSucceeded($order));
            return $this->response->statusOk(["data" =>new OrderResource($order)]);
        }
        catch (\Exception $exception){
            \DB::rollback();
            return $this->response->statusFail( $exception->getMessage());
        }

    }


    public function update(array $data, $id)
    {
        return $data;
    }
}
