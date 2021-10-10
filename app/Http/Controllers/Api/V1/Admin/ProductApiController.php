<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource(Product::with(['category', 'tag'])->advancedFilter());
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->category()->sync($request->input('category.*.id', []));
        $product->tag()->sync($request->input('tag.*.id', []));
        if ($media = $request->input('photo', [])) {
            Media::whereIn('id', data_get($media, '*.id'))
                ->where('model_id', 0)
                ->update(['model_id' => $product->id]);
        }

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'category' => ProductCategory::get(['id', 'name']),
                'tag'      => ProductTag::get(['id', 'name']),
            ],
        ]);
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource($product->load(['category', 'tag']));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->category()->sync($request->input('category.*.id', []));
        $product->tag()->sync($request->input('tag.*.id', []));
        $product->updateMedia($request->input('photo', []), 'product_photo');

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new ProductResource($product->load(['category', 'tag'])),
            'meta' => [
                'category' => ProductCategory::get(['id', 'name']),
                'tag'      => ProductTag::get(['id', 'name']),
            ],
        ]);
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(Request $request)
    {
        abort_if(Gate::none(['product_create', 'product_edit']), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('size')) {
            $this->validate($request, [
                'file' => 'max:' . $request->input('size') * 1024,
            ]);
        }

        $model         = new Product();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        return response()->json($media, Response::HTTP_CREATED);
    }
}
