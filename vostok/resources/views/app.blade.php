<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @if(config('app.env') === 'production')
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function () {
            OneSignal.init({
                appId: "{{ config('services.onesignal.app_id') }}",
                notifyButton: {
                    enable: true,
                },
            });
        });
        OneSignal.push(function () {
            OneSignal.on('subscriptionChange', function (isSubscribed) {
                if (isSubscribed) {
                    // The user is subscribed
                    //   Either the user subscribed for the first time
                    //   Or the user was subscribed -> unsubscribed -> subscribed
                    OneSignal.getUserId(function (userId) {
                        // Make a POST call to your server with the user ID
                        fetch("{{ route('one_signal') }}", {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content
                            },
                            method: "POST",
                            body: JSON.stringify({token: userId})
                        })
                    });
                }
            });
        });
    </script>
@endif
    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
@inertia
</body>
</html>
