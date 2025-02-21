<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <div class="row">
                        <div class="col-12">
                             <form action="{{ route('events.update', $event->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <x-input-label for="title" :value="__('Title')" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $event->title)" required autofocus autocomplete="Title" />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-textarea id="description" name="description" class="mt-1 block w-full"  required >{{ old('description', $event->description ?? '') }}</x-textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />

                                </div>

                                <div class="mb-3">
                                    <x-input-label for="start_time" :value="__('Start Time')" />
                                    <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time', Carbon\Carbon::parse($event->start_time)->format('H:i'))" required autofocus   />
                                    <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                                </div>
                                

                                <div class="mb-3">
                                    <x-input-label for="end_time" :value="__('End Time')" />
                                    <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" :value="old('end_time', Carbon\Carbon::parse($event->end_time)->format('H:i'))" required autofocus   />
                                    <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="capacity" :value="__('Capacity')" />
                                    <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full" :value="old('capacity', $event->capacity)" required autofocus   />
                                    <x-input-error class="mt-2" :messages="$errors->get('capacity')" />
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
</x-app-layout>
