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
use Illuminate\Support\Facades\Cache;

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
        $seconds = env('CACHE_LIFE_TIME',  3600);
        $requestQuery = request()->all();
        $requestQueryString = http_build_query($requestQuery);
        $cache_key = "products?".$requestQueryString;
        if( Cache::get($cache_key) == null){
            $products = app(Pipeline::class)
                ->send(Product::query())
                ->through([
                    PaginationPipeline::class,
                    SortPipeline::class,
                    RangePipeline::class,
                    KeySearchPipeline::class,
                ])
                ->thenReturn();
            $collection = ProductResource::collection($products);
            $data = $this->getPaginatedResponse($products, $collection);
            $newData = json_encode($data, JSON_PRETTY_PRINT);
            Cache::put($cache_key, $newData,$seconds );
        }
        else{
            $cachedData = Cache::get($cache_key);
            $data = json_decode($cachedData, true);
        }

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
