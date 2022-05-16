<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Validator;

class Model extends EloquentModel
{   
    public $validation_errors;

    public function validate()
    {
        // make a new validator object
        $v = Validator::make($this->attributesToArray(), $this->rules);
        $this->validation_errors = $v->errors();
        // return the result
        return $v->passes();
    }
}
