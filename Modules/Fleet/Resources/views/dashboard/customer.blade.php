@extends('layouts.main')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('page-breadcrumb')
    {{ __('Fleet') }}
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xxl-6">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-truck-delivery"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                                <h6 class="mb-3">{{ __('Yet to start Booking') }}</h6>
                                <h3 class="mb-0">{{ $curr_start }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-truck-delivery"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                                <h6 class="mb-3">{{ 'On Going Booking' }}</h6>
                                <h3 class="mb-0">{{ $curr_ongoing }} </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-avtar bg-warning">
                                    <i class="ti ti-truck-delivery"></i>
                                </div>
                                <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                                <h6 class="mb-3">{{ 'Complete Booking' }}</h6>
                                <h3 class="mb-0">{{ $curr_complete }}</h3>
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
                                <h6 class="mb-3">{{ 'Cancelled Booking' }}</h6>
                                <h3 class="mb-0">{{ $curr_cancelled }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6">
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
                                            <td>  {{ !empty($booking->vehicle) ? $booking->vehicle->name : '' }}
                                            </td>
                                            <td>{{ $booking->start_date }} <br>
                                                <b>{{ __('To') }}</b><br>{{ $booking->end_date }}</td>
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
        </div>
    </div>
@endsection
