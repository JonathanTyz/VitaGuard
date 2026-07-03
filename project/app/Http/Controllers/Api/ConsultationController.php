<?php

namespace App\Http\Controllers\Api  ;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Consultation;
use App\Models\OnlineSession;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        $currentPatient = Auth::check() ? Auth::user()->username : null;

        $doctors = Doctor::with(['specialties', 'schedules' => function($query) use ($currentPatient) {
            if ($currentPatient) {
                $query->with(['appointments' => function($q) use ($currentPatient) {
                    $q->where('patient', $currentPatient)->where('status', '!=', 'cancelled');
                }]);
            }
        }])->get();

        foreach ($doctors as $doctor) {
            $hasBooked = false;
            $consultationId = null;

            if ($currentPatient) {
                $hasBooked = Appointment::where('patient', $currentPatient)
                    ->whereHas('schedule', function ($q) use ($doctor) {
                        $q->where('doctor', $doctor->username);
                    })
                    ->where('status', '!=', 'cancelled')
                    ->exists();

     
                if ($hasBooked) {
                    $consultation = Consultation::where('patient', $currentPatient)
                        ->whereHas('onlineSession', function ($q) use ($doctor) {
                            $q->where('doctor', $doctor->username);
                        })
                        ->whereNull('end_time')
                        ->first();
                    if ($consultation) {
                        $consultationId = $consultation->id;
                    }
                }
            }

            $doctor->has_booked = $hasBooked;
            $doctor->can_chat = $hasBooked;
            $doctor->consultation_id = $consultationId; 
        }

        $specialties = Specialty::all();
        $schedules = DoctorSchedule::all();

        return view('pages.consultations.index', compact('doctors', 'specialties', 'schedules'));
    }


    public function indexSpecialties()
    {
        $doctors = Doctor::with(['specialties', 'schedules'])->get();
        $specialties = Specialty::all();

        return view('pages.consultations.index', compact('doctors', 'specialties'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function member()
    {
        return view('pages.consultations.member');
    }

    public function doctor()
    {
        return view('pages.consultations.doctor');
    }

    public function start(Doctor $doctor)
    {
    $patient = auth()->user()->username;

    $existing = Consultation::where('patient', $patient)
        ->whereHas('onlineSession', function ($q) use ($doctor) {
            $q->where('doctor', $doctor->username);
        })
        ->whereNull('end_time')
        ->first();

    if ($existing) {
        return redirect()->route('chat', $existing->id);
    }

    try {
        $consultation = null;
        DB::transaction(function () use ($patient, $doctor, &$consultation) {
            $onlineSession = OnlineSession::create([
                'doctor'           => $doctor->username,
                'start_time'       => now(),
                'end_time'         => null,
                'consultation_fee' => 0,
                'description'      => 'Konsultasi chat langsung',
            ]);

            $consultation = Consultation::create([
                'online_session_id' => $onlineSession->id,
                'patient'           => $patient,
                'start_time'        => now(),
                'end_time'          => null,
                'notes'             => null,
                'paid_at'           => null,
            ]);
        });

        if ($consultation) {
            return redirect()->route('chat', $consultation->id);
        }

        return redirect()->back()->with('error', 'Gagal membuat konsultasi.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Doctor $doctor)
    {

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


    public function fetchConsultations()
    {
        $user = auth()->user();

        if ($user->role === 'doctor') {
            $sessionIds = OnlineSession::where('doctor', $user->username)->pluck('id');

            $consultations = Consultation::with('onlineSession')
                ->whereIn('online_session_id', $sessionIds)
                ->orderBy('start_time', 'desc')
                ->get();
        } else {
            $consultations = Consultation::with('onlineSession')
                ->where('patient', $user->username)
                ->orderBy('start_time', 'desc')
                ->get();
        }

        $data = $consultations->map(function ($c) {
            return [
                'id'         => $c->id,
                'patient'    => $c->patient,
                'doctor'     => $c->onlineSession->doctor ?? '-',
                'start_time' => $c->start_time ? $c->start_time->format('d M Y H:i') : '-',
                'end_time'   => $c->end_time ? $c->end_time->format('d M Y H:i') : null,
                'notes'      => $c->notes,
                'is_active'  => is_null($c->end_time),
                'chat_url'   => '/chat/' . $c->id,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

}
