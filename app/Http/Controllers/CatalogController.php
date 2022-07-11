<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Profile;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{

    private $profile_id = '';

    function showProfileCatalog($section, $slug)
    {
        $profile = Profile::where('active', 1)->where('slug', $slug)->first();
        $testimonials = Testimonial::where('active', 1)->where('profile_id', $profile->id)->get();

        if ($profile['section'] != array_search($section, Helpers::getGirlSectionUrl())) {
            abort(404);
        }

        $related = Profile::where('active', 1)->where('id', '!=', $profile['id'])->where('section', $profile['section'])->limit(10)->get();

        $this->profile_id = $profile['id'];

        $services = DB::table('services')
            ->join('services_field', 'services.id', '=', 'services_field.service_id')
            ->leftJoin('fields', function ($join) {
                $join->on('services_field.id', '=', 'fields.field_id')
                    ->where('fields.profile_id', '=', $this->profile_id);
            })
            ->select('services.name as block_title', 'services_field.name', 'services_field.id as service_id', 'fields.id', 'fields.description')
            ->orderBy('services.id')
            ->orderBy('services_field.sort')
            ->get();

        $arrServices = [];
        $tmp = '';
        if (count($services) > 0) {
            $tmp = $services[0]->block_title;
        }
        $servicesList = [];
        foreach ($services as $item) {

            if ($tmp != $item->block_title) {
                array_push($arrServices, ['title' => $tmp, 'services' => $servicesList]);
                $tmp = $item->block_title;
                $servicesList = array();
            }

            array_push($servicesList, [
                'name' => $item->name,
                'description' => $item->description,
                'check' => $item->id ? true : false
            ]);
        }
        array_push($arrServices, ['title' => $item->block_title, 'services' => $servicesList]);

        return view('catalog.profile', [
            'testimonials' => $testimonials,
            'heading' => $profile->name,
            'section_id' => $profile->section,
            'profile' => $profile->load(['attachment', 'prices', 'stations']),
            'related' => $related->load('attachment'),
            'services' => $arrServices
        ]);
    }


    function filter(Request $request)
    {
        // SERVICES
        if (isset($request->filter['services'])) {
            $arr = $request->filter['services'];
            if (count($arr) > 1) {
                unset($arr[0]);
            }

            $service = join(',', $arr);
        } else {
            $service = join(',', [0]);
        }

        $place = $request->filter['places'];

        // APP
        $haircolor = $request->filter['haircolor'];

        // PRICES
        $priceMin = $request->filter['price']['min'];
        $priceMax = $request->filter['price']['max'];

        // AGE
        $ageMin = array_search($request->filter['age']['min'], Helpers::getGirlAge());
        $ageMax = array_search($request->filter['age']['max'], Helpers::getGirlAge());

        // HEIGHT
        $heightMin = $request->filter['height']['min'];
        $heightMax = $request->filter['height']['max'];

        // HEIGHT
        $weightMin = $request->filter['weight']['min'];
        $weightMax = $request->filter['weight']['max'];

        // BREAST
        $breastMin = $request->filter['breast_size']['min'];
        $breastMax = $request->filter['breast_size']['max'];

        if($request->filter['time'] == "express") {
            $express = 1;
        } else {
            $express = 0;
        }
//dd($request->filter);
        $filter = DB::table('profiles')
            ->join('prices', 'profiles.id', '=', 'prices.profile_id')
            ->join('fields', 'profiles.id', '=', 'fields.profile_id')
            ->join('profile_place', 'profiles.id', '=', 'profile_place.profile_id')

            ->whereRaw('(profiles.breast_size BETWEEN ' . $breastMin . ' AND ' . $breastMax . ' )')
            ->whereRaw('(profiles.height BETWEEN ' . $heightMin . ' AND ' . $heightMax . ' )')
            ->whereRaw('(profiles.weight BETWEEN ' . $weightMin . ' AND ' . $weightMax . ' )')
            ->whereRaw('(profiles.age BETWEEN ' .$ageMin. ' AND ' .$ageMax. ' )')
            ->whereRaw('((profiles.express = ' . $express . ') or (0 in ('. $express .')) )')

            ->whereRaw('((profiles.haircolor = ' . $haircolor . ') or (0 in ('. $haircolor .')) )')
            ->whereRaw('(profile_place.place_id = ' . $place . ' or (0 in ('. $place .')) )')
            ->whereRaw('(fields.field_id in (' . $service . ') or (0 in ('. $service .')) )')
            ->orWhereRaw('(prices.day_one_hour_in BETWEEN ' . $priceMin . ' AND ' . $priceMax . ' )')


            ->select('profiles.id')
            ->distinct()
            ->get();

        $ids = [];
        foreach ($filter as $item) {
            $ids[] = $item->id;
        }

        $section = $request->filter['section'];
        $results = Profile::whereIn('id', $ids)
            ->where('active', 1)
            ->where('section', $section)
            ->get();
 //       dd($results);
        return view('components.ajax-search-results', [
            'results' => $results]);

    }

    function showEliteCatalog(Request $request)
    {

        $section_id = 1;
        $profiles = Profile::where('active', 1)->where('section', $section_id)->paginate(16);

        if ($request->ajax()) {
            return view('components.profiles.item_list_ajax', ['profiles' => $profiles]);
        }

        return view('catalog.profile_list', [
            'profiles' => $profiles,
            'section_id' => $section_id,
            'heading' => 'Элитные девушки Москвы',
            'title' => 'Элитные'
        ]);
    }

    function showIndividualsCatalog(Request $request)
    {
        $section_id = 2;
        $profiles = Profile::where('active', 1)->where('section', $section_id)->paginate(16);

        if ($request->ajax()) {
            return view('components.profiles.item_list_ajax', ['profiles' => $profiles]);
        }

        return view('catalog.profile_list', [
            'profiles' => $profiles,
            'section_id' => $section_id,
            'heading' => 'Индивидуалки Москвы',
            'title' => 'Индивидуалки'
        ]);
    }


    function showCheapCatalog(Request $request)
    {
        $section_id = 3;
        $profiles = Profile::where('active', 1)->where('section', $section_id)->paginate(16);

        if ($request->ajax()) {
            return view('components.profiles.item_list_ajax', ['profiles' => $profiles]);
        }

        return view('catalog.profile_list', [
            'profiles' => $profiles,
            'section_id' => $section_id,
            'heading' => 'Дешевые проститутки Москвы',
            'title' => 'Дешевые'
        ]);
    }


    function showBdsmCatalog(Request $request)
    {
        $section_id = 4;
        $profiles = Profile::where('active', 1)->where('section', $section_id)->paginate(16);

        if ($request->ajax()) {
            return view('components.profiles.item_list_ajax', ['profiles' => $profiles]);
        }

        return view('catalog.profile_list', [
            'profiles' => $profiles,
            'section_id' => $section_id,
            'heading' => 'БДСМ девушки Москвы',
            'title' => 'БДСМ'
        ]);
    }


    function showMasseusesCatalog(Request $request)
    {
        $section_id = 5;
        $profiles = Profile::where('active', 1)->where('section', $section_id)->paginate(16);

        if ($request->ajax()) {
            return view('components.profiles.item_list_ajax', ['profiles' => $profiles]);
        }

        return view('catalog.profile_list', [
            'profiles' => $profiles,
            'section_id' => $section_id,
            'heading' => 'Частные объявления массажисток Москвы',
            'title' => 'Массажистки'
        ]);
    }

    function addTestimonial(Request $request)
    {
        if ($request->ajax() && Auth::check()) {

            $profile = Profile::where('id', $request->testimonial['profile_id'])->with('testimonials')->first();
            // dd($profile);
            $profile->testimonials()->create(array_merge($request->testimonial, ['user_id' => Auth::user()->id]));

            return response()->json(['success' => 'Отзыв успешно добавлен!']);
        }
    }
}
