<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Subscription Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     
                    <form action="{{ route('subscription-plans.update', $subscriptionPlan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $subscriptionPlan->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Price:</label>
                            <input type="number" name="price" class="form-control" value="{{ $subscriptionPlan->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Event Limit:</label>
                            <input type="number" name="event_limit" class="form-control" value="{{ $subscriptionPlan->event_limit }}">
                        </div>
                        <div class="mb-3">
                            <label>Attendee Limit:</label>
                            <input type="number" name="attendee_limit" class="form-control" value="{{ $subscriptionPlan->attendee_limit }}">
                        </div>
                        <div class="mb-3">
                            <label>Seat Maps:</label>
                            <input type="checkbox" name="seat_maps" value="1" {{ $subscriptionPlan->seat_maps ? 'checked' : '' }}>
                        </div>
                        <div class="mb-3">
                            <label>Discount Codes:</label>
                            <input type="checkbox" name="discount_codes" value="1" {{ $subscriptionPlan->discount_codes ? 'checked' : '' }}>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Plan</button>
                    </form>
                     
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
