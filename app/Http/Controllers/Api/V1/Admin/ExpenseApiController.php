<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\Admin\ExpenseResource;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpenseApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource(Expense::with(['expenseCategory'])->advancedFilter());
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->validated());

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('expense_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'expense_category' => ExpenseCategory::get(['id', 'name']),
            ],
        ]);
    }

    public function show(Expense $expense)
    {
        abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource($expense->load(['expenseCategory']));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Expense $expense)
    {
        abort_if(Gate::denies('expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new ExpenseResource($expense->load(['expenseCategory'])),
            'meta' => [
                'expense_category' => ExpenseCategory::get(['id', 'name']),
            ],
        ]);
    }

    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
