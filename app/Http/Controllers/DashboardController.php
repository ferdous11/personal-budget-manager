<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard', [
            'data' => $this->processReport()
        ]);
    }

    private function processReport(): array
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths(2);
        $user_id = Auth::id();

        return [
            'total_income' => Transaction::where('user_id', $user_id)
                ->whereHas('category', function($query) {
                    $query->where('type', 'income');
                })->sum('amount'),

            'total_expense' => Transaction::where('user_id', $user_id)
                ->whereHas('category', function($query) {
                    $query->where('type', 'expense');
                })->sum('amount'),

            'recent_10_transactions' => Transaction::where('user_id', $user_id)
                ->with('category')
                ->latest()
                ->take(10)
                ->get(),

            'monthly_income_by_category' => Transaction::where('user_id', $user_id)
                ->whereHas('category', function($query) {
                    $query->where('type', 'income');
                })
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as month, category_id, SUM(amount) as total')
                ->groupBy('month', 'category_id')
                ->with('category')
                ->orderBy('month')
                ->get(),

            'monthly_expense_by_category' => Transaction::where('user_id', $user_id)
                ->whereHas('category', function($query) {
                    $query->where('type', 'income');
                })
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as month, category_id, SUM(amount) as total')
                ->groupBy('month', 'category_id')
                ->with('category')
                ->orderBy('month')
                ->get(),
            'total_progress' => $this->totalProgress(),
            'current_progress' => $this->currentProgress(),
            'current_month_income_expense' => $this->currentIncomeExpense(),
            'previous_month_income_expense' => $this->previousIncomeExpense(),
        ];
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

    private function currentIncomeExpense()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        return Transaction::with('category')
            ->where('user_id', auth()->id())
            ->where(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m')"), $currentMonth)
            ->get()
            ->groupBy('category.type')
            ->map(function ($group) {
                return $group->sum('amount');
            });
    }

    private function previousIncomeExpense()
    {
        $currentMonth = Carbon::now()->subMonth()->format('Y-m');
        return Transaction::with('category')
            ->where('user_id', auth()->id())
            ->where(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m')"), $currentMonth)
            ->get()
            ->groupBy('category.type')
            ->map(function ($group) {
                return $group->sum('amount');
            });
    }

    private function currentProgress(): int
    {
        $current_total = $this->currentIncomeExpense();
        return round(($current_total['expense'] * 100)/ $current_total['income'], 0);
    }
}
