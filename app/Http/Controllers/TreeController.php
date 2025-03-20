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
        $namaUser = auth()->user()->name; // Ambil nama user yang sedang login

        notify()->success('Welcome Back Admin', 'Hello 😎');
        
        // Tambahkan $namaUser ke dalam compact
        return view('admin.dashboard', compact('totalUsers', 'users', 'totalFamilyTrees', 'familyTrees', 'namaUser'));
    }
    public function data()
    {
        $trees = FamilyTree::all(); // Ambil semua data pohon
        $namaUser = auth()->user()->name;
        return view('admin.data', compact('trees', 'namaUser'));
    }

    public function store(Request $request)
    {
        $namaUser = auth()->user()->name;
        $request->validate([
            'tree_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tree = FamilyTree::create([
            'tree_name' => $request->tree_name,
            'description' => $request->description,
            'created_by' => $namaUser,
        ]);

        notify()->success('Data Berhasil Ditambahkan','Create Data ');
        return redirect()->route('data', ['id' => $tree->id]);
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
        notify()->success('Data Berhasil Dihapus', 'Delete Data');
        return redirect()->back()->with('success');
    }

    public function update(Request $request, $tree_id)
    {
        $tree = FamilyTree::findOrFail($tree_id);
        $tree->update([
            'tree_name' => $request->tree_name,
            'description' => $request->description,
        ]);
        notify()->success('Data Berhasil Diupdate','Update Data');
        return redirect()->route('data');
    }

    public function detail($tree_id)
    {
        // Ambil tree beserta familyMembers dan children
        $tree = FamilyTree::with('familyMembers.children')->findOrFail($tree_id);
        // Ambil root members (familyMembers tanpa parent_id)
        $rootMembers = $tree->familyMembers->whereNull('parent_id');
        return view('admin.detail', compact('tree', 'rootMembers'));
    }
}
