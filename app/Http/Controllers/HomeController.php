<?php

namespace App\Http\Controllers;

use App\Http\Rating;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        $rates = Rating::getStarsRateCount(User::all());

        return view('home', [
            'users' => $users,
            'rates' => $rates,
        ]);
    }

    public function setUserRate(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'rate' => ['required', 'numeric', 'in:1,2,3,4,5'],
        ]);

        $check = Rate::where('user_id', $request->user()->id)->where('rateable_id', $request->user_id)->exists();

        if($check)
        {
            return back()->withInput($request->all())->with('message', 'sorry this user is rated before');
        }

        $user = User::find($request->user_id);

        Rating::setCalculatedRate($user, $request->rate);

        Rate::create([
            'rate' => $request->rate,
            'user_id' => $request->user()->id,
            'rateable_type' => User::class,
            'rateable_id' => $request->user_id,
        ]);

        return to_route('home')->with('success', 'done');
    }
}
