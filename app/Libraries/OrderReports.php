<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;

class OrderReports
{
    /**
     * Her bir siparişte kaç ürün kullanıldığını raporlayan SQL
     */
    public function getOrderProductCounts()
    {
        return DB::table('orders')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->select('orders.id', DB::raw('COUNT(order_products.id) as product_count'))
            ->groupBy('orders.id')
            ->get();
    }

    /**
     * Son 1 yıllık siparişler arasında en çok kullanılan, 1 ay içerisinde şipariş edilmiş, şu an stokta bulunmayan
     * 5 ürün için SQL
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMostUsedProductsOutOfStock()
    {
        return DB::table('products as p')
            ->select('p.id', 'p.name', DB::raw('COUNT(op.id) as order_count'))
            ->join('order_products as op', 'p.id', '=', 'op.product_id')
            ->join('orders as o', 'op.order_id', '=', 'o.id')
            ->where('o.order_date', '>=', now()->subYear())
            ->where('o.order_date', '>=', now()->subMonth())
            ->where('p.stock_status', 0)
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();
    }
}