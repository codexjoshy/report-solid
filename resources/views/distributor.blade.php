@extends('layouts.app')
@section('heading')
<h1>Distributors Report</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <x-base.card title="Top 200 Distributors">
            <x-base.reportable>
                <x-slot name="thead">
                    <tr>
                        <th>Top</th>
                        <th>Distributor's Name</th>
                        <th>Total Sales</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($reportData as $data)

                    <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>
                            {{ $data->first_name }} {{ $data->last_name }}
                        </td>
                        <td>{{ $data->total_order }}</td>
                    </tr>
                    @endforeach
                </x-slot>
            </x-base.reportable>
        </x-base.card>
    </div>
</div>
@endsection
