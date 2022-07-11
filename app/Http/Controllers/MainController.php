<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Slider;
use App\Models\Station;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {

        // GET GIRLS
        $slides = Slider::where('active', '=', 1)->get()->sortBy('sort');
        $eliteGirls = Profile::where('active', '=', 1)->where('section', '=', 1)->latest('created_at')->limit(8)->get();
        $newGirls = Profile::where('active', '=', 1)->latest('created_at')->limit(20)->get();
        $individualGirls = Profile::where('active', '=', 1)->where('section', '=', 2)->limit(8)->get()->sortByDesc('id');
        $topGirls = Profile::where('active', '=', 1)->limit(20)->get()->sortByDesc('id');
        $cheapGirls = Profile::where('active', '=', 1)->where('section', '=', 3)->with('prices')->limit(8)->get()->sortBy('prices.day_one_hour_in');;
        $masseusesGirls = Profile::where('section', '=', 5)->limit(4)->get()->sortByDesc('id');


        return view('main', [
            'slides' => $slides,
            'eliteGirls' => $eliteGirls,
            'newGirls' => $newGirls,
            'individualGirls' => $individualGirls,
            'topGirls' => $topGirls,
            'cheapGirls' => $cheapGirls,
            'masseusesGirls' => $masseusesGirls
        ]);
    }


//    public function regenerateURL()
//    {
//        $allProfiles = Profile::all();
//
//        for ($i = 0; count($allProfiles) > $i; $i++) {
//            //$allProfiles[$i]->slug = Str::slug($allProfiles[$i]->name . '-' . $allProfiles[$i]->id);
//            $allProfiles[$i]->created_at = date('Y-m-d H:i:s');
//            $allProfiles[$i]->updated_at = date('Y-m-d H:i:s');
//            $allProfiles[$i]->update();
//        }
//
//       // return view('pages.page', []);
//    }
//
//    public function regMetroURL()
//    {
//        $allStations = Station::all();
//
//        for ($i = 0; count($allStations) > $i; $i++) {
//            $allStations[$i]->slug = Str::slug($allStations[$i]->name);
//            $allStations[$i]->update();
//        }
//
//        //return view('pages.page', []);
//    }
}
