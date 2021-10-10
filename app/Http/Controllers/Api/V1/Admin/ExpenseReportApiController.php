<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Response;

class ExpenseReportApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expense_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validatedData = request()->validate([
            'year'  => 'required|in:' . implode(',', range(now()->year, 1900)),
            'month' => 'required|in:' . implode(',', range(1, 12)),
        ]);

        $from = Carbon::parse(sprintf(
            '%s-%s-01',
            $validatedData['year'],
            $validatedData['month']
        ));

        $to      = clone $from;
        $to->day = $to->daysInMonth;

        $expenses = Expense::with('expenseCategory')
            ->whereBetween('entry_date', [$from, $to]);

        $incomes = Income::with('incomeCategory')
            ->whereBetween('entry_date', [$from, $to]);

        $expensesTotal   = (float) $expenses->sum('amount');
        $incomesTotal    = (float) $incomes->sum('amount');
        $groupedExpenses = $expenses->whereNotNull('expense_category_id')->orderBy('amount', 'desc')->get()->groupBy('expense_category_id');
        $groupedIncomes  = $incomes->whereNotNull('income_category_id')->orderBy('amount', 'desc')->get()->groupBy('income_category_id');
        $profit          = (float) number_format($incomesTotal - $expensesTotal, 2);

        $expensesSummary = [];

        foreach ($groupedExpenses as $exp) {
            foreach ($exp as $line) {
                if (!isset($expensesSummary[$line->expenseCategory->name])) {
                    $expensesSummary[$line->expenseCategory->name] = [
                        'name'   => $line->expenseCategory->name,
                        'amount' => 0,
                    ];
                }

                $expensesSummary[$line->expenseCategory->name]['amount'] += $line->amount;
            }
        }

        $incomesSummary = [];

        foreach ($groupedIncomes as $inc) {
            foreach ($inc as $line) {
                if (!isset($incomesSummary[$line->incomeCategory->name])) {
                    $incomesSummary[$line->incomeCategory->name] = [
                        'name'   => $line->incomeCategory->name,
                        'amount' => 0,
                    ];
                }

                $incomesSummary[$line->incomeCategory->name]['amount'] += $line->amount;
            }
        }

        return response()->json([
            'data' => compact(
                'expensesSummary',
                'incomesSummary',
                'expensesTotal',
                'incomesTotal',
                'profit'
            ),
        ]);
    }
}
