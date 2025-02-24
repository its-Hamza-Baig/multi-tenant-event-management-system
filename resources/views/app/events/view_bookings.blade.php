<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     
                         
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Person Name</th>
                                    <th>Email</th>
                                    <th>Time</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->bookings as $item)
                                <tr>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->user->email }}</td>
                                    <td>{{ $item->created_at->format('Y m d') }}</td> 
                                      
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
