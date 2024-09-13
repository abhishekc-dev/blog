@include('layouts.header')

<div class="flex-1 flex flex-col">
    <header class="bg-white shadow-md border-b border-gray-200 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="space-x-4">
                <span class="text-gray-700">Welcome, <b>{{ Auth::user()->name}}({{ Auth::user()->email}})</b> to
                    blog website</span>
            </div>
        </div>
    </header>
    <main class="flex-1 container mx-auto p-4">
        @yield('content')
    </main>
</div>
@include('layouts.footer')