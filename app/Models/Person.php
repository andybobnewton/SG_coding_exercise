<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use HasFactory;

    protected $fillable = ['title','first_name','initial','last_name'];

    protected $rules = array(
        'title'  => 'required',
        'last_name'  => 'required',
    );


    public static function create_from_csv_row(array $row, bool $store_results = false) {
        $invalid_entries = false;
        $persons_name = $row[0];
        
        $first_person = null;
        if (str_contains($persons_name, '&')){
            # 2 people, break out the first person first
            list($first_person, $persons_name) = explode('&', $persons_name);
            $first_person = trim($first_person);
            $persons_name = trim($persons_name);
        }
        $name_array = explode(' ', $persons_name );
        $title = array_shift($name_array);
        $last_name = array_pop($name_array);

        $first_name = array_shift($name_array);
        if ($first_name) {
            $first_name = str_replace('.','',$first_name);
        }
        $home_owners = [];
        try {
            DB::beginTransaction();

            array_push( $home_owners, new Person([
                'title' => $title,
                'first_name' => $first_name && strlen($first_name) > 1 ? $first_name : null,
                'initial' => $first_name && strlen($first_name) == 1 ? $first_name : null,
                'last_name' => $last_name
            ]));
            if ($first_person){
                $name_array = explode(' ', $first_person );
                $title = array_shift($name_array);

                $first_name = array_shift($name_array);
                if ($first_name) {
                    $first_name = str_replace('.','',$first_name);
                }
                
                array_push( $home_owners, new Person([
                    'title' => $title,
                    'first_name' => $first_name && strlen($first_name) > 1 ? $first_name : null,
                    'initial' => $first_name && strlen($first_name) == 1 ? $first_name : null,
                    'last_name' => $last_name
                ]));
            }
            foreach ($home_owners as $home_owner) {
                if (!$home_owner->validate()){
                    $invalid_entries = true;
                }
            }

            if (!$invalid_entries && $store_results){
                foreach ($home_owners as $home_owner) {
                    $home_owner->save();
                }
            }
        } catch (\PDOException $e) {
            DB::rollBack();

            return array( "result" => $home_owners, "error" => $e);
        }
        DB::commit();


        return array( "result" => $home_owners, "error" => $invalid_entries ? "Invalid row" : null);
    }


}