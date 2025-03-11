<x-app-layout>

    <style>
        .border-start-primary {
            border-left: 4px solid #00b067 !important; /* Warna Primary Bootstrap */
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;
        }
        .border-start-secondary {
            border-left: 4px solid #FFD700 !important; /* Warna Primary Bootstrap */
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;
        }
        .border-start-tertiary {
            border-left: 4px solid #0077C8 !important; /* Warna Primary Bootstrap */
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;
        }
        
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:mx-5 md:mx-0">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>
    
    <x-notify::notify />

    <div class="container-fluid p-0 h-5">
        <img src="{{ asset('img/wayang-bg.png') }}" alt="Wayang Background" class="img-fluid" style="width: 100%; height: 5.5rem; object-fit: cover; filter: brightness(80%);">
    </div>
    

    <div class="container-fluid my-3">
        <div class="row d-flex justify-center gap-x-16">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-success text-capitalize mb-1">
                                    <h2 class="fw-semibold fs-5">
                                        Total User
                                    </h2>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }} User</div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#dddfeb" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                  </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-warning text-capitalize mb-1">
                                    <h2 class="fw-semibold fs-6">
                                        Jumlah Silsilah Keluarga
                                    </h2>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFamilyTrees }} Family Tree</div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#dddfeb" class="bi bi-diagram-3-fill" viewBox="0 0 16 12">
                                    <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zm-6 8A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm6 0A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm6 0a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5z"/>
                                  </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-tertiary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-primary text-capitalize mb-1">
                                    <h2 class="fw-semibold fs-6">
                                        Jumlah Silsilah Keluarga
                                    </h2>
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid md:my-3 d-flex justify-content-center">
        <input type="text" class="form-input rounded-lg border-green-700 col-sm-12 col-md-10 ">
    </div>
    
    
    {{-- <h1>
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
    </div> --}}
</x-app-layout>


