<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmStatusRequest;
use App\Http\Requests\UpdateCrmStatusRequest;
use App\Http\Resources\Admin\CrmStatusResource;
use App\Models\CrmStatus;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CrmStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('crm_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmStatusResource(CrmStatus::advancedFilter());
    }

    public function store(StoreCrmStatusRequest $request)
    {
        $crmStatus = CrmStatus::create($request->validated());

        return (new CrmStatusResource($crmStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('crm_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show(CrmStatus $crmStatus)
    {
        abort_if(Gate::denies('crm_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmStatusResource($crmStatus);
    }

    public function update(UpdateCrmStatusRequest $request, CrmStatus $crmStatus)
    {
        $crmStatus->update($request->validated());

        return (new CrmStatusResource($crmStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(CrmStatus $crmStatus)
    {
        abort_if(Gate::denies('crm_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new CrmStatusResource($crmStatus),
            'meta' => [],
        ]);
    }

    public function destroy(CrmStatus $crmStatus)
    {
        abort_if(Gate::denies('crm_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
