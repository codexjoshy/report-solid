<?php
namespace App\Report;

use App\Interfaces\ReportInterface;
use Illuminate\Support\Facades\DB;

class DistributorsReport implements ReportInterface
{
    // Total Sales are the total amount of orders that have been purchased by the customers and distributors they have referred. Note that if 2 or more Distributors have achieved the same amount of sales, they would have the same # on the list.
    protected $data;
    public function orders()
    {
        $this->data = DB::table('users')
        ->select(
            'users.first_name','users.last_name', 'categories.name as distributorCategory',
            DB::raw('SUM(products.price) as total_price, SUM(order_items.quantity) as total_quantity'),
            DB::raw('(SUM(products.price) * SUM(order_items.quantity)) as total_order')
        )
        ->join('user_category', 'user_category.user_id', '=', 'users.id')
        ->join('categories', 'categories.id', '=', 'user_category.category_id')
        ->join('users as customers', 'customers.referred_by', '=', 'users.id')
        ->leftJoin('orders', 'customers.id', '=', 'orders.purchaser_id')
        ->leftJoin('order_items', 'orders.id', 'order_items.order_id')
        ->leftJoin('products', 'order_items.product_id', 'products.id')
        ->where('user_category.category_id', '=', 1)
        ->groupBy('users.id', 'distributorCategory')
        ->orderByDesc('total_order')
        ->limit(200);
        return $this;
    }

    public function query()
    {
        $this->data = DB::table('users')
        ->select(
            'users.first_name','users.last_name', 'categories.name as distributorCategory',
            DB::raw('SUM(products.price) as total_price, SUM(order_items.quantity) as total_quantity'),
            DB::raw('(SUM(products.price) * SUM(order_items.quantity)) as total_order')
        )
        ->join('user_category', 'user_category.user_id', '=', 'users.id')
        ->join('categories', 'categories.id', '=', 'user_category.category_id')
        ->join('users as customers', 'customers.referred_by', '=', 'users.id')
        ->leftJoin('orders', 'customers.id', '=', 'orders.purchaser_id')
        ->leftJoin('order_items', 'orders.id', 'order_items.order_id')
        ->leftJoin('products', 'order_items.product_id', 'products.id')
        ->where('user_category.category_id', '=', 1)
        ->groupBy('users.id', 'distributorCategory')
        ->orderByDesc('total_order')
        ->limit(200);
        return $this;
    }

    public function generate()
    {
        return $this->data->get();
    }
}
