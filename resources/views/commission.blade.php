@extends('layouts.app')
@section('heading')
<h1>Commission Report</h1>
@endsection
@section('content')
<div class="row mb-4">
    <div class="col-5 mb-4">
        <x-base.card title="Filters">
            <x-base.form  autocomplete="off" method="get">
                <div class="form-row">
                    <x-base.form-group label="Distributor" class="col-md-12 ">
                        <x-base.input :value="old('search')??$request->search" id="search" name="search" type="text" class="searchParam" />
                    </x-base.form-group>
                    <x-base.form-group class="col-md-6" label="Date From:">
                        <x-base.input name="from" type="date" :value="$request->from ? date('Y-m-d', strtotime($request->from)):''" />
                    </x-base.form-group>
                    <x-base.form-group class="col-md-6" label="Date To:">
                        <x-base.input name="to" type="date" :value="$request->to ? date('Y-m-d',strtotime($request->to)):''" />
                        </x-base.form-group>
                </div>
                <x-base.form-group class="text-center">
                    <button class="btn btn-primary" id="searchBtn">
                        Generate
                    </button>
                </x-base.form-group>
            </x-base.form>
        </x-base.card>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <x-base.card title="Report">
            <x-base.reportable>
                <x-slot name="thead">
                    <tr>
                        <th>Invoice</th>
                        <th>Purchaser</th>
                        <th>Distributor</th>
                        <th>Referred Distributors</th>
                        <th>Order Date</th>
                        <th>Order Total</th>
                        <th>Percentage</th>
                        <th>Distributors Commission</th>
                        <th>Action</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @forelse ($reportData as $data)
                        @php
                            $purchaserIsCustomer = $data->purchaser_category_id == $CustomerCategoryEnum->value;

                            $totalOrder = $data->total_price * $data->total_quantity;

                            /** @var \App\Services\CommisionService $CommissionService */
                            $commissionPercent = $purchaserIsCustomer ?  $CommissionService->commissionPercent($data->noOfD): null;
                            $totalPercentage = !is_null($commissionPercent) ? $CommissionService->commissionAmount($totalOrder, $commissionPercent) : null;

                            $fullName = $data->distributor_category_id == $DistributorCategoryEnum->value ?  "$data->referral_first_name  $data->referral_last_name": '';

                            $productNames = explode(", ",$data->product_names ?? "");
                            $productSkus = explode(", ",$data->product_skus ?? "");
                            $productPrices = explode(", ",$data->product_prices ?? "");
                            $productQuantities = explode(", ",$data->product_quantities ?? "");

                            $products = array_map(function($item, $item2, $item3, $item4){
                                    return ["name"=>$item, "sku"=>$item2, "price"=>$item3, "quantity"=>$item4];
                                }, $productNames, $productSkus, $productPrices, $productQuantities) ??[];

                        @endphp
                    <tr>
                        <td>{{ $data->invoice }}</td>
                        <td>{{ $data->customer_first_name }} {{ $data->customer_last_name }}</td>
                        <td>{{ $fullName }}</td>
                        <td>{{ $data->noOfD }}</td>
                        <td>{{ date('d/m/Y', strtotime($data->order_date)) }}</td>
                        <td>{{ $totalOrder }}</td>
                        <td>{{ $commissionPercent ? "$commissionPercent%":'' }}</td>
                        <td>{{ number_format($totalPercentage,2) }}</td>
                        <td>
                            <x-modal-button class="btn-info btn-sm" key="view-{{ $data->invoice }}">
                                View Items
                            </x-modal-button>
                            <x-modal title="INVOICE {{ $data->invoice }}" key="view-{{ $data->invoice }}"
                                data-backdrop="static">
                                <x-base.table>
                                    <x-slot name='thead'>
                                        <tr>
                                            <th>SKU</th><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total</th>
                                        </tr>
                                    </x-slot>
                                    <x-slot name='tbody'>
                                        @foreach ($products as $product)
                                            @php
                                            $quantity = (int)  $product['quantity'];
                                            $price = (float) $product['price'];
                                            $total = $quantity * $price;

                                            @endphp
                                            <tr>
                                                <td>{{ $product['sku'] }} </td>
                                                <td>{{ $product['name'] }}</td>
                                                <td>{{ $product['price'] }}</td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>{{ $total }}</td>
                                            </tr>
                                        @endforeach
                                    </x-slot>
                                </x-base.table>
                            </x-modal>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No Record Found</td>

                    </tr>
                    @endforelse
                </x-slot>
            </x-base.reportable>
        </x-base.card>
    </div>
</div>
@endsection
