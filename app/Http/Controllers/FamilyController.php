<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\FamilyTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FamilyController extends Controller
{
    // public function store(Request $request){
    //     $request->validate([
    //         'tree_id' => 'required',
    //         'name' => 'required|string|max:50',
    //         'birth_date' => 'required|date',
    //         'gender' => 'required|string|in:Laki-Laki,Perempuan',
    //         'address' => 'string|max:60',
    //         'parent_id' => 'nullable|exists:family_members,id',
    //         'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    //     ]);

    //     $familyMember = FamilyMember::create([
    //         'tree_id' => $request->tree_id,
    //         'name' => $request->name,
    //         'birth_date' => $request->birth_date,
    //         'gender' => $request->gender,
    //         'address' => $request->address,
    //         'parent_id' => $request->parent_id,
    //     ]);

    //     // Jika ada gambar yang diunggah
    //     if ($request->hasFile('photo')) {
    //         // Menyimpan gambar dengan nama file unik
    //         $fileName = time() . '.' . $request->photo->extension();
    //         $request->photo->storeAs('public/photos', $fileName);
            
    //         // Menyimpan nama file gambar ke dalam kolom 'photo'
    //         $familyMember->update([
    //             'photo' => $fileName
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Data berhasil disimpan!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'tree_id' => 'required',
            'name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'address' => 'nullable|string|max:60',
            'parent_id' => 'nullable|exists:family_members,id',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Simpan gambar jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos/family_photos', 'public');
        }

        FamilyMember::create([
            'tree_id' => $request->tree_id,
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'parent_id' => $request->parent_id,
            'photo' => $photoPath, // Simpan path foto ke database
        ]);
        notify()->success('Data Berhasil Ditambahkan','Data Added ');
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id) {
        $member = FamilyMember::findOrFail($id);
        return view('family_members.edit', compact('member'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:50',
        'birth_date' => 'required|date',
        'gender' => 'required|string|in:Laki-Laki,Perempuan',
        'address' => 'nullable|string|max:100',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $member = FamilyMember::findOrFail($id);

    // Cek jika ada gambar baru yang di-upload
    if ($request->hasFile('photo')) {
        // Hapus gambar lama jika ada
        if ($member->photo) {
            // Hapus foto lama dari storage
            Storage::delete('public/photos/family_photos/' . $member->photo);
        }

        // Simpan gambar baru dan dapatkan path lengkap relatif
        $photoPath = $request->file('photo')->store('photos/family_photos', 'public');
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $photoPath = $member->photo;
    }

    // Update data member termasuk foto dengan path lengkap
    $member->update([
        'name' => $request->name,
        'birth_date' => $request->birth_date,
        'gender' => $request->gender,
        'address' => $request->address,
        'parent_id' => $request->parent_id,
        'photo' => $photoPath, // Menyimpan path lengkap (misalnya: photos/family_photos/nama_file.jpg)
    ]);
    notify()->success('Data Berhasil Diupdate','Update Data');
    return redirect()->back()->with('success', 'Data berhasil diperbarui!');
}

    public function destroy($id) {
        $member = FamilyMember::findOrFail($id);
        $member->delete();
    
        notify()->success('Data Berhasil Dihapus', 'Delete Data');
        return redirect()->back()->with('success', 'Anggota keluarga berhasil dihapus!');
    }

    public function showFamilyTree($tree_id)
    {
        // Cari tree berdasarkan ID
        $tree = FamilyTree::find($tree_id);

        // Jika tree tidak ditemukan, tampilkan error 404
        if (!$tree) {
            abort(404, 'Tree not found');
        }

        // Ambil semua anggota keluarga yang tidak memiliki parent (root) dan terkait dengan tree_id
        $rootMembers = FamilyMember::where('tree_id', $tree_id)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        // Kirim data ke view
        return view('family-tree', compact('rootMembers', 'tree'));
    }
}
