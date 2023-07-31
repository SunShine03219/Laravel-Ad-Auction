<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function countries()
    {
        $title = trans('app.countries');
        $countries = Country::all();

        return view('admin.countries', compact('title', 'countries'));
    }

    public function stateList()
    {
        $title = trans('app.states');
        $countries = Country::all();

        $searchTerm = \request('state_name');
        if ($searchTerm) {
            $states = State::query()->with('country')->where('state_name', 'like', "%$searchTerm%")->paginate(20);
        } else {
            $states = State::query()->with('country')->paginate(50);
        }

        return view('admin.states', compact('title', 'countries', 'states'));
    }

    public function saveState(Request $request)
    {
        $rules = [
            'country_id' => 'required',
            'state_name' => 'required',
        ];
        $this->validate($request, $rules);

        $duplicate = State::whereStateName($request->state_name)->count();
        if ($duplicate > 0) {
            return back()->with('error', trans('app.state_exists_in_db'));
        }

        $data = [
            'state_name' => $request->state_name,
            'country_id' => $request->country_id,
        ];

        State::create($data);

        return back()->with('success', trans('app.state_created'));
    }

    public function stateEdit($id)
    {
        $state = State::find($id);
        $title = trans('app.edit_state');
        $countries = Country::all();

        return view('admin.state_edit', compact('title', 'countries', 'state'));
    }

    public function stateEditPost(Request $request, $id)
    {
        $state = State::find($id);

        $rules = [
            'country_id' => 'required',
            'state_name' => 'required',
        ];
        $this->validate($request, $rules);

        $duplicate = State::whereStateName($request->state_name)->where('id', '!=', $id)->count();
        if ($duplicate > 0) {
            return back()->with('error', trans('app.state_exists_in_db'));
        }

        $data = [
            'state_name' => $request->state_name,
            'country_id' => $request->country_id,
        ];

        $state->update($data);

        return back()->with('success', trans('app.state_updated'));
    }

    public function stateDestroy(Request $request)
    {
        $state = State::find($request->state_id);
        if ($state) {
            $state->delete();
        }

        return ['success' => 1, 'msg' => trans('app.state_deleted')];
    }

    public function cityList()
    {
        $title = trans('app.cities');
        $countries = Country::all();

        $searchTerm = \request('city_name');

        if ($searchTerm) {
            $cities = City::query()->leftJoin('states', 'states.id', '=', 'cities.state_id')->leftJoin('countries', 'countries.id', '=', 'states.country_id')->where('cities.city_name', 'like', "%{$searchTerm}%")->orderBy('city_name', 'asc')->paginate(50);
        } else {
            $cities = City::query()->leftJoin('states', 'states.id', '=', 'cities.state_id')->leftJoin('countries', 'countries.id', '=', 'states.country_id')->orderBy('city_name', 'asc')->paginate(50);
        }

        return view('admin.cities', compact('title', 'countries', 'cities'));
    }

    public function saveCity(Request $request)
    {
        $rules = [
            'country' => 'required',
            'state' => 'required',
            'city_name' => 'required',
        ];
        $this->validate($request, $rules);

        $duplicate = City::whereCityName($request->city_name)->count();
        if ($duplicate > 0) {
            return back()->with('error', trans('app.city_exists_in_db'));
        }

        $data = [
            'city_name' => $request->city_name,
            'state_id' => $request->state,
        ];

        City::create($data);

        return back()->with('success', trans('app.city_created'));
    }

    public function cityEdit($id)
    {
        $city = City::find($id);

        if (! $city) {
            return view('admin.error.error_404');
        }

        $title = trans('app.edit_city');
        $countries = Country::all();

        $states = null;
        if ($city->state) {
            $states = State::whereCountryId($city->state->country_id)->get();
        }

        return view('admin.city_edit', compact('title', 'countries', 'city', 'states'));
    }

    public function cityEditPost(Request $request, $id)
    {
        $city = City::find($id);

        $rules = [
            'country' => 'required',
            'state' => 'required',
            'city_name' => 'required',
        ];
        $this->validate($request, $rules);

        $duplicate = City::whereCityName($request->city_name)->where('id', '!=', $id)->count();
        if ($duplicate > 0) {
            return back()->with('error', trans('app.state_exists_in_db'));
        }

        $data = [
            'city_name' => $request->city_name,
            'state_id' => $request->state,
        ];
        $city->update($data);

        return back()->with('success', trans('app.city_updated'));
    }

    public function cityDestroy(Request $request)
    {
        $state = City::find($request->city_id);
        if ($state) {
            $state->delete();
        }

        return ['success' => 1, 'msg' => trans('app.city_deleted')];
    }

    public function searchCityJson(Request $request)
    {
        $city_query = City::where('city_name', 'like', "%{$request->q}%")->take(30)->get();
        $cities = [
            'total_count' => $city_query->count(),
            'items' => $city_query,
        ];

        return $cities;
    }

    public function countriesListsPublic($country_code = null)
    {
        $title = trans('app.countries');
        $countries = Country::all();

        $is_all_states = false;
        if ($country_code) {
            $title = trans('app.all_states');
            $is_all_states = true;
            $country = Country::whereCountryCode($country_code)->first();
        }

        return view('countries', compact('countries', 'title', 'is_all_states', 'country'));
    }

    public function setCurrentCountry($country_code)
    {
        $country = Country::whereCountryCode($country_code)->first();
        if ($country) {
            session(['country' => $country->toArray()]);
        }

        return redirect(route('home'));
    }
}
