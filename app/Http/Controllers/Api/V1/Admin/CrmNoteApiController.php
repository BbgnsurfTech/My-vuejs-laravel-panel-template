<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmNoteRequest;
use App\Http\Requests\UpdateCrmNoteRequest;
use App\Http\Resources\Admin\CrmNoteResource;
use App\Models\CrmCustomer;
use App\Models\CrmNote;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CrmNoteApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('crm_note_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmNoteResource(CrmNote::with(['customer'])->advancedFilter());
    }

    public function store(StoreCrmNoteRequest $request)
    {
        $crmNote = CrmNote::create($request->validated());

        return (new CrmNoteResource($crmNote))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('crm_note_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'customer' => CrmCustomer::get(['id', 'first_name']),
            ],
        ]);
    }

    public function show(CrmNote $crmNote)
    {
        abort_if(Gate::denies('crm_note_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmNoteResource($crmNote->load(['customer']));
    }

    public function update(UpdateCrmNoteRequest $request, CrmNote $crmNote)
    {
        $crmNote->update($request->validated());

        return (new CrmNoteResource($crmNote))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(CrmNote $crmNote)
    {
        abort_if(Gate::denies('crm_note_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new CrmNoteResource($crmNote->load(['customer'])),
            'meta' => [
                'customer' => CrmCustomer::get(['id', 'first_name']),
            ],
        ]);
    }

    public function destroy(CrmNote $crmNote)
    {
        abort_if(Gate::denies('crm_note_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmNote->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
