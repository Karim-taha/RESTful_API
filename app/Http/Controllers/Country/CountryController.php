<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Auth\Events\Validated;
use Validator;

class CountryController extends Controller
{
    // Get all countries :
    public function country()
    {
        return response()->json(Country::get(), 200);
    }

    // Get Country by id :
    public function countryById($id)
    {
        $country = Country::find($id);
        if(is_null($country)){
            return response()->json(["message"=>'Not Found!'], 404);
        }

        return response()->json($country, 200);
    }

    // Add country :
    public function countrySave(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'iso'  => 'required|min:2|max:10',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $country = Country::create($request->all());
        return response()->json($country, 201);
    }

    // Update :
    public function countryUpdate(Request $request, $id)
    {
        $country = Country::find($id);
        if(is_null($country)){
            return response()->json(["message"=>'Not Found!'], 404);
        }
        $country->update($request->all());
        return response()->json($country, 200);
    }

    // Delete :
    public function countryDelete(Request $equest, $id)
    {
        $country = Country::find($id);
        if(is_null($country)){
            return response()->json(["message"=>'Not Found!'], 404);
        }
        $country->delete();
        return response()->json(null, 204);
    }
}
