<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BudgetController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Budget/Index', [
            'page_title' => 'Budgets',
            'budgets' => Auth::user()->budgets,
        ]);
    }


    public function create(): \Inertia\Response
    {
        return Inertia::render('Budget/Create', [
            'page_title' => 'Add Budget',
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'amount' => 'required|int|min:1000|max:5000000',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $request->user()->budgets()->create([
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return redirect()->route('budgets.index')->with('message', [
                'body' => 'Budget created successfully.',
                'type' => 'success'
            ]
        );

    }


    public function show(string $id): \Inertia\Response
    {
        return Inertia::render('Budget/Show', [
            'page_title' => 'Budget Details',
            'budget' => Budget::where(['id' => $id, 'user_id' => auth()->user()->id])->first()
        ]);
    }


    public function edit(string $id): \Inertia\Response
    {
        return Inertia::render('Budget/Edit', [
            'page_title' => 'Edit Budget',
            'budget' => Budget::where(['id' => $id, 'user_id' => auth()->user()->id])->first()
        ]);
    }


    public function update(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'amount' => 'required|int|min:1000|max:5000000',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $budget = Budget::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        $budget->amount = $request->input('amount');
        $budget->start_date = $request->input('start_date');
        $budget->end_date = $request->input('end_date');
        $budget->save();
        return redirect()->route('budgets.index');
    }

    public function destroy(string $id): \Symfony\Component\HttpFoundation\Response
    {
        $budget = Budget::find($id);
        $budget->delete();
        return Inertia::location(route('budgets.index'));
    }
}

