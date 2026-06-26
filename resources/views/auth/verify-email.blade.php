<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify your email — {{ config('app.name', 'BookEase') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-pink-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

            {{-- Top color bar --}}
            <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #b5708a, #8b4a6b, #6d3a8a);"></div>

            <div class="px-8 py-10 text-center">

                {{-- Email icon illustration --}}
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #b5708a, #8b4a6b);">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        {{-- Floating badge --}}
                        <div class="absolute -top-1.5 -right-1.5 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-3.5 h-3.5 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Heading --}}
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Check your inbox</h1>
                <p class="text-gray-500 text-sm leading-relaxed mb-1">
                    We sent a verification link to
                </p>
                <p class="font-semibold text-sm mb-6" style="color: #b5708a;">
                    {{ Auth::user()->email }}
                </p>

                {{-- Steps --}}
                <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left space-y-3">
                    @foreach([
                        ['Open your email inbox', 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['Find the email from BookEase', 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                        ['Click "Verify Email Address"', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ] as $i => [$label, $icon])
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full text-white text-xs font-bold flex items-center justify-center flex-shrink-0" style="background: #b5708a;">
                            {{ $i + 1 }}
                        </div>
                        <span class="text-sm text-gray-600">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Success message --}}
                @if(session('status') == 'verification-link-sent')
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-xl mb-4">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        New verification email sent successfully!
                    </div>
                @endif

                {{-- Resend button --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 px-4 text-white text-sm font-semibold rounded-xl transition hover:opacity-90 shadow-md mb-3"
                        style="background: linear-gradient(135deg, #b5708a, #8b4a6b);">
                        Resend Verification Email
                    </button>
                </form>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-400 hover:text-gray-600 transition">
                        Use a different account? Log out
                    </button>
                </form>

            </div>
        </div>

        {{-- Footer note --}}
        <p class="text-center text-xs text-gray-400 mt-6">
            Didn't get the email? Check your spam folder or click "Resend" above.
        </p>

    </div>

</body>
</html>
