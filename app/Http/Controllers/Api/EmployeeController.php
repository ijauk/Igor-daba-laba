<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // Implementacija metode za dohvat zaposlenika
        $term = $request->get('q');
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);

        $query = Employee::query() // lista svih zaposlenika sa paginacijom i pretragom
            ->when($term, function ($q, $term) {
                // 'when' će dodati ovaj blok samo ako $term postoji
                $q->where(function ($sub) use ($term) {
                    // $sub je samo alias za unutarnji query builder objekt
                    // omogućuje grupiranje uvjeta u zagrade: ( ... OR ... )
                    $sub->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"])
                        ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->orderBy('last_name')
            ->orderBy('first_name');
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'results' => $paginator->getCollection()->map(fn($emp) => [ //mapira podakte u format koji Select2/TomSelect očekuje 
                'id' => $emp->id,
                'text' => $emp->first_name . ' ' . $emp->last_name . ' (' . $emp->email . ')',
            ]),
            'pagination' => [
                'more' => $paginator->hasMorePages(),
            ],
        ]);
    }
}
