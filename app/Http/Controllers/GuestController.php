<?php

namespace App\Http\Controllers;

use App\Models\FamilyTree;
use App\Models\User;
use App\Http\Controllers\AlgorithmController;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index() {
        $trees = FamilyTree::all();
        return view('guest.index', compact('trees'));
    }

    public function detail() {
        return view('guest.detail');
    }
}
