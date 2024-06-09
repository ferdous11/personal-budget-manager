<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Budget/Index', [
            'budgets' => Budget::select(['id', 'category_id', 'amount', 'period'])->where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Budget/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Budget::create([
            'category_id' => $request->input('category_id'),
            'amount' => $request->input('amount'),
            'period' => $request->input('period'),
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('budgets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $budget = $this->getBudgetById($id);
        return Inertia::render('Budget/Edit', ['budget' => $budget]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $budget = $this->getBudgetById($id);
        $budget->category_id = $request->input('category_id');
        $budget->amount = $request->input('amount');
        $budget->period = $request->input('period');
        $budget->save();

        return redirect()->route('budgets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $budget = Budget::find($id);
        $budget->delete();
        return Inertia::location(route('budgets.index'));
    }

    private function getBudgetById(int $id): Budget | null
    {
        return Budget::select(['id', 'category_id', 'amount', 'period'])
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
