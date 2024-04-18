<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * This class will allow customers to create account and will get the permission to create order.
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
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
            'password' => bcrypt($request->password),
        ]);

        $customerUUID = Str::uuid();

        $customer = new Customer([
            'id' => $customerUUID,
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
     * @param $id
     * @return JsonResponse
     */
    public function getCustomer($id): JsonResponse
    {
        $customer = Customer::with('user')->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json(['customer' => $customer], 200);
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
}
