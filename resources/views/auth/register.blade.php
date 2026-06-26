<x-guest-layout>

    {{-- Heading --}}
    <div class="mb-8">
        <h2 class="font-extrabold" style="font-size:28px; color:#0b1c30; letter-spacing:-0.02em;">Create an account</h2>
        <p class="mt-1.5 text-sm" style="color:#514348;">Start booking appointments in seconds.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-semibold uppercase tracking-wider mb-1.5"
                   style="color:#514348;">Full name</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2"
                      style="font-size:18px; color:#d6c1c7; pointer-events:none;">person</span>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       required autofocus autocomplete="name"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm transition focus:outline-none focus:ring-2 focus:border-transparent"
                       style="border-color:{{ $errors->get('name') ? '#ba1a1a' : '#d6c1c7' }}; background:#fafeff; color:#0b1c30; --tw-ring-color:#864461;"
                       placeholder="Jane Smith">
            </div>
            @error('name')
                <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#ba1a1a;">
                    <span class="material-symbols-outlined" style="font-size:13px;">error</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider mb-1.5"
                   style="color:#514348;">Email address</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2"
                      style="font-size:18px; color:#d6c1c7; pointer-events:none;">mail</span>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autocomplete="username"
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
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider mb-1.5"
                   style="color:#514348;">Password</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2"
                      style="font-size:18px; color:#d6c1c7; pointer-events:none;">lock</span>
                <input id="password" type="password" name="password"
                       required autocomplete="new-password"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm transition focus:outline-none focus:ring-2 focus:border-transparent"
                       style="border-color:{{ $errors->get('password') ? '#ba1a1a' : '#d6c1c7' }}; background:#fafeff; color:#0b1c30; --tw-ring-color:#864461;"
                       placeholder="Min. 8 characters">
            </div>
            @error('password')
                <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#ba1a1a;">
                    <span class="material-symbols-outlined" style="font-size:13px;">error</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider mb-1.5"
                   style="color:#514348;">Confirm password</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2"
                      style="font-size:18px; color:#d6c1c7; pointer-events:none;">lock_reset</span>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm transition focus:outline-none focus:ring-2 focus:border-transparent"
                       style="border-color:{{ $errors->get('password_confirmation') ? '#ba1a1a' : '#d6c1c7' }}; background:#fafeff; color:#0b1c30; --tw-ring-color:#864461;"
                       placeholder="Repeat your password">
            </div>
            @error('password_confirmation')
                <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#ba1a1a;">
                    <span class="material-symbols-outlined" style="font-size:13px;">error</span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold text-white shadow-md transition hover:opacity-90 active:scale-[0.98]"
                style="background:#864461; letter-spacing:0.01em;">
            Create account
            <span class="material-symbols-outlined" style="font-size:17px; font-variation-settings:'FILL' 1;">arrow_forward</span>
        </button>

    </form>

    {{-- Login link --}}
    <p class="mt-8 text-center text-sm" style="color:#847378;">
        Already have an account?
        <a href="{{ route('login') }}"
           class="font-semibold ml-1 transition hover:opacity-70"
           style="color:#864461;">Sign in instead</a>
    </p>

</x-guest-layout>
