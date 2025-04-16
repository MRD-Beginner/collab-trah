<x-guest-layout>
    <x-guest-nav></x-guest-nav>

    <x-notify::notify />

    <div class="flex mt-10">
        <div class="container sm:mx-12 md:mx-28 shadow-md">
            <div class="alert alert-primary d-flex align-items-center gap-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                </svg>
                <span>
                    Harap Masukkan data Keluarga Anda
                </span> 
            </div>
            <table class="shadow-md mt-3">
                            <thead class="">
                            <tr class="bg-blue-gray-100 text-gray-700">
                                <th class="py-3 px-4 text-center text-white border border-orange-300">No</th>
                                <th class="py-3 px-20 text-center text-white border border-orange-300">Nama Lengkap</th>
                                <th class="py-3 px-12 text-center text-white border border-orange-300">Tanggal Lahir</th>
                                <th class="py-3 px-12 text-center text-white border border-orange-300">Jenis Kelamin</th>
                                <th class="py-3 px-4 text-center text-white border border-orange-300 ">Alamat</th>
                                <th class="py-3 px-4 text-center text-white border border-orange-300">Orang tua</th>
                                <th class="py-3 px-4 text-center text-white border border-orange-300">Aksi</th>
                            </tr>
        
                            @foreach ($tree->familyMembers as $member)
                            <tr class="border-separate border bg-white justify-center align-middle">
                                <td class="py-3 px-4 text-center border border-[#CFAD82]">{{ $loop -> iteration }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center wrap-text">{{$member->name}}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $member->birth_date }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $member->gender }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center wrap-text">{{ $member->address ?: '-' }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center ">{{ $member->parent ? $member->parent->name : 'Belum Diketahui' }}</td>
                                <td class="py-4 px-4 border border-[#CFAD82] flex gap-3">
        
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal{{ $member->id }}">
                                        Detail
                                    </button>
        
                                    <div class="modal fade" id="DetailModal{{ $member->id }}" tabindex="-1" aria-labelledby="DetailModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="DetailModalLabel">Detail</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body flex items-center">
                                                    @if($member->photo)
                                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" class="img-fluid" style="width: 300px; height: 300px; object-fit: cover">
                                                    @else
                                                        <p><strong>Foto:</strong> Tidak ada foto</p>
                                                    @endif
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><strong>Nama:</strong> {{ $member->name }}</li>
                                                        <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ $member->birth_date }}</li>
                                                        <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $member->gender }}</li>
                                                        <li class="list-group-item"><strong>Alamat:</strong> {{ $member->address ?: 'Tidak Ada' }}</li>
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

                                    <div class="modal fade" id="EditModal{{ $member->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Anggota Keluarga</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Tab Navigation -->
                                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="pills-home-tab-2" data-bs-toggle="pill" data-bs-target="#pills-home-2" type="button" role="tab" aria-controls="pills-home-2" aria-selected="true">Data Pribadi</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="pills-profile-tab-2" data-bs-toggle="pill" data-bs-target="#pills-profile-2" type="button" role="tab" aria-controls="pills-profile-2" aria-selected="false">Data Pasangan</button>
                                                        </li>
                                                    </ul>
                                    
                                                    <!-- Form -->
                                                    <form action="{{ route('family_members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                    
                                                        <!-- Tab Content -->
                                                        <div class="tab-content" id="pills-tabContent-2">
                                                            <!-- Tab 1: Data Pribadi -->
                                                            <div class="tab-pane fade show active" id="pills-home-2" role="tabpanel" aria-labelledby="pills-home-tab-2" tabindex="0">
                                                                <!-- Konten Data Pribadi -->
                                                                <input type="hidden" class="form-control" id="tree_id" name="tree_id" value="{{ $tree->id }}" required>
                                    
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
                                                                    <div class="flex items-center mb-4">
                                                                        <input id="has-partner-checkbox" name="has-partner-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500" onchange="toggleTab2()">
                                                                        <label for="has-partner-checkbox" class="ms-2 text-sm font-normal">Memiliki Pasangan</label>
                                                                    </div>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $member->birth_date }}" required>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="urutan" class="form-label">Anak Ke</label>
                                                                    <select class="form-select" id="urutan" name="urutan" required>
                                                                        <option value="" disabled selected>Anak Ke</option>
                                                                        @for ($i = 1; $i <= 10; $i++)
                                                                            <option value="{{ $i }}" {{ $member->urutan == $i ? 'selected' : '' }}>Ke-{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
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
                                                                    <textarea class="form-control" id="address" name="address">{{ $member->address }}</textarea>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="photo" class="form-label">Unggah Foto</label>
                                                                    <div class="input-group">
                                                                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage3(event)">
                                                                    </div>
                                                                    
                                                                    <!-- Tampilkan foto yang sudah ada -->
                                                                    @if($member->photo)
                                                                        <div class="mt-2">
                                                                            <img id="existingPhoto" src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" class="img-thumbnail" style="max-width: 200px;">
                                                                        </div>
                                                                    @endif
                                                                
                                                                    <!-- Tampilkan pratinjau gambar baru -->
                                                                    <div class="mt-2">
                                                                        <img id="imagePreview3" src="" alt="Pratinjau Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                    
                                                            <!-- Tab 2: Data Pasangan -->
                                                            <div class="tab-pane fade" id="pills-profile-2" role="tabpanel" aria-labelledby="pills-profile-tab-2" tabindex="0">
                                                                <!-- Konten Data Pasangan -->
                                                                <input type="hidden" class="form-control" id="tree_id" name="tree_id" value="{{ $tree->id }}" required>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_name" class="form-label">Nama Pasangan</label>
                                                                    <input type="text" class="form-control" id="partner_name" name="partner_name" value="{{ $member->partner_name }}">
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_birth_date" class="form-label">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" id="partner_birth_date" name="partner_birth_date" value="{{ $member->partner_birth_date }}">
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_address" class="form-label">Alamat</label>
                                                                    <textarea class="form-control" id="partner_address" name="partner_address">{{ $member->partner_address }}</textarea>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_photo" class="form-label">Unggah Foto</label>
                                                                    <div class="input-group">
                                                                        <input type="file" class="form-control" id="partner_photo" name="partner_photo" accept="image/*" onchange="previewImage2(event)">
                                                                        <label class="input-group-text" for="partner_photo">Pilih File</label>
                                                                    </div>
                                                                    
                                                                    <div class="mt-2">
                                                                        <img id="imagePreview2" src="" alt="Pratinjau Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
                                                                    </div>
                                                                </div>
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
</x-guest-layout>