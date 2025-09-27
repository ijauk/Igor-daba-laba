<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $term = $request->get('q');
            $page = (int) $request->get('page', 1);
            $perPage = (int) $request->get('per_page', 10);
            $query = Education::query();

            if ($term) {
                $query->where('name', 'like', "%{$term}%");
            }

            $paginator  = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'results' => $paginator->getCollection()->map(fn($edu) => [
                'id' => $edu->id,
                'text' => $edu->label,
            ]),
            'pagination' => [
                'more' => $paginator->hasMorePages(),
            ],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'An error occurred while fetching education data.',
            'message' => $e->getMessage(),
        ], 500);
        }

        
    }
}
