<x-app-layout>
    <x-slot name="header" style="background-color: #">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:mx-5 md:mx-0">
            {{ __('Detail') }}
        </h2>
    </x-slot>

    <div class="flex mt-10">
        <div class="container sm:mx-12 md:mx-28">
            <button data-bs-toggle="modal" data-bs-target="#AddModal" class="bg-[#D54425] text-white px-4 py-2 rounded-md hover:bg-[#971c00] ms15">Tambah</button>

            <div class="modal fade" id="AddModal" tabindex="-1" aria-labelledby="AddModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk Simpan ke Laravel -->
                            <form action="{{ route('family.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf <!-- Token keamanan Laravel -->
                                <input type="hidden" class="form-control" id="tree_id" name="tree_id" value="{{ $tree->id }}" required>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Pilih Orang Tua</label>
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="" selected>Tidak Ada</option>
                                        @foreach ($tree->familyMembers as $member)
                                            <option value="{{ $member->id }}" {{ isset($familyMember) && $familyMember->parent_id == $member->id ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3"> 
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="photo" class="form-label">Unggah Foto</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                                        <label class="input-group-text" for="photo">Pilih File</label>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <img id="imagePreview" src="" alt="Pratinjau Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
                                    </div>
                                </div>
            
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="overflow-x-auto mt-3 bg-[#FEEEBD] p-5 rounded-md">
                <table class="bg-white shadow-md">
                    <thead class="bg-[#D54425] ">
                    <tr class="bg-blue-gray-100 text-gray-700">
                        <th class="py-3 px-4 text-center text-white border border-orange-300">No</th>
                        <th class="py-3 px-20 text-center text-white border border-orange-300">Nama Lengkap</th>
                        <th class="py-3 px-12 text-center text-white border border-orange-300">Tanggal Lahir</th>
                        <th class="py-3 px-12 text-center text-white border border-orange-300">Jenis Kelamin</th>
                        <th class="py-3 px-4 text-center text-white border border-orange-300">Alamat</th>
                        <th class="py-3 px-4 text-center text-white border border-orange-300">Orang tua</th>
                        <th class="py-3 px-4 text-center text-white border border-orange-300">Aksi</th>
                    </tr>

                    @foreach ($tree->familyMembers as $member)
                    <tr class="border-separate border border-[#CFAD82] bg-[#FFE28B] justify-center align-middle">
                        <td class="py-3 px-4 text-center border border-[#CFAD82]">{{ $loop -> iteration }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center">{{$member->name}}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $member->birth_date }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $member->gender }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $member->address }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center ">{{ $member->parent ? $member->parent->name : 'Tidak Ada' }}</td>
                        <td class="py-3 px-8 border border-[#CFAD82] flex gap-3">

                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal{{ $member->id }}">
                                Detail
                            </button>

                            <div class="modal fade" id="DetailModal{{ $member->id }}" tabindex="-1" aria-labelledby="DetailModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="DetailModalLabel">Detail Anggota Keluarga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($member->photo)
                                                <p><strong>Foto:</strong></p>
                                                {{-- <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" class="img-fluid" style="max-width: 100%; height: auto;"> --}}
                                                <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" class="img-fluid" style="max-width: 100%; height: auto;">
                                            @else
                                                <p><strong>Foto:</strong> Tidak ada foto</p>
                                            @endif
                                            <ul class="list-group">
                                                <li class="list-group-item"><strong>Nama:</strong> {{ $member->name }}</li>
                                                <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ $member->birth_date }}</li>
                                                <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $member->gender }}</li>
                                                <li class="list-group-item"><strong>Alamat:</strong> {{ $member->address }}</li>
                                                <li class="list-group-item"><strong>Orang Tua:</strong> {{ $member->parent ? $member->parent->name : 'Tidak Ada' }}</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditModal{{ $member->id }}">
                                 Edit
                            </button>
                     
                             <!-- Modal Edit -->
                             <div class="modal fade" id="EditModal{{ $member->id }}"  tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title">Edit Data</h5>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                         </div>
                                         <div class="modal-body">
                                             <!-- Form untuk Update ke Laravel -->
                                             <form action="{{ route('family_members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                                                 @csrf
                                                 @method('PUT')
                     
                                                 <div class="mb-3">
                                                     <label for="name" class="form-label">Nama</label>
                                                     <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
                                                 </div>
                     
                                                 <div class="mb-3">
                                                     <label for="parent_id" class="form-label">Pilih Orang Tua</label>
                                                     <select class="form-control" id="parent_id" name="parent_id">
                                                         <option value="" selected>Tidak Ada</option>
                                                         @foreach ($tree->familyMembers as $parent)
                                                             <option value="{{ $parent->id }}" {{ $member->parent_id == $parent->id ? 'selected' : '' }}>
                                                                 {{ $parent->name }}
                                                             </option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                     
                                                 <div class="mb-3"> 
                                                     <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                                     <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $member->birth_date }}" required>
                                                 </div>
                     
                                                 <div class="mb-3">
                                                     <label for="gender" class="form-label">Jenis Kelamin</label>
                                                     <select class="form-select" id="gender" name="gender" required>
                                                         <option value="Laki-Laki" {{ $member->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                         <option value="Perempuan" {{ $member->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                     </select>
                                                 </div>
                     
                                                 <div class="mb-3">
                                                     <label for="address" class="form-label">Alamat</label>
                                                     <textarea class="form-control" id="address" name="address" required>{{ $member->address }}</textarea>
                                                 </div>

                                                 <!-- Input untuk Upload Gambar -->
                                                 <div class="form-group mb-3">
                                                    <label for="photo">Foto</label>
                                                    <input type="file" name="photo" id="photo" class="form-control">
                                                    @if($member->photo)
                                                    <p><strong>Foto:</strong></p>
                                                    <img src="{{ $member->photo ? asset('storage/' . $member->photo) : asset('storage/photos/family_photos/'. $member->photo) }}" alt="Foto Anggota" class="img-fluid" style="max-width: 100%; height: auto;">
                                                    
                                                    @else
                                                        <p><strong>Foto:</strong> Tidak ada foto</p>
                                                    @endif
                                                </div>
                                            
                     
                                                 <div class="modal-footer">
                                                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                     <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#DeleteModal{{ $member->id }}">
                                Hapus
                            </button>
                    
                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="DeleteModal{{ $member->id }}" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="DeleteModalLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <strong>{{ $member->name }}</strong> dari keluarga?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <!-- Form untuk menghapus data -->
                                            <form action="{{ route('family_members.destroy', $member->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    @endforeach
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById("imagePreview");
        
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
        
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        }
        </script>
</x-app-layout>