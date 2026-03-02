<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function index()
    {
        try {
            // Fetch data from the Flask API
            $response = Http::get('http://127.0.0.1:5000/api/data');

            if ($response->successful()) {
                $data = $response->json();
            } else {
                $data = ['title' => 'Error', 'items' => []];
            }
        } catch (\Exception $e) {
            // If Python script isn't running, show an empty state
            $data = ['title' => 'Python API Offline', 'items' => []];
        }

        return view('python-dashboard', compact('data'));
    }
}