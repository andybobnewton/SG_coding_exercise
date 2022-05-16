<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHomeOwnerRequest;
use App\Http\Requests\UpdateHomeOwnerRequest;
use Illuminate\Http\Request;
use App\Models\HomeOwner;

class HomeOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $flsah_mesage = null)
    {
        $latest_imports = HomeOwner::latest()->take(25)->get();
        return view('HomeOwner/index')->with('latest_imports', $latest_imports);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHomeOwnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomeOwnerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeOwner  $homeOwner
     * @return \Illuminate\Http\Response
     */
    public function show(HomeOwner $homeOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeOwner  $homeOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeOwner $homeOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomeOwnerRequest  $request
     * @param  \App\Models\HomeOwner  $homeOwner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeOwnerRequest $request, HomeOwner $homeOwner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeOwner  $homeOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeOwner $homeOwner)
    {
        //
    }

    public function uploadCSV (Request $request)
    {
        $message = "";
        $file = $request->file('file');
        if ($file && strtolower($file->getClientOriginalExtension()) == 'csv'){
            $filepath = $file->getRealPath();
            $file = fopen($filepath, "r");
            $home_owners = array();
            $row_number = 0;
            while (($row = fgetcsv($file)) !== FALSE) {
                if ($row_number == 0) {
                    #headers
                    $row_number++;
                    continue;
                }
                $result = HomeOwner::create_from_csv_row($row, true);
                if($result["error"]){
                    return "error on row " . $row_number ."\n" . $result["error"];
                }
                $home_owners = array_merge($home_owners, $result["result"]);
                $row_number++;
            }
            fclose($file);

            #$message =
            return "File upload successful. Created " . count($home_owners) . " records";
        } else {
            #$message =
            return "File is not valid. Please use .csv format";
        }

        return redirect()->route('HomeOwner.index')->with('flash_message', $message);
    }
}
