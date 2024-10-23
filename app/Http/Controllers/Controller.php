<?php

namespace App\Http\Controllers;

use App\Http\Response\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

/**
 *@OA\Info(
 *  title="Jawher AL Mina API",
 *  version="1.0",
 *  description="King salaman project help you to manage all your projects and see all process and staging of the project:
 *      with timestampe images and 360 taken every day for the project .
 *     you can access our website throught admin or our clients invetations ."
 *
 *)
 *@OA\SecurityScheme(
 *  type="http",
 *  securityScheme="Authorization",
 *  scheme="bearer",
 *  bearerFormat="JWT"
 *)
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

}
