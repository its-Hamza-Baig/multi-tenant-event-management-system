<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row mt-5">
                        @forelse ($plans as $plan)
                            
                            <div class="col-3">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $plan->name }}</h5> 
                                       
                                        <ul>
                                            <li>Price : {{ $plan->price }}</li>
                                            <li>Event Limit : {{ $plan->event_limit }}</li>
                                            <li>Attendee Limit : {{ $plan->attendee_limit }}</li>
                                            <li>Seat Maps : {{ $plan->seat_maps }}</li>
                                            <li>Discount Codes : {{ $plan->discount_codes }}</li> 
                                        </ul>
                                        <a href="{{ route('subscribe.plan', $plan->id) }}" class="btn btn-sm btn-info">Subscribe</a>
                                    </div>
                                </div>
                            </div>
        
                        @empty
                            
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
