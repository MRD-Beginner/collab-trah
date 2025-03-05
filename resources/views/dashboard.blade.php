<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:mx-5 md:mx-0">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <h1>
        Jumlah User: {{ $totalUsers }}
    </h1>

    <div>
        <h2>Daftar Nama User:</h2>
        @if($users->isEmpty())
            <p>Tidak ada user yang tersedia.</p>
        @else
            @foreach($users as $user)
                <h2>{{ $user }}</h2>
            @endforeach
        @endif
    </div>
    
    <div>
        <h1>
            Jumlah Family Tree: {{ $totalFamilyTrees }}
        </h1>

        <h2>Daftar Family Tree:</h2>
        @if($familyTrees->isEmpty())
            <p>Tidak ada family tree yang tersedia.</p>
        @else
            @foreach($familyTrees as $familyTree)
                <h2>{{ $familyTree->tree_name }}</h2>
            @endforeach
        @endif
    </div>
</x-app-layout>


