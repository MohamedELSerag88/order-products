<?php

namespace App\Http\Repositories;

use App\Http\Filters\KeySearchPipeline;
use App\Http\Filters\PaginationPipeline;
use App\Http\Filters\RangePipeline;
use App\Http\Filters\SortPipeline;
use App\Http\Helpers\StripeHelper;
use App\Http\Helpers\Traits\ApiPaginator;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Response\Response;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Pipeline\Pipeline;

class ProductRepository implements BaseRepositoryInterface
{
    use ApiPaginator;
    public $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function find($id)
    {
        $order = Product::find($id);
        return $order;
    }

    public function all()
    {
        $orders = app(Pipeline::class)
            ->send(Product::query())
            ->through([
                PaginationPipeline::class,
                SortPipeline::class,
                RangePipeline::class,
                KeySearchPipeline::class,
            ])
            ->thenReturn();
        $collection = ProductResource::collection($orders);
        $data = $this->getPaginatedResponse($orders, $collection);
        return $this->response->statusOk($data);
    }

    public function create(array $data)
    {
        try {
            \DB::beginTransaction();
            $product = Product::create($data);
            \DB::commit();
            return $this->response->statusOk(["data" =>new ProductResource($product)]);
        }
        catch (\Exception $exception){
            \DB::rollback();
            return $this->response->statusFail( $exception->getMessage());
        }

    }

    public function update(array $data, $id)
    {

        try {
            \DB::beginTransaction();
            Product::where("id",$id)->update($data);
            \DB::commit();
            return $this->response->statusOk("Product updated successfully");
        }
        catch (\Exception $exception){
            \DB::rollback();
            return $this->response->statusFail( $exception->getMessage());
        }
    }



}
