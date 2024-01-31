<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //dump(Idea::all());

        // $ideas = Idea::orderBy('created_at', 'desc');

        // if (request()->has('search')) {
        //      $ideas = $ideas->search(request('search',''));
        // }

        $ideas = Idea::when(request()->has('search'), function ($query) {
            $query->search(request('search', ''));
        })->orderBy('created_at','desc')->paginate(3);

        return view('dashboard', [
            'ideas' => $ideas
        ]);
    }
}
