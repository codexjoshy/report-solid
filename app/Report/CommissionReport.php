<?php
namespace App\Report;

use App\Interfaces\ReportInterface;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;

    class CommissionReport implements ReportInterface
    {
        public $data;

        // public function orders11()
        // {
        //     $this->data =
        //     DB::table('orders')
        //         ->select(
        //             'orders.id',
        //             'orders.invoice_number as invoice',
        //             'orders.order_date',
        //             'users.first_name as customer_first_name',
        //             'users.last_name as customer_last_name',

        //             'orders.purchaser_id',
        //             'distributor.first_name as referral_first_name',
        //             'distributor.last_name as referral_last_name',
        //             'categories.id as purchaser_category_id',
        //             'categories.name as purchaser_category_name',
        //             'totalReferred.noOfD',
        //             DB::raw('sum(products.price) as total_price')
        //         )
        //         ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        //         ->join('users', 'users.id', '=', 'orders.purchaser_id')
        //         ->join('user_category', 'user_category.user_id', '=', 'orders.purchaser_id')
        //         ->join('categories', 'categories.id', '=', 'user_category.category_id')
        //         ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
        //         ->leftJoin('users as distributor', 'distributor.id', '=', 'users.referred_by')
        //         ->leftJoin(DB::raw('(select users.referred_by, count(users.referred_by) noOfD from users group by users.referred_by) totalReferred'), 'users.referred_by', '=', 'totalReferred.referred_by')
        //         ->groupBy('orders.id', 'invoice', 'order_date', 'customer_first_name', 'customer_last_name',  'purchaser_id', 'referral_first_name', 'referral_last_name', 'purchaser_category_id', 'purchaser_category_name', 'noOfD');
        //     return $this;
        // }

        public function orders()
        {
            $this->data = DB::table('orders')
                ->select(
                    'orders.id',
                    'orders.invoice_number as invoice',
                    'orders.order_date',
                    'users.first_name as customer_first_name',
                    'users.last_name as customer_last_name',
                    'orders.purchaser_id',
                    'distributor.first_name as referral_first_name',
                    'distributor.last_name as referral_last_name',
                    'categories.id as purchaser_category_id',
                    'categories.name as purchaser_category_name',
                    DB::raw('(SELECT COUNT(*) FROM users WHERE users.referred_by = distributor.id AND date(orders.order_date) <= date(users.enrolled_date)) as noOfD'),
                    DB::raw('SUM(products.price) as total_price, SUM(order_items.quantity) as total_quantity'),
                    // DB::raw('SUM(products.price) as total_price'),
                )
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('users', 'users.id', '=', 'orders.purchaser_id')
                ->join('user_category', 'user_category.user_id', '=', 'orders.purchaser_id')
                ->join('categories', 'categories.id', '=', 'user_category.category_id')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('users as distributor', 'distributor.id', '=', 'users.referred_by')
                ->groupBy('orders.id', 'invoice', 'order_date', 'customer_first_name', 'customer_last_name',  'purchaser_id', 'referral_first_name', 'referral_last_name', 'purchaser_category_id', 'purchaser_category_name', 'noOfD');

            return $this;
        }

        public function query()
        {
            $this->data = DB::table('orders')
                ->select(
                    'orders.id',
                    'orders.invoice_number as invoice',
                    'orders.order_date',
                    'users.first_name as customer_first_name',
                    'users.last_name as customer_last_name',
                    'orders.purchaser_id',
                    'distributor.first_name as referral_first_name',
                    'distributor.last_name as referral_last_name',
                    'categories.id as purchaser_category_id',
                    'categories.name as purchaser_category_name',
                    DB::raw('(SELECT COUNT(*) FROM users WHERE users.referred_by = distributor.id AND date(orders.order_date) <= date(users.enrolled_date)) as noOfD'),
                    DB::raw('SUM(products.price) as total_price, SUM(order_items.quantity) as total_quantity'),
                    // DB::raw('SUM(products.price) as total_price'),
                )
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('users', 'users.id', '=', 'orders.purchaser_id')
                ->join('user_category', 'user_category.user_id', '=', 'orders.purchaser_id')
                ->join('categories', 'categories.id', '=', 'user_category.category_id')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('users as distributor', 'distributor.id', '=', 'users.referred_by')
                ->groupBy('orders.id', 'invoice', 'order_date', 'customer_first_name', 'customer_last_name',  'purchaser_id', 'referral_first_name', 'referral_last_name', 'purchaser_category_id', 'purchaser_category_name', 'noOfD');

            return $this;
        }



        // public function orders13()
        // {
        //     $this->data = DB::table('orders')
        //     ->select(
        //         'orders.id',
        //         DB::raw('orders.invoice_number as invoice'),
        //         'orders.order_date',
        //         DB::raw('users.first_name as customer_first_name'),
        //         DB::raw('users.last_name as customer_last_name'),
        //         'orders.purchaser_id',
        //         DB::raw('distributor.first_name as referral_first_name'),
        //         DB::raw('distributor.last_name as referral_last_name'),
        //         'categories.id as purchaser_category_id',
        //         'categories.name as purchaser_category_name',
        //         DB::raw('totalReferred.noOfD'),
        //         DB::raw('sum(products.price) as total_price')
        //     )
        //     ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        //     ->join('users', 'users.id', '=', 'orders.purchaser_id')
        //     ->join('user_category', 'user_category.user_id', '=', 'orders.purchaser_id')
        //     ->join('categories', 'categories.id', '=', 'user_category.category_id')
        //     ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
        //     ->leftJoin('users as distributor', 'distributor.id', '=', 'users.referred_by')
        //     ->leftJoin(DB::raw('(select users.referred_by, count(users.referred_by) noOfD from users group by users.referred_by) as totalReferred'), 'users.referred_by', '=', 'totalReferred.referred_by')
        //     ->where(function ($query) {
        //         $query->where('distributor.first_name', 'LIKE', '%10000%')
        //             ->orWhere('distributor.last_name', 'LIKE', '%10000%')
        //             ->orWhere('distributor.id', '=', 10000);
        //     })
        //     ->whereDate('orders.order_date', '>=', '2020-01-31')
        //     ->groupBy('orders.id', 'invoice', 'order_date', 'customer_first_name', 'customer_last_name',  'purchaser_id', 'referral_first_name', 'referral_last_name', 'purchaser_category_id', 'purchaser_category_name', 'noOfD');


        //     return $this;
        // }

        public function paginateOrders(string $search, int $perPage=200)
        {
            $results = DB::table('orders')
                ->select('orders.id', 'orders.invoice_number as invoice', 'orders.order_date', 'users.first_name as customer_first_name', 'users.last_name as customer_last_name', 'order_items.*', 'orders.purchaser_id', 'distributor.first_name as referral_first_name', 'distributor.last_name as referral_last_name', 'categories.id as purchaser_category_id', 'categories.name as purchaser_category_name', DB::raw('sum(products.price) as total_price'), DB::raw('count(distinct users.id) as no_of_d'))
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('users', 'users.id', '=', 'orders.purchaser_id')
                ->join('user_category', 'user_category.user_id', '=', 'orders.purchaser_id')
                ->join('categories', 'categories.id', '=', 'user_category.category_id')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('users as distributor', 'distributor.id', '=', 'users.referred_by')
                ->leftJoin(DB::raw('(select referred_by, count(*) as noOfD from users group by referred_by) as totalReferred'), 'totalReferred.referred_by', '=', 'users.referred_by')
                ->where(function ($query) use ($search) {
                    $query->where('distributor.first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('distributor.last_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('distributor.id', $search);
                })
                ->whereDate('orders.order_date', '>=', '2020-01-31')
                ->groupBy('orders.id')
                ->orderBy('orders.order_date', 'DESC')
                ->paginate($perPage);

            return $results;
        }



        /**
         * used to add a where clause
         *
         * @param string $key only accepts ['first_name', 'last_name', 'id']
         * @param string $value
         * @return
         */
        public function filterBy(array $keys, string $value)
        {
            // throw_if(!in_array($key, ['first_name', 'last_name']), new Exception('invalid key passed to filter'));

            // if (in_array($key, ['first_name', 'last_name'])) $key = "users.$key";
            $this->data->where(function($query)use($keys, $value){
                foreach ($keys as $key) {
                    if($key == 'id'){
                        $query->orWhere("distributor.$key", "$value");
                    }else{
                        $query->orWhere("distributor.$key", 'LIKE', "%$value%");
                    }
                }
            });
            return $this;
        }

        public function filterByDate(?string $from, ?string $to=null)
        {
            $this->data->where(function($query)use($from, $to){
                $query->when($from, fn($q)=> $q->whereDate('orders.order_date', '>=', $from))
                    ->when($to, fn($q)=>$q->whereDate('orders.order_date', '<=', $to));
            });
            return $this;
        }
        public function generate()
        {
            return $this->data->get();
        }

    }


?>
