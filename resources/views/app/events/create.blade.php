<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <div class="row">
                        <div class="col-12">
                             <form action="{{ route('events.store') }}" method="post">
                                @csrf
                                
                                <div class="mb-3">
                                    <x-input-label for="title" :value="__('Title')" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus autocomplete="Title" />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-textarea id="description" name="description" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="start_time" :value="__('Start Time')" />
                                    <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="end_time" :value="__('End Time')" />
                                    <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" :value="old('end_time')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="capacity" :value="__('Capacity')" />
                                    <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full" :value="old('capacity')" max="{{ $attendeeLimit }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('capacity')" />
                                </div>
                                @if(tenant()->subscription->plan->seat_maps)
                                                
                                    <div class="mb-6">
                                        <x-input-label :value="__('Seat Map')" />
                                        <div id="seat-map" class="grid grid-cols-5 gap-2 p-4 border border-gray-300 rounded-lg">
                                            <!-- Seats will be generated here -->
                                        </div>
                                        <button type="button" id="add-seat" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Add Seat</button>
                                        <input type="hidden" name="seat_map" id="seat_map_data">
                                    </div>
                                @else
                                    <p class="text-red-500">Upgrade your plan to create a seat map.</p>
                                @endif
                                
                                <div class="mb-3">
                                    <x-input-label :value="__('Event Type')" />
                                    <div class="flex gap-4 mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="event_type" value="free" id="event_free" class="form-radio" checked>
                                            <span class="ml-2">Free</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="event_type" value="paid" id="event_paid" class="form-radio">
                                            <span class="ml-2">Paid</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="mb-3 hidden" id="price_field">
                                    <x-input-label for="price" :value="__('Event Price (USD)')" />
                                    <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price')" step="0.01" min="0" />
                                    <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                </div>
                                
                                <div class="mb-3 hidden" id="discount_field">
                                    <x-input-label for="discount" :value="__('Discount (%)')" />
                                    <x-text-input id="discount" name="discount" type="number" class="mt-1 block w-full" :value="old('discount')" step="0.01" min="0" max="100" />
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                </div>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const priceField = document.getElementById('price_field');
            document.getElementById('event_paid').addEventListener('change', () => priceField.classList.remove('hidden'));
            document.getElementById('event_free').addEventListener('change', () => priceField.classList.add('hidden'));
            
            const seatMap = document.getElementById('seat-map');
            const seatData = document.getElementById('seat_map_data');
            document.getElementById('add-seat').addEventListener('click', () => {
                const seat = document.createElement('div');
                seat.classList.add('p-3', 'bg-gray-200', 'rounded', 'text-center', 'cursor-pointer');
                seat.textContent = `S${seatMap.children.length + 1}`;
                seat.addEventListener('click', () => seat.remove());
                seatMap.appendChild(seat);
                updateSeatData();
            });

            function updateSeatData() {
                const seats = Array.from(seatMap.children).map(seat => seat.textContent);
                seatData.value = JSON.stringify(seats);
            }
        });
    </script>
</x-tenant-app-layout>
