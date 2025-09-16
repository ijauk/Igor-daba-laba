<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $term = $request->get('q');
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);

        $query = Job_position::query()
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

    // GET /api/job-positions?q=man&page=1
    public function index2(Request $request)
    {
        $term = $request->get('q');
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 10);

        $query = Job_position::query()
            ->when($term, fn($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->orderBy('name');

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'results' => $paginator->getCollection()->map(fn($jp) => [
                'id' => $jp->id,
                'text' => $jp->name,
            ]),
            'pagination' => ['more' => $paginator->hasMorePages()],
        ]);
    }
}
