<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Setting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full"> 
                    
                    <form action="{{ route('payment.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="mb-3">
                            <x-input-label for="stripe_public_key" :value="__('Stripe API Key')" />
                            <x-text-input id="stripe_public_key" name="stripe_public_key" type="text" class="mt-1 block w-full" :value="old('stripe_public_key', $paymentSettings->stripe_public_key ?? '')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('stripe_public_key')" />
                        </div>
                    
                        <div class="mb-3">
                            <x-input-label for="stripe_secret_key" :value="__('Stripe Secret')" />
                            <x-text-input id="stripe_secret_key" name="stripe_secret_key" type="text" class="mt-1 block w-full" :value="old('stripe_secret_key', $paymentSettings->stripe_secret_key ?? '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('stripe_secret_key')" />
                        </div>
                    
                        {{-- <div class="mb-3">
                            <x-input-label for="stripe_webhook_secret" :value="__('Stripe Webhook Secret')" />
                            <x-text-input id="stripe_webhook_secret" name="stripe_webhook_secret" type="text" class="mt-1 block w-full" :value="old('stripe_webhook_secret', $paymentSetting->stripe_webhook_secret ?? '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('stripe_webhook_secret')" />
                        </div>
                     --}}
                         
                    
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Payment Settings') }}</x-primary-button>
                        </div>
                    
                    </form>
                    
 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
