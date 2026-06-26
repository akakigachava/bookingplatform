<x-guest-layout>

    {{-- Heading --}}
    <div class="mb-8">
        <h2 class="font-extrabold" style="font-size:28px; color:#0b1c30; letter-spacing:-0.02em;">Welcome back</h2>
        <p class="mt-1.5 text-sm" style="color:#514348;">Sign in to your BookEase account.</p>
    </div>

    {{-- Session status --}}
    @if(session('status'))
        <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl text-sm"
             style="background:#bcedda; color:#002118; border:1px solid #a0d1bf;">
            <span class="material-symbols-outlined shrink-0" style="font-size:17px; color:#356253;">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider mb-1.5"
                   style="color:#514348;">Email address</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2"
                      style="font-size:18px; color:#d6c1c7; pointer-events:none;">mail</span>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm transition focus:outline-none focus:ring-2 focus:border-transparent"
                       style="border-color:{{ $errors->get('email') ? '#ba1a1a' : '#d6c1c7' }}; background:#fafeff; color:#0b1c30; --tw-ring-color:#864461;"
                       placeholder="you@example.com">
            </div>
            @error('email')
                <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#ba1a1a;">
                    <span class="material-symbols-outlined" style="font-size:13px;">error</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider"
                       style="color:#514348;">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs font-semibold transition hover:opacity-70"
                       style="color:#864461;">Forgot password?</a>
                @endif
            </div>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2"
                      style="font-size:18px; color:#d6c1c7; pointer-events:none;">lock</span>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm transition focus:outline-none focus:ring-2 focus:border-transparent"
                       style="border-color:{{ $errors->get('password') ? '#ba1a1a' : '#d6c1c7' }}; background:#fafeff; color:#0b1c30; --tw-ring-color:#864461;"
                       placeholder="••••••••">
            </div>
            @error('password')
                <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#ba1a1a;">
                    <span class="material-symbols-outlined" style="font-size:13px;">error</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border cursor-pointer transition focus:ring-2"
                   style="border-color:#d6c1c7; accent-color:#864461;">
            <label for="remember_me" class="text-sm cursor-pointer" style="color:#514348;">
                Remember me for 30 days
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold text-white shadow-md transition hover:opacity-90 active:scale-[0.98]"
                style="background:#864461; letter-spacing:0.01em;">
            Sign in
            <span class="material-symbols-outlined" style="font-size:17px; font-variation-settings:'FILL' 1;">arrow_forward</span>
        </button>

    </form>

    {{-- Register link --}}
    <p class="mt-8 text-center text-sm" style="color:#847378;">
        Don't have an account?
        <a href="{{ route('register') }}"
           class="font-semibold ml-1 transition hover:opacity-70"
           style="color:#864461;">Create one free</a>
    </p>

</x-guest-layout>
