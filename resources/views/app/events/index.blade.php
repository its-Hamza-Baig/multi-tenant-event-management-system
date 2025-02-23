<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full"> 
                    
                    <section class="space-y-12">
                        <x-table 
                            :table-classes="'table table-bordered table-hover w-full'"   
                            :headers="['Title', 'Description', 'Start Time', 'End Time', 'Capacity', 'Booked', 'Available', 'Entry Type', 'Price', 'Action']" 
                            :rows="$events"
                        />
                    </section>
 
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
