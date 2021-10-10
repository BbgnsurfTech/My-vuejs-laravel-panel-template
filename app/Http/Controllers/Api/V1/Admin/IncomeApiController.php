<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Resources\Admin\IncomeResource;
use App\Models\Income;
use App\Models\IncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncomeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('income_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IncomeResource(Income::with(['incomeCategory'])->advancedFilter());
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = Income::create($request->validated());

        return (new IncomeResource($income))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('income_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'income_category' => IncomeCategory::get(['id', 'name']),
            ],
        ]);
    }

    public function show(Income $income)
    {
        abort_if(Gate::denies('income_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IncomeResource($income->load(['incomeCategory']));
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $income->update($request->validated());

        return (new IncomeResource($income))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Income $income)
    {
        abort_if(Gate::denies('income_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new IncomeResource($income->load(['incomeCategory'])),
            'meta' => [
                'income_category' => IncomeCategory::get(['id', 'name']),
            ],
        ]);
    }

    public function destroy(Income $income)
    {
        abort_if(Gate::denies('income_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $income->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
