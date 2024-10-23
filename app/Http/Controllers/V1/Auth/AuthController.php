<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {

    /**
     *@OA\post(
     *  path="/v1/Login",
     *  summary="Login Api",
     *tags={"Auth"},
     * @OA\RequestBody(
     *          request="Request Body",
     *          description="Request Body",
     *          @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property (
     *                          property="email",
     *                          title="email",
     *                          type="string",
     *                          example="mohamedelserag4488@gmail.com",
     *                          description="Email"
     *                      ),
     *                   @OA\Property (
     *                           property="password",
     *                           title="password",
     *                           type="string",
     *                           example="123456",
     *                           description="Password"
     *                       )
     *                  )
     *          )
     *      ),
     *@OA\Response(
     *  response=200,
     *  description="Success message",
     *     content={
     *              @OA\MediaType(
     *                   mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="meta",
     *                          type="object",
     *                          description="Meta Data",
     *                          @OA\Property(
     *                              property="status",
     *                              type="string",
     *                              example="OK",
     *                              description="Response Status"
     *                          )
     *                      ),
     *                      @OA\Property(
     *                          property="response",
     *                          type="object",
     *                          description="Data and messages Response",
     *                          @OA\Property(
     *                               property="status",
     *                               type="string",
     *                               example="OK",
     *                               description="Response Status"
     *                           ),
     *                          @OA\Property(
     *                                property="data",
     *                                type="object",
     *                                description="User Object and jwt token"
     *                            )
     *                      )
     *
     *                  )
     *              )
     *
     *          }
     *),

     *)
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->response->statusFail("Invalid credentials");
        }
        $user = auth()->user();
        $user->token = $token;
        $data = ['data' => new LoginResource($user)];
        return $this->response->statusOk($data);
    }

    /**
     *@OA\post(
     *  path="/v1/register",
     *  summary="register",
     *tags={"Auth"},
     * @OA\RequestBody(
     *          request="Request Body",
     *          description="Request Body",
     *          @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property (
     *                          property="name",
     *                          title="fname",
     *                          type="string",
     *                          example="abcd",
     *                          description="First name"
     *                      ),
     *                    @OA\Property (
     *                            property="email",
     *                            title="email",
     *                            type="string",
     *                            example="email@email.com",
     *                            description="Email"
     *                        ),
     *                    @OA\Property (
     *                            property="password",
     *                            title="password",
     *                            type="string",
     *                            example="123456",
     *                            description="Password"
     *                        )
     *                  )
     *          )
     *      ),
     *@OA\Response(
     *  response=200,
     *  description="Success message",
     *     content={
     *              @OA\MediaType(
     *                   mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="meta",
     *                          type="object",
     *                          description="Meta Data",
     *                          @OA\Property(
     *                              property="status",
     *                              type="string",
     *                              example="OK",
     *                              description="Response Status"
     *                          )
     *                      ),
     *                      @OA\Property(
     *                          property="response",
     *                          type="object",
     *                          description="Data and messages Response",
     *                          @OA\Property(
     *                               property="status",
     *                               type="string",
     *                               example="OK",
     *                               description="Response Status"
     *                           ),
     *                          @OA\Property(
     *                                property="data",
     *                                type="object",
     *                                description="User Object and jwt token"
     *                            )
     *                      )
     *
     *                  )
     *              )
     *
     *          }
     *),

     *)
     */
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $data['password'] = \Hash::make($data['password']);
        $user = User::create($data);
        $token = JWTAuth::fromUser($user);
        $user->token = $token;
        return $this->response->statusOk(["data" => new LoginResource($user)]);
    }


}
