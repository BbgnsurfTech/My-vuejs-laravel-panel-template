<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentPageRequest;
use App\Http\Requests\UpdateContentPageRequest;
use App\Http\Resources\Admin\ContentPageResource;
use App\Models\ContentCategory;
use App\Models\ContentPage;
use App\Models\ContentTag;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ContentPageApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('content_page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContentPageResource(ContentPage::with(['category', 'tag'])->advancedFilter());
    }

    public function store(StoreContentPageRequest $request)
    {
        $contentPage = ContentPage::create($request->validated());
        $contentPage->category()->sync($request->input('category.*.id', []));
        $contentPage->tag()->sync($request->input('tag.*.id', []));
        if ($media = $request->input('featured_image', [])) {
            Media::whereIn('id', data_get($media, '*.id'))
                ->where('model_id', 0)
                ->update(['model_id' => $contentPage->id]);
        }

        return (new ContentPageResource($contentPage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('content_page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'category' => ContentCategory::get(['id', 'name']),
                'tag'      => ContentTag::get(['id', 'name']),
            ],
        ]);
    }

    public function show(ContentPage $contentPage)
    {
        abort_if(Gate::denies('content_page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContentPageResource($contentPage->load(['category', 'tag']));
    }

    public function update(UpdateContentPageRequest $request, ContentPage $contentPage)
    {
        $contentPage->update($request->validated());
        $contentPage->category()->sync($request->input('category.*.id', []));
        $contentPage->tag()->sync($request->input('tag.*.id', []));
        $contentPage->updateMedia($request->input('featured_image', []), 'content_page_featured_image');

        return (new ContentPageResource($contentPage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(ContentPage $contentPage)
    {
        abort_if(Gate::denies('content_page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new ContentPageResource($contentPage->load(['category', 'tag'])),
            'meta' => [
                'category' => ContentCategory::get(['id', 'name']),
                'tag'      => ContentTag::get(['id', 'name']),
            ],
        ]);
    }

    public function destroy(ContentPage $contentPage)
    {
        abort_if(Gate::denies('content_page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentPage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(Request $request)
    {
        abort_if(Gate::none(['content_page_create', 'content_page_edit']), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('size')) {
            $this->validate($request, [
                'file' => 'max:' . $request->input('size') * 1024,
            ]);
        }

        $model         = new ContentPage();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        return response()->json($media, Response::HTTP_CREATED);
    }
}
