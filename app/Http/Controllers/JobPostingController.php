<?php

namespace App\Http\Controllers;

use App\Models\Job_posting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $job_postings = Job_posting::all();
        return view('jobpostings.index', compact('job_postings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('jobpostings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'posted_at' => 'required|date',
                'expires_at' => 'required|date|after:posted_at',
                'deadLine' => 'nullable|date|after:posted_at'

            ],
            [
                'title.required' => 'Molimo unesite naslov',
                'title.string' => 'Naslov mora biti tekst',
                'title.max' => 'Naslov može imati maksimalno 255 znakova',
                'description.required' => 'Molimo unesite opis',
                'description.string' => 'Opis mora biti tekst',
                'posted_at.required' => 'Molimo unesite datum objave',
                'posted_at.date' => 'Datum objave nije u ispravnom formatu',
                'expires_at.required' => 'Molimo unesite datum isteka',
                'expires_at.date' => 'Datum isteka nije u ispravnom formatu',
                'expires_at.after' => 'Datum isteka mora biti nakon datuma objave',
                'deadLine.date' => 'Rok za prijavu nije u ispravnom formatu',
                'deadLine.after' => 'Rok za prijavu mora biti nakon datuma objave',
            ]
        );

        Job_posting::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'posted_at' => $validatedData['posted_at'],
            'expires_at' => $validatedData['expires_at'],
            'deadline' => $validatedData['deadLine'],
            'is_valid' => $validatedData['is_valid'] ?? false,
            'employee_id' => 3
        ]);

        return redirect('/jobpostings');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job_posting $job_posting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job_posting $job_posting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job_posting $job_posting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job_posting $job_posting)
    {
        //
    }
}
