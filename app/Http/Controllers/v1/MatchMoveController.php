<?php
/**
 * This file contains only the class {@see unknown}
 * @author Sören Parton
 * @since 2017-01-12
 */


namespace App\Http\Controllers\v1;

use App\Services\v1\MatchService;
use Illuminate\Http\Request;
use Ryanhs\Chess\Chess;


/**
 * Class MatchMoveController
 * 
 * @author Sören Parton
 */
class MatchMoveController {
    /**
     * @var \App\Services\v1\MatchService
     */
    private $matches;

    public function __construct(MatchService $service) {
        $this->matches = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($matchId, Request $request)
    {
        $match = $this->matches->getMatch($matchId);
        $moveString = $request->input('moveString');

        return $this->matches->makeMove($match, $moveString);
    }

    public function bestMove($matchId) {
        return $this->matches->calculateBestMove($matchId);
    }
} 