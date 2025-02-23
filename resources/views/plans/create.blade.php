<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Subscription Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     
                    <form action="{{ route('subscription-plans.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Name:</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            @error('name')
                                <div class="error-message" >
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Price:</label>
                            <input type="number" name="price" value="{{ old('price') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            @error('price')
                                <div class="error-message" >
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Event Limit:</label>
                            <input type="number" name="event_limit" value="{{ old('event_limit') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @error('event_limit')
                                <div class="error-message" >
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Attendee Limit:</label>
                            <input type="number" name="attendee_limit" value="{{ old('attendee_limit') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @error('attendee_limit')
                                <div class="error-message" >
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Seat Maps:</label>
                            <input type="checkbox" name="seat_maps" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500   shadow-sm" value="1">
                            @error('seat_maps')
                                <div class="error-message" >
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Discount Codes:</label>
                            <input type="checkbox" name="discount_codes" class="  border-gray-300 focus:border-indigo-500 focus:ring-indigo-500   shadow-sm" value="1">
                            @error('discount_codes')
                                <div class="error-message" >
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create Plan</button>
                    </form>
                     
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
