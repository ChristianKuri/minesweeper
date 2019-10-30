<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Minesweeper as MinesweepersCollection;
use App\Minesweeper;
use Illuminate\Http\Request;

class MinesweeperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return MinesweepersCollection::collection($request->user()->minesweepers);
    }

    /**
     * Store a newly created minesweeper in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $size = $request->input('size') ?? 12;
        $dificulty = $request->input('dificulty') ?? 15; // higher is harder (between 1 and 100)
        $mines = [];
        $mines['status'] = 'open';

        for ($r = 0; $r < $size; $r++) {
            for ($c = 0; $c < $size; $c++) {
                $mines['game'][$r][$c]['bomb'] = (int) !(rand(1, 100) > $dificulty);
                $mines['game'][$r][$c]['open'] = 0;
                $mines['game'][$r][$c]['clicked'] = 0;
                $mines['game'][$r][$c]['marked'] = 0;
                $mines['game'][$r][$c]['show'] = null;
            }
        }

        $minesweeper = $request->user()->minesweepers()->create([
            'mines' => serialize($mines)
        ]);

        return response([
            'id'    => $minesweeper->id,
            'mines' => $mines
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Minesweeper  $minesweeper
     * @return \Illuminate\Http\Response
     */
    public function show(Minesweeper $minesweeper)
    {
        return response([
            'id'    => $minesweeper->id,
            'mines' => unserialize($minesweeper->mines)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Minesweeper  $minesweeper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Minesweeper $minesweeper)
    {
        $minesweeper->update(['mines' => serialize($request->input('mines'))]);
    }
}
