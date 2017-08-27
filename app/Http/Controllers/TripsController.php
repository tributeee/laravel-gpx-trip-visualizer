<?php

namespace App\Http\Controllers;

use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class TripsController extends Controller
{
    /**
     * @param array $data
     * @return mixed
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'trip' => 'required|mimes:xml,gpx',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = Auth::user()->trips;

        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return back()->with(['errors' => $validator->messages()])->withInput();
        }

        $tripName = $request->get('name');
        $file = $request->file('trip');
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $user = Auth::user();
        $filePath = public_path('media/trips/') . base64_encode($user->id . $user->name);

        if (!file_exists($filePath)) {
            File::makeDirectory($filePath, 0777, true);
        }

        $file->move($filePath, $fileName);

        $trip = new Trip([
            'name' => $tripName,
            'file' => base64_encode($user->id . $user->name) . '/' . $fileName
        ]);

        $user->trips()->save($trip);

        return response()->redirectTo('/trips')->with('message', 'Trip successfully created!');

    }
}
