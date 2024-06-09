<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Transaction/Index', [
            'transactions' => Transaction::select(['id', 'category_id', 'date', 'amount', 'description'])->where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Transaction/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Transaction::create([
            'category_id' => $request->input('category_id'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('transactions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = $this->getTransactionById($id);
        return Inertia::render('Transaction/Edit', ['transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = $this->getTransactionById($id);
        $transaction->category_id = $request->input('category_id');
        $transaction->amount = $request->input('amount');
        $transaction->date = $request->input('date');
        $transaction->description = $request->input('description');
        $transaction->save();

        return redirect()->route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return Inertia::location(route('transactions.index'));
    }

    private function getTransactionById(int $id): Transaction | null
    {
        return Transaction::select(['id', 'category_id', 'date', 'amount', 'description'])
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
