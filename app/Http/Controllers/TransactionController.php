<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with([ 'reservation'])->get();
        return response()->json($transactions);
    }
    public function show($id)
    {
        $transaction = Transaction::with(['reservation'])->findOrFail($id);
        return response()->json($transaction);
    }
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,debit_card,e-wallet,bank_transfer',
            'status' => 'required|in:pending,completed,failed',
            'payment_date' => 'nullable|date|before_or_equal:today',
        ]);

        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,completed,failed',
            'payment_date' => 'nullable|date|before_or_equal:today',
        ]);

        $transaction->update($request->all());
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(null, 204);
    }
}
