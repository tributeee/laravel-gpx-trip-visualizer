<?php

namespace App\Http\Controllers;

use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

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
        return view('trips.index');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return back()->with(['errors' => $validator->messages()]);
        }

        $tripName = $request->get('name');
        $file = $request->file('trip');
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $user = Auth::user();
        $filePath = public_path('media/trips/') . $user->id;

        if (!file_exists($filePath)) {
            File::makeDirectory($filePath, 0777, true);
        }

        $file->move($filePath, $fileName);

        $data = [
            'name' => $tripName,
            'file' => $user->id . '/' . $fileName
        ];

        $trip = new Trip($data);

        $user->trips()->save($trip);

        return redirect()->back()->with('message', 'Succesfully added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
