<?php

namespace App\Http\Controllers;

use App\Models\FamilyTree;
use Illuminate\Http\Request;

class TreeController extends Controller
{
    public function index()
    {
        $trees = FamilyTree::all(); // Ambil semua data pohon
        return view('dashboard', compact('trees'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'tree_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Simpan ke database
        FamilyTree::create([
            'tree_name' => $request->tree_name,
            'description' => $request->description,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function edit($tree_id)
    {
        $tree = FamilyTree::findOrFail($tree_id);
        return view('edit-tree', compact('tree'));
    }

    public function delete($tree_id)
    {
        $tree = FamilyTree::findOrFail($tree_id);
        $tree->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function update(Request $request, $tree_id)
    {
        $tree = FamilyTree::findOrFail($tree_id);
        $tree->update([
            'tree_name' => $request->tree_name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function detail($tree_id){
        // $tree = FamilyTree::findOrFail($tree_id);
        // return view('detail', compact('tree'));

        $tree = FamilyTree::with('familyMembers')->findOrFail($tree_id);
        return view('detail', compact('tree'));
    }
}
