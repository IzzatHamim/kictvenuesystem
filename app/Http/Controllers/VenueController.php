<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        // Get all available venues
        $venues = Venue::where('is_available', true)->get();
        
        return view('home', compact('venues'));
    }
    public function show(Venue $venue)
{
    return view('venues.show', compact('venue'));
}
}

