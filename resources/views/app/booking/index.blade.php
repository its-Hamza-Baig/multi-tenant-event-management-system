<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     
                         
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Event Start Time</th>
                                    <th>Event End Time</th>
                                    <th>Price</th>
                                    <th>Booking Date</th> 
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->event->title }}</td>
                                    <td>{{ $item->event->start_time }}</td>
                                    <td>{{ $item->event->end_time }}</td>
                                    <td>{{ $item->event->price ? '$' : '' }} {{ $item->event->price }}</td>
                                    <td>{{ $item->created_at }}</td>
                                      
                                    {{-- <td>
                                         
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                     
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
