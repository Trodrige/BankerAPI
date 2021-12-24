<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function show($id) {
        return Customer::findOrFail($id);
    }

    public function index() {
        return Customer::all();
    }

    public function store(Request $request) {
        try {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;

            // Check if any field is empty
            if (empty($request->name) or empty($request->email)) {
                return response()->json(['status' => 'error', 'message' => 'You must specify the name and email for this customer']);
            }

            if ($customer->save()) {
                return response()->json(['status' => 'success', 'message' => 'Customer created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $customer = Customer::findOrFail($id);
            $customer->name = $request->name;
            $customer->email = $request->email;


            error_log(print_r($request, true));

            // Check if any field is empty
            if (empty($request->name) && empty($request->email)) {
                return response()->json(['status' => 'error', 'message' => 'You must specify an update for at least one field (name and email) for this customer', 'data' => $request->email]);
            }

            if ($customer->save()) {
                return response()->json(['status' => 'success', 'message' => 'Customer updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        try {
            $customer = Customer::findOrFail($id);

            if ($customer->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Customer deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
