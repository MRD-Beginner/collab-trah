<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\FamilyTree;

class AlgorithmController extends Controller
{
    public function compare(Request $request)
    {
        $tree_id = $request->input('tree_id');

        $person1 = FamilyMember::where('name', $request->name1)
                    ->where('tree_id', $tree_id)->first();

        $person2 = FamilyMember::where('name', $request->name2)
                    ->where('tree_id', $tree_id)->first();

        if (!$person1 || !$person2) {
            return back()->with('error', 'Anggota keluarga tidak ditemukan.');
        }

        $path = [];
        $found = $this->dfs($person1, $person2->id, [], $path);

        $relationshipDetails = $found
            ? $this->formatRelationship($path, $person1->name, $person2->name)
            : 'Tidak ada hubungan yang ditemukan.';

        $tree = FamilyTree::find($tree_id);
        $members = FamilyMember::where('tree_id', $tree_id)->get();
        $rootMembers = $members->whereNull('parent_id');

        return view('compare', compact('tree_id', 'tree', 'members', 'rootMembers','person1', 'person2', 'relationshipDetails'));
    }

    public function dfs($current, $targetId, $visited, &$path)
    {
        if (in_array($current->id, $visited)) return false;

        $visited[] = $current->id;
        $path[] = $current;

        if ($current->id == $targetId) return true;

        // Cek ke atas
        if ($current->parent) {
            if ($this->dfs($current->parent, $targetId, $visited, $path)) return true;
        }

        // Cek ke bawah
        foreach ($current->children as $child) {
            if ($this->dfs($child, $targetId, $visited, $path)) return true;
        }

        // Cek ke samping 
        if ($current->parent) {
            foreach ($current->parent->children as $sibling) {
                if ($sibling->id != $current->id) {
                    if ($this->dfs($sibling, $targetId, $visited, $path)) return true;
                }
            }
        }

        array_pop($path);
        return false;
    }
    
    public function formatRelationship($path, $firstPersonName, $secondPersonName)
{
    $path = array_reverse($path);
    $firstPerson = $path[0]->name;
    $lastPerson = end($path)->name;

    if ($firstPerson !== $firstPersonName) {
        $path = array_reverse($path);
        $firstPerson = $firstPersonName;
        $lastPerson = $secondPersonName;
    }

    $relationshipDescription = $this->determineJavaneseRelation($path);
    $detailedPath = [];

    for ($i = 0; $i < count($path) - 1; $i++) {
        $current = $path[$i];
        $next = $path[$i + 1];
        
        // 1. Check sibling relationship first
        if ($current->parent_id && $current->parent_id == $next->parent_id) {
            if ($current->gender == $next->gender) {
                $relation = ($current->gender == 'Laki-Laki') 
                    ? "sedherek kakung (saudara laki-laki)" 
                    : "sedherek putri (saudara perempuan)";
            } else {
                $relation = "sedherek (saudara)";
            }
            $detailedPath[] = "- {$current->name} {$relation} dengan {$next->name}";
        }
        // 2. Check parent-child relationship
        elseif ($next->parent_id == $current->id) {
            $relation = ($next->gender == 'Laki-Laki') ? "putra (anak laki-laki)" : "putri (anak perempuan)";
            $detailedPath[] = "- {$next->name} {$relation} dari {$current->name}";
        }
        // 3. Check child-parent relationship (reverse)
        elseif ($current->parent_id == $next->id) {
            $relation = ($current->gender == 'Laki-Laki') ? "putra (anak laki-laki)" : "putri (anak perempuan)";
            $detailedPath[] = "- {$current->name} {$relation} dari {$next->name}";
        }
        // 4. Check uncle/aunt relationships (siblings of parents)
        elseif ($next->parent && $current->parent_id == $next->parent->id) {
            if ($next->gender == 'Laki-Laki') {
                $detailedPath[] = "- {$current->name} ponakan dari {$next->name} (paman)";
            } else {
                $detailedPath[] = "- {$current->name} ponakan dari {$next->name} (bibi)";
            }
        }
        // 5. Check nephew/niece relationships (reverse of uncle/aunt)
        elseif ($current->parent && $next->parent_id == $current->parent->id) {
            if ($current->gender == 'Laki-Laki') {
                $detailedPath[] = "- {$next->name} ponakan dari {$current->name} (paman)";
            } else {
                $detailedPath[] = "- {$next->name} ponakan dari {$current->name} (bibi)";
            }
        }
        // 6. Handle cousin relationships
        elseif ($current->parent && $next->parent && 
               $current->parent->parent_id && 
               $current->parent->parent_id == $next->parent->parent_id) {
            $detailedPath[] = "- {$current->name} sedulur misanan (sepupu) dengan {$next->name}";
        }
        // 7. Handle grandparent relationships
        elseif ($current->parent && $current->parent->parent_id == $next->id) {
            $relation = ($next->gender == 'Laki-Laki') 
                ? "eyang kakung (kakek)" 
                : "eyang putri (nenek)";
            $detailedPath[] = "- {$current->name} putu (cucu) dari {$next->name} {$relation}";
        }
        // 8. Handle grandchild relationships (reverse)
        elseif ($next->parent && $next->parent->parent_id == $current->id) {
            $relation = ($current->gender == 'Laki-Laki') 
                ? "eyang kakung (kakek)" 
                : "eyang putri (nenek)";
            $detailedPath[] = "- {$next->name} putu (cucu) dari {$current->name} {$relation}";
        }
    }

    return [
        'relation' => "{$firstPerson} {$relationshipDescription} {$lastPerson}",
        'detailedPath' => $detailedPath
    ];
}

public function determineJavaneseRelation($path)
{
    $depth = $this->calculateActualDepth($path);
    $lastPerson = end($path);
    $gender = $lastPerson->gender;

    $relations = [
        0 => [
            'Laki-Laki' => 'sedherek putri (saudara perempuan) dari', 
            'Perempuan' => 'sedherek kakung (saudara laki-laki) dari'
        ],
        1 => [
            'Laki-Laki' => 'anak dari', 
            'Perempuan' => 'anak dari'
        ],
        -1 => [
            'Laki-Laki' => 'bapak dari', 
            'Perempuan' => 'ibu dari'
        ],
        2 => [
            'Laki-Laki' => 'putu kakung (cucu perempuan) dari', 
            'Perempuan' => 'putu putri (cucu laki-laki) dari'
        ],
        -2 => [
            'Laki-Laki' => 'eyang kakung (kakek) dari', 
            'Perempuan' => 'eyang putri (nenek) dari'
            
        ],
        3 => [
            'Laki-Laki' => 'mbah buyut kakung dari', 
            'Perempuan' => 'mbah buyut putri dari'
        ],
        -3 => [
            'Laki-Laki' => 'buyut kakung dari', 
            'Perempuan' => 'buyut putri dari'
        ],
        'cousin' => [
            'Laki-Laki' => 'sedulur misanan (sepupu) dengan', 
            'Perempuan' => 'sedulur misanan (sepupu) dengan'
        ]
    ];
    

    // Special case for cousins (same generation but not siblings)
    if ($depth == 0 && count($path) > 2) {
        $first = $path[0];
        $last = end($path);
        if ($first->parent_id && $last->parent_id && 
            $first->parent_id != $last->parent_id &&
            $first->parent->parent_id == $last->parent->parent_id) {
            return $relations['cousin'][$gender];
        }
    }

    return $relations[$depth][$gender] ?? "hubungan generasi ke-{$depth} dengan";
}

protected function calculateActualDepth($path)
{
    if (count($path) < 2) return 0;

    $depth = 0;
    $current = $path[0];

    for ($i = 1; $i < count($path); $i++) {
        $next = $path[$i];
        
        if ($next->parent_id == $current->id) {
            // Moving down generations (child)
            $depth--;
        } elseif ($current->parent_id == $next->id) {
            // Moving up generations (parent)
            $depth++;
        }
        // Siblings and cousins don't change depth
        $current = $next;
    }

    return $depth;
}
}
