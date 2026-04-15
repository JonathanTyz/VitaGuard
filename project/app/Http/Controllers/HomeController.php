<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleTopic;
use App\Models\Allergen;
use App\Models\City;
use App\Models\District;
use App\Models\MedicalHistory;
use App\Models\Member;
use App\Models\MemberAllergy;
use App\Models\Province;
use App\Models\User;
use App\Models\Speciality;
use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\Facility;
use App\Models\FacilityHour;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::all();
        $article_topics = ArticleTopic::all();
        $allergens = Allergen::all();
        $cities = City::all();
        $districts = District::all();
        $medical_histories = MedicalHistory::all();
        $members = Member::all();
        $member_allergies = MemberAllergy::all();
        $provinces = Province::all();
        $users = User::all();
        $specialities = Speciality::all();
        $doctors = Doctor::all();
        $doctor_specialities = DoctorSpecialty::all();
        $facilities = Facility::all();
        $facility_hours = FacilityHour::all();

        $dataTables = [
            'articles' => $articles,
            'Ararticle_topics' => $article_topics,
            'allergens' => $allergens,
            'cities' => $cities,
            'districts' => $districts,
            'medical_histories' => $medical_histories,
            'members' => $members,
            'member_allergies' => $member_allergies,
            'provinces' => $provinces,
            'users' => $users,
            'specialities' => $specialities,
            'doctors' => $doctors,
            'doctor_specialities' => $doctor_specialities,
            'facilities' => $facilities,
            'facility_hours' => $facility_hours,
        ];

        return view('welcome', compact('dataTables'));
    }
}
