<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscription Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     
                         
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Event Limit</th>
                                    <th>Attendee Limit</th>
                                    <th>Seat Maps</th>
                                    <th>Discount Codes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                <tr>
                                    <td>{{ $plan->name }}</td>
                                    <td>${{ $plan->price }}</td>
                                    <td>{{ $plan->event_limit ?? 'Unlimited' }}</td>
                                    <td>{{ $plan->attendee_limit ?? 'Unlimited' }}</td>
                                    <td>{{ $plan->seat_maps ? 'Yes' : 'No' }}</td>
                                    <td>{{ $plan->discount_codes ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('subscription-plans.edit', $plan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('subscription-plans.destroy', $plan->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                     
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
