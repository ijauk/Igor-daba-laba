<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HiringPlan;
use Illuminate\Support\Facades\Auth;
class HiringPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hiringPlans = HiringPlan::all();
        return view('hiring_plans.index', compact('hiringPlans'));
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            
            return view('hiring_plans.create');
        } else {
            return redirect()->route('login')->with('error', 'Morate se prijaviti za pristup stranici.');
        }
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Morate se prijaviti za pristup stranici.');
        }
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'description' => 'nullable|string',
            'active' => 'sometimes|boolean',
        ]
    ,        [
            'title.required' => 'Polje Naziv je obavezno.',
            'title.string' => 'Polje Naziv mora biti tekst.',
            'title.max' => 'Polje Naziv ne smije biti duže od 255 znakova.',
            'valid_from.required' => 'Polje Vrijedi od je obavezno.',
            'valid_from.date' => 'Polje Vrijedi od mora biti ispravan datum.',
            'valid_to.required' => 'Polje Vrijedi do je obavezno.',
            'valid_to.date' => 'Polje Vrijedi do mora biti ispravan datum.',
            'valid_to.after_or_equal' => 'Polje Vrijedi do mora biti jednako ili nakon polja Vrijedi od.',
            'description.string' => 'Polje Opis mora biti tekst.',
            'active.boolean' => 'Polje Aktivno mora biti true ili false.',
        ]
    );

    try {
        HiringPlan::create($validated);
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Došlo je do pogreške pri spremanju podataka: ' . $e->getMessage()])->withInput();
    }

        return redirect()->route('hiring-plans.index')->with('success', 'Plan zapošljavanja je uspješno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
