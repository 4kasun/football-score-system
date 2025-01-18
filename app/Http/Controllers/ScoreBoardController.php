<?php

namespace App\Http\Controllers;

use App\Events\ScoreBoardEvent;
use Illuminate\Http\Request;

class ScoreBoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $scoreboard = cache('latest_scoreboard', function () {
            // Fallback data if cache is empty
            return [
                'teams' => 'Team A vs Team B',
                'score' => ['teamA' => 0, 'teamB' => 0],
                'status' => 'Not Started',
            ];
        });

        return view('scoreboard.update', compact('scoreboard'));
    }

    /**
     * Show the edit scoreboard form.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        // Fetch the most recent broadcasted data from the cache
        $scoreboard = cache('latest_scoreboard', function () {
            // Fallback data if cache is empty
            return [
                'teams' => 'Team A vs Team B',
                'score' => ['teamA' => 0, 'teamB' => 0],
                'status' => 'Not Started',
            ];
        });

        // Pass the cached data to the view
        return view('scoreboard.update', compact('scoreboard'));
    }

    /**
     * Update the scoreboard.
     *  
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request)
    {
        $request->validate([
            'teams' => 'required|string|max:255',
            'teamA' => 'required|integer|min:0',
            'teamB' => 'required|integer|min:0',
            'status' => 'required|in:Not Started,In Progress,Completed',
        ]);

        $score = "{$request->teamA} - {$request->teamB}";

        // Broadcast the score update
        broadcast(new ScoreBoardEvent(
            $request->teams,
            $score,
            $request->status
        ));

        // Cache the broadcasted data
        cache(['latest_scoreboard' => [
            'teams' => $request->teams,
            'score' =>  ['teamA' => $request->teamA, 'teamB' => $request->teamB],
            'status' => $request->status,
        ]], now()->addMinutes(10)); // Cache for 10 minutes

        return redirect()->route('scoreboard.edit')->with('success', 'Scoreboard updated successfully.');
    }
}
