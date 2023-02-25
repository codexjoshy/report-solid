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
            <x-base.dataTable>
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
                            $purchaserIsCustomer = $data->purchaser_category_id == $DistributorCategoryEnum->value;
                            $totalOrder = $data->total_price * $data->total_quantity;

                            /** @var \App\Services\CommisionService $CommissionService */
                            $commissionPercent = $purchaserIsCustomer ?  $CommissionService->commissionPercent($data->noOfD): null;
                            $totalPercentage = !is_null($commissionPercent) ? $CommissionService->commissionAmount($totalOrder, $commissionPercent) : null;

                            $fullName = $data->distributor_category_id == 1 ?  "$data->referral_first_name  $data->referral_last_name": '';

                        @endphp
                    <tr>
                        <td>{{ $data->invoice }}</td>
                        <td>{{ $data->customer_first_name }} {{ $data->customer_last_name }}</td>
                        <td>{{ $fullName }}</td>
                        <td>{{ $data->noOfD }}</td>
                        <td>{{ date('d/m/Y', strtotime($data->order_date)) }}</td>
                        <td>{{ $totalOrder }}</td>
                        <td>{{ $commissionPercent }}</td>
                        <td>{{ $totalPercentage }}</td>
                        <td>
                            <x-modal-button class="btn-info btn-sm" key="view-">
                                View Items
                            </x-modal-button>
                            <x-modal title="" key="view-"
                                data-backdrop="static">
                            </x-modal>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No Record Found</td>

                    </tr>
                    @endforelse
                </x-slot>
            </x-base.dataTable>
        </x-base.card>
    </div>
</div>
@endsection
