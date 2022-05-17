<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\ImportJob;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $flsah_mesage = null)
    {
        $latest_people = [];
        $last_import = ImportJob::latest()->first();
        if ($last_import){
            $latest_people = $last_import->people;
        }
        return view('Person/index')->with('latest_imports', $latest_people);
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
     * @param  \App\Http\Requests\StorePersonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $Person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $Person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $Person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $Person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePersonRequest  $request
     * @param  \App\Models\Person  $Person
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, Person $Person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $Person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $Person)
    {
        //
    }

    public function uploadCSV (Request $request)
    {
        $import_job = new ImportJob;
        $import_job->save();
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
                $result = Person::create_from_csv_row($row, true, $import_job);
                if($result["error"]){
                    return "error on row " . $row_number ."\n" . $result["error"];
                }
                $home_owners = array_merge($home_owners, $result["result"]);
                $row_number++;
            }
            fclose($file);

            return "File upload successful. Created " . count($home_owners) . " records. <a href='/Person' > Go Back</a>";
        } else {
            return "File is not valid. Please use .csv format. <a href='/Person' > Go Back</a>";
        }

    }
}
