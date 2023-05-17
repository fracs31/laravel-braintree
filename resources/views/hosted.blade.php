<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            /* Campi di Braintree */
            #card-number, #cvv, #expiration-date {
                height: 40px;
                padding: 5px;
                border: 1px solid black;
            }
        </style>
    </head>
    <body class="antialiased">
        {{-- Contenuto --}}
        <div class="content">
            {{-- Messaggio di successo --}}
            @if (session('success_message'))
                <div>
                    {{ session('success_message') }}
                </div>
            @endif
            {{-- Messaggio di errore --}}
            @if (count($errors) > 0)
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- Form --}}
            <form action="{{ url('/checkout') }}" id="payment-form" method="post">
                @csrf
                {{-- Nome --}}
                <label for="first_name">Nome</label>
                <div>
                    <input type="text" name="first_name">
                </div>
                {{-- Cognome --}}
                <label for="last_name">Cognome</label>
                <div>
                    <input type="text" name="last_name">
                </div>
                {{-- Email --}}
                <label for="email">Email</label>
                <div>
                    <input type="email" name="email">
                </div>
                {{-- Quantità --}}
                <label for="amount">
                    <span class="input-label">Amount</span>
                    <div class="input-wrapper amount-wrapper">
                        <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
                    </div>
                </label>                
                {{-- Numero della carta --}}
                <label for="card-number">Card Number</label>
                <div id="card-number"></div>
                {{-- CVV --}}
                <label for="cvv">CVV</label>
                <div id="cvv"></div>
                {{-- Data di scadenza --}}
                <label for="expiration-date">Expiration Date</label>
                <div id="expiration-date"></div>
                {{-- Nonce --}}
                <input id="nonce" name="payment_method_nonce" type="hidden" />
                {{-- Submit --}}
                <button class="button" type="submit"><span>Test Transaction</span></button>
            </form>
        </div>

        {{-- Script --}}
        <script src="https://js.braintreegateway.com/web/3.94.0/js/client.min.js"></script>
        <script src="https://js.braintreegateway.com/web/3.94.0/js/hosted-fields.min.js"></script>
        <script>
        var form = document.querySelector('#payment-form');
        var submit = document.querySelector('input[type="submit"]');

        braintree.client.create({
            authorization: '{{ $token }}'
        }, function (clientErr, clientInstance) {
            if (clientErr) {
            console.error(clientErr);
            return;
            }

            // This example shows Hosted Fields, but you can also use this
            // client instance to create additional components here, such as
            // PayPal or Data Collector.

            braintree.hostedFields.create({
                client: clientInstance,
                styles: {
                    'input': {
                    'font-size': '14px'
                    },
                    'input.invalid': {
                    'color': 'red'
                    },
                    'input.valid': {
                    'color': 'green'
                    }
                },
                fields: {
                    number: {
                    container: '#card-number',
                    placeholder: '4111 1111 1111 1111'
                    },
                    cvv: {
                    container: '#cvv',
                    placeholder: '123'
                    },
                    expirationDate: {
                    container: '#expiration-date',
                    placeholder: '10/2022'
                    }
                }
            }, 
            function (hostedFieldsErr, hostedFieldsInstance) {
                if (hostedFieldsErr) {
                    console.error(hostedFieldsErr);
                    return;
                }

                //submit.removeAttribute('disabled');

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
                        if (tokenizeErr) {
                            console.error(tokenizeErr);
                            return;
                        }

                        // If this was a real integration, this is where you would
                        // send the nonce to your server.
                        //console.log('Got a nonce: ' + payload.nonce);
                        document.querySelector('#nonce').value = payload.nonce;
                        form.submit();
                    });
                }, false);
            });
        });
    </script>
    </body>
</html>