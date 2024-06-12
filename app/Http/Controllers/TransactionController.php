<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index() //: \Inertia\Response
    {


        return Inertia::render('Transaction/Index', [
            'page_title' => 'Transactions',
            'transactions' => Transaction::with('category')->where('user_id', Auth::id())->get(),
            'total_progress' => $this->totalProgress(),
            'current_progress' => $this->currentProgress(),
        ]);
    }

    private function totalProgress(): int
    {
        $total = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->get()
            ->groupBy('category.type')
            ->map(function ($group) {
                return $group->sum('amount');
            });
        return round(($total['expense'] * 100)/ $total['income'], 0);
    }

    private function currentProgress(): int
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $current_total = Transaction::with('category')
            ->where('user_id', auth()->id())
            ->where(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m')"), $currentMonth)
            ->get()
            ->groupBy('category.type')
            ->map(function ($group) {
                return $group->sum('amount');
            });
        return round(($current_total['expense'] * 100)/ $current_total['income'], 0);
    }


    public function create(): \Inertia\Response
    {
        return Inertia::render('Transaction/Create', [
            'page_title' => 'Add Transaction',
            'categories' => Auth::user()->categories,
        ]);
    }


    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'description' => 'required|string',
            'amount' => 'required|int|min:1000|max:5000000',
            'transaction_date' => 'required|date',
            'category_id' => 'required|int',
        ]);
        $request->user()->transactions()->create([
            'description' => $request->description,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('transactions.index')->with('message', [
                'body' => 'Transaction created successfully.',
                'type' => 'success'
            ]
        );

    }


    public function show(string $id): \Inertia\Response
    {
        return Inertia::render('Transaction/Show', [
            'page_title' => 'Transaction Details',
            'transaction' => Transaction::with('category')
                ->where(['id' => $id, 'user_id' => auth()->user()->id])->first(),
        ]);
    }


    public function edit(string $id): \Inertia\Response
    {
        return Inertia::render('Transaction/Edit', [
            'page_title' => 'Edit Transaction',
            'transaction' => Transaction::where(['id' => $id, 'user_id' => auth()->user()->id])->first(),
            'categories' => Auth::user()->categories,
        ]);
    }


    public function update(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'description' => 'required|string',
            'amount' => 'required|int|min:1000|max:5000000',
            'transaction_date' => 'required|date',
            'category_id' => 'required|int',
        ]);
        $transaction = Transaction::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        $transaction->description = $request->input('description');
        $transaction->amount = $request->input('amount');
        $transaction->transaction_date = $request->input('transaction_date');
        $transaction->category_id = $request->input('category_id');
        $transaction->save();
        return redirect()->route('transactions.index');
    }

    public function destroy(string $id): \Symfony\Component\HttpFoundation\Response
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return Inertia::location(route('transactions.index'));
    }
}
