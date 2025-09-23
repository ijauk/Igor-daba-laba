<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\JobPosition;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Education;
use Carbon\Carbon;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (!Auth::check()) {
        //         return redirect()->guest(route('login'));
        // }

        $job_postings = JobPosting::all();

        return view('jobpostings.index', compact('job_postings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $educations = Education::all();

        // Inicijalno odabrana radna pozicija (ako je vraćeno iz validacije)

        $selectedJobPosition = null;
        if (old('job_position_id')) {

            $selectedJobPosition = JobPosition::find(old('job_position_id'));
        }

        $selectedEmployee = null;
        if (old('employee_id')) {
            $selectedEmployee = Employee::find(old('employee_id'));
        }

        $selectedDate = null;
        if (old('posted_at')) {
            $selectedDate = old('posted_at');
        }

        $selectedExpiresAt = null;
        if (old('expires_at')) {
            $selectedExpiresAt = old('expires_at');
        }

        $selectedDeadLine = null;
        if (old('deadLine')) {
            $selectedDeadLine = old('deadLine');
        }

        return view('jobpostings.create', compact('educations', 'selectedJobPosition', 'selectedEmployee', 'selectedDate', 'selectedExpiresAt', 'selectedDeadLine'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validatedData = $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],

                // Tempus Dominus formats coming from the inputs:
                'posted_at' => ['required', 'date_format:d.m.Y H:i'],
                'expires_at' => ['required', 'date_format:d.m.Y', 'after_or_equal:posted_at'],
                'deadLine' => ['required', 'date_format:d.m.Y H:i', 'after_or_equal:posted_at'],

                'education_id' => ['required', 'integer', 'exists:educations,id'],
                'job_position_id' => ['required', 'integer', 'exists:job_positions,id'],
                'is_valid' => ['nullable', 'boolean'],
            ],
            [
                'title.required' => 'Molimo unesite naslov.',
                'title.string' => 'Naslov mora biti tekst.',
                'title.max' => 'Naslov može imati maksimalno 255 znakova.',

                'description.required' => 'Molimo unesite opis.',
                'description.string' => 'Opis mora biti tekst.',

                'posted_at.required' => 'Molimo unesite datum objave.',
                'posted_at.date_format' => 'Datum objave mora biti u formatu dd.mm.yyyy HH:mm.',

                'expires_at.required' => 'Molimo unesite datum isteka.',
                'expires_at.date_format' => 'Datum isteka mora biti u formatu dd.mm.yyyy.',
                'expires_at.after_or_equal' => 'Datum isteka mora biti isti ili nakon datuma objave.',

                'deadLine.required' => 'Molimo unesite rok za prijavu.',
                'deadLine.date_format' => 'Rok za prijavu mora biti u formatu dd.mm.yyyy HH:mm.',
                'deadLine.after_or_equal' => 'Rok za prijavu mora biti isti ili nakon datuma objave.',

                'education_id.required' => 'Molimo odaberite obrazovnu spremu.',
                'education_id.exists' => 'Odabrana obrazovna sprema ne postoji.',

                'job_position_id.required' => 'Molimo odaberite poziciju.',
                'job_position_id.exists' => 'Odabrana pozicija ne postoji.',

                'is_valid.boolean' => 'Polje važeći mora biti boolean vrijednost.',
            ]
        );

        // Pretvori u standardne formate prihvatljive za DB
        $postedAt = Carbon::createFromFormat('d.m.Y H:i', $validatedData['posted_at']);
        $expiresAt = Carbon::createFromFormat('d.m.Y', $validatedData['expires_at']);
        $deadLine = Carbon::createFromFormat('d.m.Y H:i', $validatedData['deadLine']);

        $validatedData['posted_at'] = $postedAt->format('Y-m-d H:i:s');
        $validatedData['expires_at'] = $expiresAt->format('Y-m-d');
        $validatedData['deadLine'] = $deadLine->format('Y-m-d H:i:s');

        JobPosting::create([
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
    public function show(JobPosting $job_posting)
    {
        dd($job_posting);
        return view('jobpostings.show', compact('job_posting'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPosting $jobposting)
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $educations = Education::all();


        $selectedJobPosition = $jobposting->job_position_id
            ? JobPosition::find($jobposting->job_position_id)
            : null;

        $selectedEmployee = $jobposting->employee_id
            ? Employee::find($jobposting->employee_id)
            : null;

        $selectedDate = $jobposting->posted_at?->format('d.m.Y H:i');
        $selectedExpiresAt = $jobposting->expires_at?->format('d.m.Y');
        $selectedDeadLine = $jobposting->deadline?->format('d.m.Y H:i');



        return view('jobpostings.edit', compact('jobposting', 'educations', 'selectedDate', 'selectedExpiresAt', 'selectedDeadLine', 'selectedJobPosition', 'selectedEmployee'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPosting $jobposting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPosting $job_posting)
    {
        //
    }
}
