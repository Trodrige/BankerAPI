<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function show($id) {
        return Transaction::findOrFail($id);
    }

    public function index() {
        return Transaction::all();
    }

    public function store(Request $request) {
        try {
            $transaction = new Transaction();
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->account_id = $request->account_id;

            // Check if any field is empty
            if (empty($request->type) or empty($request->amount) or empty($request->account_id)) {
                return response()->json(['status' => 'error', 'message' => 'You must specify the type, amount and account_id for this transaction']);
            }

            if ($transaction->save()) {
                // Update the accounts.balance field
                $this->adjustBalance($transaction->type, $transaction->account_id, $transaction->amount);

                return response()->json(['status' => 'success', 'message' => 'Transaction created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->account_id = $request->account_id;

            // Check if any field is empty
            if (empty($request->type) && empty($request->amount) && empty($request->account_id)) {
                return response()->json(['status' => 'error', 'message' => 'You must specify an update for at least one field (type, amount and account_id) for this transaction']);
            }

            if ($transaction->save()) {
                // Update the accounts.balance field
                $this->adjustBalance($transaction->type, $transaction->account_id, $transaction->amount);

                return response()->json(['status' => 'success', 'message' => 'Transaction updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->delete()) {
                // Update the accounts.balance field
                $this->adjustBalance('withdrawal', $transaction->account_id, $transaction->amount);

                return response()->json(['status' => 'success', 'message' => 'Transaction deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function adjustBalance($type, $account_id, $amount) {
        $account = Account::find($account_id);
        if ($type == 'deposit') {
            $account->balance = $account->balance + $amount;
        }
        if ($type == 'withdrawal') {
            $account->balance = $account->balance - $amount;
        }
        $account->save();
    }

    public function transfer(Request $request, $id) {
        try {
            $amount = $request->amount;
            $sender = Account::findOrFail($id);
            $receiver = Account::findOrFail($request->account_id);

            if (empty($sender) or empty($receiver)) {
                return response()->json(['status' => 'error', 'message' => 'You must select two accounts for this transfer to be valid']);
            } else {
                $request->type = 'deposit';
                $this->store($request);

                $request->type = 'withdrawal';
                $request->account_id = $id;
                $this->store($request);
                return response()->json(['status' => 'success', 'message' => 'Transfer done successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
