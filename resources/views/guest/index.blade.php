<x-guest-layout>
    <x-guest-nav></x-guest-nav>
    
    <x-notify::notify />

    <div class="flex mt-10">
        <div class="container sm:mx-12 md:mx-28 shadow-md">
            <div class="overflow-x-auto mt-3 p-5 rounded-md" >
                <div class="alert alert-primary d-flex align-items-center gap-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                    </svg>
                    <span>
                        Harap Masukkan data Keluarga Anda
                    </span> 
                </div>
                <table class="bg-white shadow-md w-100">
                    <thead>
                    <tr class="bg-blue-gray-100 text-gray-700">
                        <th class="py-3 px-4 text-center text-white border" scope="col">No</th>
                        <th class="py-3 px-12 text-center text-white border border-orange-300" scope="col">Nama Trah</th>
                        <th class="py-3 px-8 text-center text-white border border-orange-300" scope="col">Deskripsi</th>
                        <th class="py-3 px-8 text-center text-white border border-orange-300" scope="col">Jumlah Anggota</th>
                        <th class="py-3 px-4 text-center text-white border border-orange-300" scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="text-blue-gray-900">
                    @foreach ($trees as $tree)
                    <tr class="border-separate border border-[#CFAD82]">
                        <td class="py-3 px-4 text-center border border-[#CFAD82]">{{ $loop -> iteration }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center w-60">{{$tree->tree_name}}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center w-80">{{ $tree->description ?? 'data kosong' }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $tree->familyMembers->count() ?? 'data kosong' }}</td>
                        <td class="py-3 px-8 border border-[#CFAD82] flex gap-3 justify-content-center">
                                <a href="{{ route('guest.show', $tree->id) }}" class="btn btn-primary text-white px-3 py-2 rounded-md hover:bg-blue-600 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right-square" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.854 8.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707z"/>
                                    </svg>
                                </a>
    
                                <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center gap-2"
                                        onclick="shareTree({{ $tree->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                        <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function shareTree(treeId) {
            const shareUrl = `${window.location.origin}/tree/${treeId}`;
            
            // Salin ke clipboard
            navigator.clipboard.writeText(shareUrl).then(() => {
                // Tampilkan SweetAlert setelah berhasil disalin
                Swal.fire({
                    icon: 'success',
                    title: 'Link copied!',
                    text: 'Tree link has been copied to clipboard',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).catch(err => {
                // Jika gagal, tampilkan pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to copy',
                    text: 'Could not copy link to clipboard',
                });
            });
        }
    </script>
</x-guest-layout>