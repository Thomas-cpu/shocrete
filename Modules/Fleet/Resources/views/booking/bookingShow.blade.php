
<div class="modal-body">
    <ul class="list-unstyled">
        <li class="mb-2"><strong class="text-dark">{{ __('Customer Name')}} :</strong> &nbsp;
            {{ !empty($booking->BookingUser) ? $booking->BookingUser->name : '' }}

        </li>
        <li class="mb-2"><strong class="text-dark">{{ __('Vehicle Name')}} :</strong> &nbsp;
            {{ !empty($booking->vehicle) ? $booking->vehicle->name : '' }}
        </li>
        <li class="mb-2"><strong class="text-dark">{{ __('Trip Type')}} :</strong> &nbsp;
            {{$booking->trip_type}}
        </li>
        <li class="mb-2"><strong class="text-dark">{{ __('Start Location')}} :</strong> &nbsp;
            {{$booking->start_address}}
        </li>
        <li class="mb-2"><strong class="text-dark">{{ __('End Location')}} :</strong> &nbsp;
            {{$booking->end_address}}
        </li>
        <li class="mb-2"><strong class="text-dark">{{ __('Description')}} :</strong> &nbsp;
            {{$booking->notes}}
        </li>
    </ul>
</div>
