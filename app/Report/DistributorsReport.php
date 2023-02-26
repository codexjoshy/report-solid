<?php
namespace App\Report;

use App\Interfaces\ReportInterface;
use Illuminate\Support\Facades\DB;

class DistributorsReport implements ReportInterface
{
    protected $data;

    public function query()
    {

        $this->data = DB::table('users as referrer')
            ->join('users as purchaser', 'referrer.id', '=', 'purchaser.referred_by')
            ->join('orders', 'purchaser.id', '=', 'orders.purchaser_id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('user_category as referrerUCategory', 'referrerUCategory.user_id', '=', 'referrer.id')
            ->join('categories', 'referrerUCategory.category_id', '=', 'categories.id')
            ->select('referrer.first_name','referrer.last_name','referrer.id as distributor_id','categories.name as distributorCategory',
            DB::raw('COUNT(DISTINCT orders.purchaser_id) as purchase_count'),
            DB::raw('SUM(products.price * order_items.quantity) as total_order'))
            ->where('categories.id', '=', '1')
            ->groupBy('referrer.id', 'distributorCategory')
            ->orderByDesc('total_order')
            ->limit(200);

        return $this;
    }

    public function generate()
    {
        return $this->data->get();
    }
}
