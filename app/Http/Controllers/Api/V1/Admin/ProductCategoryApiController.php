<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Http\Resources\Admin\ProductCategoryResource;
use App\Models\ProductCategory;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductCategoryResource(ProductCategory::advancedFilter());
    }

    public function store(StoreProductCategoryRequest $request)
    {
        $productCategory = ProductCategory::create($request->validated());

        if ($media = $request->input('photo', [])) {
            Media::whereIn('id', data_get($media, '*.id'))
                ->where('model_id', 0)
                ->update(['model_id' => $productCategory->id]);
        }

        return (new ProductCategoryResource($productCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('product_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductCategoryResource($productCategory);
    }

    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $productCategory->update($request->validated());

        $productCategory->updateMedia($request->input('photo', []), 'product_category_photo');

        return (new ProductCategoryResource($productCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new ProductCategoryResource($productCategory),
            'meta' => [],
        ]);
    }

    public function destroy(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(Request $request)
    {
        abort_if(Gate::none(['product_category_create', 'product_category_edit']), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('size')) {
            $this->validate($request, [
                'file' => 'max:' . $request->input('size') * 1024,
            ]);
        }

        $model         = new ProductCategory();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        return response()->json($media, Response::HTTP_CREATED);
    }
}
