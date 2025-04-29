<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Tag;
use App\Models\Country;
use App\Models\Language;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = Station::with(['country', 'city', 'language'])->where('status','1')->paginate(10);

        return view('stations.index', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        $tags = Tag::all();
        $languages = Language::all();

        return view('stations.create', compact('countries', 'cities','tags', 'languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'src' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'language_id' => 'required|exists:languages,id',
            'type' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('stations', 'public');
        }
        Station::create(array_merge($validated, ['status' => '0']));
        //dd("كوكو");
        return response()->json(['message' => 'Station created successfully.']);
        //return redirect()->route('stations.index')
        //->with('success', 'Station created successfully with default status Not Active.');
    }


    public function toggleLike(Station $station)
{
    $user = auth()->user();

    if ($user->favoriteStations()->where('station_id', $station->id)->exists()) {
        $user->favoriteStations()->detach($station->id);
        return response()->json(['liked' => false]);
    } else {
        $user->favoriteStations()->attach($station->id);
        return response()->json(['liked' => true]);
    }
}


    public function destroy(string $id)
    {
        //
    }
}
