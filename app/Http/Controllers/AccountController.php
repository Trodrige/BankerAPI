<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\Transaction;

class AccountController extends Controller
{

    public function show($id) {
        return Account::findOrFail($id);
    }

    public function index() {
        return Account::all();
    }

    public function store(Request $request) {
        try {
            $account = new Account();
            $account->type = $request->type;
            $account->number = $request->number;
            $account->customer_id = $request->customer_id;
            $account->balance = $request->balance;

            if (empty($request->type) or empty($request->number) or empty($request->customer_id or empty($request->balance))) {
                return response()->json(['status' => 'error', 'message' => 'You must specify the type, number, initial amount and customer_id for this account']);
            }

            if ($account->save()) {
                return response()->json(['status' => 'success', 'message' => 'Account created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $account = Account::findOrFail($id);
            $account->type = $request->type;
            $account->number = $request->number;
            $account->customer_id = $request->customer_id;
            $account->balance = $request->balance;

            // Check if any field is empty
            if (empty($request->type) && empty($request->number) && empty($request->customer_id && empty($request->balance))) {
                return response()->json(['status' => 'error', 'message' => 'You must specify an update for at least one field (type, number, balance and customer_id) for this account']);
            }

            if ($account->save()) {
                return response()->json(['status' => 'success', 'message' => 'Account updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        try {
            $account = Account::findOrFail($id);

            if ($account->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Account deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getBalance($id) {
        try {
            $account = Account::findOrFail($id);
            return response()->json(['status' => 'success', 'message' => 'Your account balance is: '.$account->balance]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getHistory($id) {
        try {
            return Account::find($id)->transactions;
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
