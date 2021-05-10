<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\Location;
use App\Models\Venue;
use Illuminate\Http\Request;
//http://127.0.0.1:8000/App%5CHttp%5CControllers%5CHomeController
class HomeController extends Controller
{
            public function index()
            {
                $featuredVenues = Venue::where('is_featured', 1)->get();
                $eventTypes = EventType::all();
                $locations = Location::all();
                $newestVenues = Venue::with('event_types')
                ->latest()->take(3)->get();
                return view('home', compact('featuredVenues', 'eventTypes', 'locations', 'newestVenues'));
            }
}
