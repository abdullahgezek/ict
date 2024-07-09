<?php

namespace App\Http\Controllers;

use App\Libraries\OrderReports;

class ReportsController extends Controller
{
    public function getOrderCounts()
    {
        $stats = new OrderReports();
        $counts = $stats->getOrderProductCounts();

        return response()->json($counts);
    }

    public function getMostUsedProductsOutOfStock()
    {
        $stats = new OrderReports();
        $products = $stats->getMostUsedProductsOutOfStock();

        return response()->json($products);
    }
}
