<x-tenant-app-layout>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        #card-element {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stripe Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
    
                    <form id="payment-form" action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <label>Plan: {{ $plan->name }} - ${{ $plan->price }}</label><br><br>

                        <div id="card-element"></div> <!-- Stripe Card Input -->
                        <button type="submit" id="submit-button" class="btn btn-primary w-100 mt-5">Pay ${{ $plan->price }}</button>
                    </form>

                    <script>
                        let stripe = Stripe("{{ $keys->stripe_public_key }}");
                        let elements = stripe.elements();
                        let card = elements.create('card');
                        card.mount('#card-element');

                        let form = document.getElementById('payment-form');
                        form.addEventListener('submit', async function(event) {
                            event.preventDefault();
                            let { token, error } = await stripe.createToken(card);
                            if (error) {
                                alert(error.message);
                            } else {
                                let hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'stripeToken';
                                hiddenInput.value = token.id;
                                form.appendChild(hiddenInput);
                                form.submit();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>