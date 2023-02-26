<?php
namespace App\Report;

use App\Interfaces\FilterByDateInterface;
use App\Interfaces\FilterByKeysInterface;
use App\Interfaces\ReportInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

    class CommissionReport implements ReportInterface, FilterByDateInterface, FilterByKeysInterface
    {
        public Builder $data;

        public function query()
        {
            $this->data =  DB::table('orders as o')
                        ->join('users as u1', 'o.purchaser_id', '=', 'u1.id')
                        ->leftJoin('users as u2', 'u1.referred_by', '=', 'u2.id')
                        ->join('order_items as oi', 'o.id', '=', 'oi.order_id')
                        ->join('products as p', 'oi.product_id', '=', 'p.id')
                        ->join('user_category', 'user_category.user_id', '=', 'o.purchaser_id')
                        ->join('categories as c', 'user_category.category_id', '=', 'c.id')
                        ->leftJoin('user_category as user_distributor_category', 'user_distributor_category.user_id', '=', 'u2.id')
                        ->join('categories as distributor_category', 'distributor_category.id', '=', 'user_distributor_category.category_id')

                        ->select(
                            'o.invoice_number as invoice', 'o.purchaser_id','o.order_date',
                            'u1.first_name as customer_first_name',
                            'u1.last_name as customer_last_name',

                            'u2.first_name as referral_first_name',
                            'u2.last_name as referral_last_name',

                            'c.id as purchaser_category_id',

                            'distributor_category.id as distributor_category_id',
                            'distributor_category.name as distributor_category_name',

                            DB::raw('COUNT( u2.id) as `noOfD`'),

                            DB::raw("
                                GROUP_CONCAT(DISTINCT p.name ORDER BY p.name ASC SEPARATOR ', ') AS product_names,
                                GROUP_CONCAT(DISTINCT p.sku ORDER BY p.name ASC SEPARATOR ', ') AS product_skus,
                                GROUP_CONCAT( p.price ORDER BY p.name ASC SEPARATOR ', ') AS product_prices,
                                GROUP_CONCAT( oi.quantity ORDER BY p.name ASC SEPARATOR ', ') AS product_quantities"
                            ),
                            DB::raw("SUM(p.price) as total_price, SUM(oi.quantity) as total_quantity"),
                        )
                        ->where('distributor_category.id', '=', '1')
                        ->whereNotNull('u1.referred_by')
                        ->where('u1.enrolled_date', '<=', DB::raw('o.order_date'))
                        ->groupBy('o.id', 'invoice','purchaser_category_id', 'order_date', 'customer_first_name', 'customer_last_name',  'purchaser_id', 'referral_first_name', 'referral_last_name','distributor_category_id','distributor_category_name','order_date');

            return $this;
        }
        public function query1()
        {
            $this->data = DB::table('orders')
                ->select(
                    'orders.id as orderId',
                    'orders.invoice_number as invoice',
                    'orders.order_date',
                    'users.first_name as customer_first_name',
                    'users.last_name as customer_last_name',
                    'orders.purchaser_id',
                    'distributor.first_name as referral_first_name',
                    'distributor.last_name as referral_last_name',
                    'categories.id as purchaser_category_id',
                    'categories.name as purchaser_category_name',
                    'distributor_category.id as distributor_category_id',
                    'distributor_category.name as distributor_category_name',
                    DB::raw("
                        GROUP_CONCAT(DISTINCT products.name ORDER BY products.name ASC SEPARATOR ', ') AS product_names,
                        GROUP_CONCAT(DISTINCT products.sku ORDER BY products.name ASC SEPARATOR ', ') AS product_skus,
                        GROUP_CONCAT( products.price ORDER BY products.name ASC SEPARATOR ', ') AS product_prices,
                        GROUP_CONCAT( order_items.quantity ORDER BY products.name ASC SEPARATOR ', ') AS product_quantities"
                    ),
                    DB::raw("
                        (SELECT COUNT(*) FROM users INNER JOIN user_category as u_c ON u_c.user_id=users.id WHERE (users.referred_by = distributor.id AND date(users.enrolled_date) <= date(orders.order_date)) AND u_c.category_id=1)  as noOfD"
                    ),
                    DB::raw("SUM(products.price) as total_price, SUM(order_items.quantity) as total_quantity"),
                )
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('users', 'users.id', '=', 'orders.purchaser_id')
                ->leftJoin('users as distributor', 'distributor.id', '=', 'users.referred_by')
                ->join('user_category', 'user_category.user_id', '=', 'orders.purchaser_id')
                ->leftJoin('user_category as user_distributor_category', 'user_distributor_category.user_id', '=', 'distributor.id')

                ->join('categories', 'categories.id', '=', 'user_category.category_id')
                ->join('categories as distributor_category', 'distributor_category.id', '=', 'user_distributor_category.category_id')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->groupBy('orders.id', 'invoice', 'order_date', 'customer_first_name', 'customer_last_name',  'purchaser_id', 'referral_first_name', 'referral_last_name', 'purchaser_category_id', 'purchaser_category_name','distributor_category_id','distributor_category_name', 'noOfD')
                ->orderByDesc('orders.order_date');

            return $this;
        }

        /**
         * custom function used to add a where clause
         *
         * @param string $key only accepts ['first_name', 'last_name', 'id']
         * @param string $value
         * @return $this
         */
        public function filterBy(array $keys, string $value)
        {

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
