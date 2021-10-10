<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentTagRequest;
use App\Http\Requests\UpdateContentTagRequest;
use App\Http\Resources\Admin\ContentTagResource;
use App\Models\ContentTag;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentTagApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('content_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContentTagResource(ContentTag::advancedFilter());
    }

    public function store(StoreContentTagRequest $request)
    {
        $contentTag = ContentTag::create($request->validated());

        return (new ContentTagResource($contentTag))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('content_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show(ContentTag $contentTag)
    {
        abort_if(Gate::denies('content_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContentTagResource($contentTag);
    }

    public function update(UpdateContentTagRequest $request, ContentTag $contentTag)
    {
        $contentTag->update($request->validated());

        return (new ContentTagResource($contentTag))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(ContentTag $contentTag)
    {
        abort_if(Gate::denies('content_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new ContentTagResource($contentTag),
            'meta' => [],
        ]);
    }

    public function destroy(ContentTag $contentTag)
    {
        abort_if(Gate::denies('content_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentTag->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
