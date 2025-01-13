@extends('layouts.main')
@section('page-title')
    {{ __('Manage Booking') }}
@endsection
@section('page-breadcrumb')
    {{ __('Booking') }}
@endsection
@section('page-action')
    <div>
        @permission('booking create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Booking') }}"
                data-url="{{ route('booking.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Vehicle Name') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Trip Type') }}</th>
                                    <th>{{ __('Total Price') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th width="250px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>
                                            {{ !empty($booking->BookingUser) ? $booking->BookingUser->name : '' }}
                                        </td>
                                        <td>
                                            {{ !empty($booking->vehicle) ? $booking->vehicle->name : '' }}
                                        </td>

                                        <td>{{ $booking->start_date }}
                                        <td>{{ $booking->end_date }}
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
                                        <td class="Action">
                                            <span>
                                                @permission('booking show')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="{{ route('booking.show', $booking->id) }}"
                                                            class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip"
                                                            title="" data-bs-original-title="{{ __('Show') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                                @permission('booking edit')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="{{ route('booking.edit', $booking->id) }}"
                                                            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Booking') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                                @permission('booking delete')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {{ Form::open(['route' => ['booking.destroy', $booking->id], 'class' => 'm-0']) }}
                                                        @method('DELETE')
                                                        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="delete-form-{{ $booking->id }}"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endpermission
                                            </span>
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
@endsection
