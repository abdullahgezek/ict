<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{

    public function get(int $productId)
    {
        $product = Products::findById($productId);

        if (!$product) {
            return response()->json(['message' => 'Ürün bulunamadı'], 404);
        }

        return response()->json([
            'message' => 'Ürün bulundu',
            'data' => new ProductResource($product)
        ], ResponseAlias::HTTP_ACCEPTED);
    }

    public function store(ProductRequest $request)
    {
        try {

            $product = Products::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'stock_status' => $request->input('stock_status'),
            ]);

            return response()->json([
                'message' => 'Ürün başarıyla oluşturuldu',
                'data' => new ProductResource($product)
            ], ResponseAlias::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ürün oluşturulurken bir hata oluştu',
                'error' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function update(ProductRequest $request, string $id)
    {

        $product = Products::findById($id);

        if (!$product) {
            return response()->json(['message' => 'Ürün bulunamadı'], 404);
        }

        $product = Products::findById($id);

        $data = $request->only([
            'name',
            'description',
            'stock_status'
        ]);

        $product->update($data);


        return (new ProductResource($product))
            ->response()
            ->setStatusCode(ResponseAlias::HTTP_ACCEPTED);
    }


    public function destroy(string $id)
    {
        $product = Products::findById($id);

        if (!$product) {
            return response()->json(['message' => 'Ürün bulunamadı'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Ürün başarıyla silindi'], 200);
    }
}
