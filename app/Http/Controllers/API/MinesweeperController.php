<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Minesweeper;
use Illuminate\Http\Request;

class MinesweeperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $size = 12;
        $dificulty = 10; // higher is harder (between 1 and 100)
        $mines = [];

        for ($r = 0; $r < $size; $r++) {
            for ($c = 0; $c < $size; $c++) {
                $mines[$r][$c] = (int) !(rand(1, 100) > $dificulty);
            }
        }

        auth()->user()->minesweepers()->create($mines);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Minesweeper  $minesweeper
     * @return \Illuminate\Http\Response
     */
    public function show(Minesweeper $minesweeper)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Minesweeper  $minesweeper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Minesweeper $minesweeper)
    {
        //
    }
}
