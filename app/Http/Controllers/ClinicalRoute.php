<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinical;

class ClinicalRoute extends Controller
{
   public function ClinicalRoute(){
    $clinicaldata = Clinical::all();
    $data = compact('clinicaldata');
    return view('frontend/clinical')->with($data);
   }

}
