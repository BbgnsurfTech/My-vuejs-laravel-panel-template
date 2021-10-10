<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmCustomerRequest;
use App\Http\Requests\UpdateCrmCustomerRequest;
use App\Http\Resources\Admin\CrmCustomerResource;
use App\Models\CrmCustomer;
use App\Models\CrmStatus;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CrmCustomerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('crm_customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmCustomerResource(CrmCustomer::with(['status'])->advancedFilter());
    }

    public function store(StoreCrmCustomerRequest $request)
    {
        $crmCustomer = CrmCustomer::create($request->validated());

        return (new CrmCustomerResource($crmCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('crm_customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'status' => CrmStatus::get(['id', 'name']),
            ],
        ]);
    }

    public function show(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmCustomerResource($crmCustomer->load(['status']));
    }

    public function update(UpdateCrmCustomerRequest $request, CrmCustomer $crmCustomer)
    {
        $crmCustomer->update($request->validated());

        return (new CrmCustomerResource($crmCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new CrmCustomerResource($crmCustomer->load(['status'])),
            'meta' => [
                'status' => CrmStatus::get(['id', 'name']),
            ],
        ]);
    }

    public function destroy(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmCustomer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
