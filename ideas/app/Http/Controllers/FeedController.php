<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $followingIDs = auth()->user()->followings()->pluck('user_id');

        //  $ideas = Idea::whereIn('user_id', $followingIDs)
        //     ->latest();

        // if (request()->has('search')) {
        //     $ideas = $ideas->search(request('search',''));
        // }

        $ideas = Idea::whereIn('user_id', $followingIDs)
            ->latest()
            ->when(request()->has('search'), function ($query) {
                $query->search(request('search', ''));
            })
            ->paginate(3);

        return view('dashboard', ['ideas' => $ideas]);
    }
}
