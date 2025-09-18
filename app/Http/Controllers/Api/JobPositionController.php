<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use App\Models\Job_position;

class JobPositionController extends Controller
{
    /**
     * Lista svih radnih pozicija sa paginacijom i pretragom, koja bi trebala raditi sa Select2 i TomSelect
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // select2 i tomselect šalju query parametre q (search term), page (broj stranice) i per_page (broj rezultata po stranici)
        $term = $request->get('q');
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);

        $query = JobPosition::query()
            ->when($term, function ($q, $term) { // ovaj when je kao if, ako postoji search term, dodaj where
                $q->where('name', 'like', "%{$term}%");
            })
            ->orderBy('name');
        // a paginate je laravel metoda za paginaciju
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'results' => $paginator->getCollection()->map(fn($jp) => [ //mapira podakte u format koji Select2/TomSelect očekuje 
                'id' => $jp->id,
                'text' => $jp->name,
            ]),
            'pagination' => [
                'more' => $paginator->hasMorePages(),
            ],
        ]);
    }


}
