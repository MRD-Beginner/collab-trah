<?php

namespace App\Http\Controllers;

use App\Models\FamilyTree;
use App\Models\User;
use Illuminate\Http\Request;

class TreeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalFamilyTrees = FamilyTree::count();
        $users = User::pluck('name');
        $familyTrees = FamilyTree::all(); 

        notify()->success('Hello Admin');
        return view('admin.dashboard', compact('totalUsers', 'users', 'totalFamilyTrees', 'familyTrees'));
    }
    public function data()
    {
        $trees = FamilyTree::all(); // Ambil semua data pohon
        return view('admin.data', compact('trees'));
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

    public function detail($tree_id)
    {
        // Ambil tree beserta familyMembers dan children
        $tree = FamilyTree::with('familyMembers.children')->findOrFail($tree_id);

        // Ambil root members (familyMembers tanpa parent_id)
        $rootMembers = $tree->familyMembers->whereNull('parent_id');

        return view('admin.detail', compact('tree', 'rootMembers'));
    }
    // public function detail($tree_id)
    // {
    //     // Cari tree berdasarkan ID dengan eager loading untuk familyMembers
    //     $tree = FamilyTree::with(['familyMembers' => function ($query) {
    //         $query->whereNull('parent_id')->with('children');
    //     }])->findOrFail($tree_id);

    //     // Ambil semua anggota keluarga yang tidak memiliki parent (root) dan terkait dengan tree_id
    //     $rootMembers = $tree->familyMembers->whereNull('parent_id');

    //     return view('detail', compact('tree', 'rootMembers'));
    // }

    
}
