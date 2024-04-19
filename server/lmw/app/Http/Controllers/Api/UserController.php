<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/**
 * This class will allow customers to create account and will get the permission to create order.
 */
class UserController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login', 'register']]);
//        auth()->setDefaultDriver('api');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'customer_data' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customer = new Customer([
            'latitude' => $request->customer_data['latitude'] ?? 0,
            'longitude' => $request->customer_data['longitude'] ?? 0,
        ]);

        $user->customer()->save($customer);

        return response()->json(['message' => 'Customer account created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->update([
            'longitude' => $request->customer_data['longitude'] ?? 0,
            'latitude' => $request->customer_data['latitude'] ?? 0,
        ]);

        $userData = [
            'name'      => $request->name,
        ];

        if ($request->has('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        if ($customer->user) {
            $customer->user->update($userData);
        }

        return response()->json(['message' => 'Customer account updated successfully'], 200);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getCustomer(string $id): JsonResponse
    {
//        $this->isAuthorized();
        $customer = Customer::with('user')->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json(['customer' => $customer], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = JWTAuth::fromUser($user);

        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
        if($removeToken){
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Failed logged out',
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        if ($customer->user) {
            $customer->user->delete();
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $user = Auth::user();
        if($user){
            $newToken = Auth::refresh();
            return response()->json(['token' => $newToken]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        if($token){
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * @return JsonResponse
     */
    private function isAuthorized(): JsonResponse
    {
        $user = auth()->user();
        if($user){
            return response()->json(['message' => 'Unauthenticated'], 404);
        }
    }
}
