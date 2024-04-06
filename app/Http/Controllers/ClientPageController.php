<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class ClientPageController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $countries = Country::all();
    $topics = Country::all();
    return view('content.client.index', ['pageConfigs' => $pageConfigs, 'countries' => $countries, 'topics' => $topics]);
  }
}
