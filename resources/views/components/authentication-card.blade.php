<style>
    /* Gaya default untuk desktop */
    img {
        width: 860px;
        height: 570px;
        object-fit: cover;
    }

    /* Gaya untuk perangkat mobile */
    @media only screen and (max-width: 600px) {
        img {
            width: 100%;
            height: 20%;
            object-fit: cover;
        }
    }
</style>

<div class="min-h-screen flex sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="flex flex-col md:flex-row md:items-center bg-white px-5 py-5 gap-10 shadow-md">
        <div>
            @if (Route::is('register'))
                <img src="https://images.unsplash.com/photo-1733039898491-b4f469c6cd1a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Register Image">
            @else
                <img src="https://images.unsplash.com/photo-1616388601193-a1b31d70905a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Default Image">
            @endif
        </div>
        
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>
