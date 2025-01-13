@extends('layouts.main')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('page-breadcrumb')
    {{ __('Fleet') }}
@endsection

@php
    $user = \Auth::user();
@endphp

@section('content')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xxl-7">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-warning">
                                    <i class="ti ti-users"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                                <h6 class="mb-3">{{ 'Customers' }}</h6>
                                <h3 class="mb-0">{{ $Customers['customer'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-danger">
                                    <i class="ti ti-truck-delivery"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                                <h6 class="mb-3">{{ 'Drivers' }}</h6>
                                <h3 class="mb-0">{{ $Drivers['driver'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-car"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                                <h6 class="mb-3">{{ __('Vehicle')}}</h6>
                                <h3 class="mb-0">{{ $Vehicle['vehicle'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-book"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                                <h6 class="mb-3">{{('Booking')}}</h6>
                                <h3 class="mb-0">{{ $Booking['booking'] }} </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>{{ __('Latest Bookings') }} </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Customer Name') }}</th>
                                        <th>{{ __('Vechicle Name') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Trip Type') }}</th>
                                        <th>{{ __('Total Price') }}</th>
                                        <th>{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td> {{ !empty($booking->BookingUser) ? $booking->BookingUser->name : '' }}
                                            </td>
                                            <td>{{ !empty($booking->vehicle) ? $booking->vehicle->name : '' }}
                                            </td>
                                            <td>{{ $booking->start_date }} <br>
                                                <b>{{ __('To') }}</b><br>{{ $booking->end_date }}
                                            </td>
                                            <td>{{ $booking->trip_type }}</td>
                                            <td>{{ $booking->total_price }}</td>
                                            <td>
                                                @if ($booking->status == 'Yet to start')
                                                    <span
                                                        class="status_badge badge bg-warning p-2 px-3 rounded">{{ __('Yet to start') }}</span>
                                                @elseif($booking->status == 'Completed')
                                                    <span
                                                        class="status_badge badge bg-success p-2 px-3 rounded">{{ __('Completed') }}</span>
                                                @elseif($booking->status == 'OnGoing')
                                                    <span
                                                        class="status_badge badge bg-info p-2 px-3 rounded">{{ __('OnGoing') }}</span>
                                                @else
                                                    <span
                                                        class="status_badge badge bg-danger p-2 px-3 rounded">{{ __('Cancelled') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5">


                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Maintenance'.' '.'&'.' '.'Fuel'.' '.'&'.' '.'Booking')}}</h5>
                        </div>
                        <div class="card-body">
                            <div id="myChart"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Booking Status') }}</h5>
                        <span class="text-sm text-muted">({{ $curr_month }})
                            {{ 'Total booking of last month' }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-6 my-2">
                                <div class="d-flex align-items-start">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-book"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">{{ __('Yet To Start') }}</p>
                                        <h4 class="mb-0 text-primary">{{ $curr_start }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 my-2">
                                <div class="d-flex align-items-start">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-book"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">{{ __('On Going') }}</p>
                                        <h4 class="mb-0 text-info">{{ $curr_ongoing }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 my-2">
                                <div class="d-flex align-items-start">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-book"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">{{ __('Complete') }}</p>
                                        <h4 class="mb-0 text-warning">{{ $curr_complete }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 my-2">
                                <div class="d-flex align-items-start">
                                    <div class="theme-avtar bg-danger">
                                        <i class="ti ti-book"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">{{ __('Cancelled') }}</p>
                                        <h4 class="mb-0 text-danger">{{ $curr_cancelled }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
@endsection
@push('scripts')
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script>
    (function() {
        var options = {
            chart: {
                height: 250,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },

            series: [{
                name: "Maintenance",
                data: {!! json_encode($chartData['maintenance']) !!}
                }, {
                name: "Fuel",
                data: {!! json_encode($chartData['fuel']) !!}
                },{
                name: "Booking",
                data: {!! json_encode($chartData['booking']) !!}
                }],


            xaxis: {
                categories:{!! json_encode($chartData['date']) !!},
                title: {
                    text: "{{__('Days')}}"
                }
            },
            colors: ['#453b85', '#FF3A6E', '#3ec9d6'],

            grid: {
                strokeDashArray: 4,
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'right',
            },
            yaxis: {
                tickAmount: 6,

            }

        };
        var chart = new ApexCharts(document.querySelector("#myChart"), options);
        chart.render();
    })();

</script>

@endpush
