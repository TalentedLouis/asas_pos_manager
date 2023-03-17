<header class="bg-gray-600 shadow">
    <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex justify-between h-12">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-8 w-auto fill-current text-gray-300" />
                    </a>
                </div>
            </div>
            <div class="flex-shrink-0 flex items-center justify-end">
                <div class="mr-3 text-gray-300">
                    {{ Auth::User()->shop->name }}
                </div>
                <form class="text-gray-300" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</header>
