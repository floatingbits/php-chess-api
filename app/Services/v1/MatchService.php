<?php
/**
 * This file contains only the class {@see unknown}
 * @author Sören Parton
 * @since 2017-01-12
 */


namespace App\Services\v1;

use App\Match;
use App\Move;
use Illuminate\Http\Request;
use Netsensia\Uci\Engine;
use Ryanhs\Chess\Chess;


/**
 * Class MatchService
 * 
 * @author Sören Parton
 */
class MatchService {

    /**
     * @var Engine;
     */
    private $chessEngine;

    public function __construct(Engine $engine) {
        $this->chessEngine = $engine;
    }
    /**
     * @param Request $request
     * @return array
     * @author Sören Parton
     */
    public function getMatches() {
        $allMatches = Match::with('moves')->get();
        $result = [];
        foreach ($allMatches as $match) {
            $result[] = $this->prepareMatch($match);
        }
        return $result;
    }
    /**
     * @param int $matchId
     * @return Match
     * @author Sören Parton
     */
    public function getMatch($matchId) {
        return Match::with('moves')->find($matchId);
    }

    private function prepareMatch(Match $match) {
        $moveStrings = [];
        foreach ($match->moves as $move) {
            $moveStrings[] = $move->move;
        }
        return [
            'id' => $match->id,
            'description' => $match->description,
            'movesString' => $this->getMovesString($match),
            'fenString' => $this->getFenString($match),
        ];
    }

    /**
     * @param Match $match
     * @return string
     * @author Sören Parton
     */
    private function getMovesString(Match $match) {
        $moveStrings = [];
        foreach ($match->moves as $move) {
            $moveStrings[] = $move->move;
        }
        return implode(' ', $moveStrings);
    }
    /**
     * @param Match $match
     * @return string
     * @author Sören Parton
     */
    private function getFenString(Match $match) {
        $chess = new Chess();
        $chess->reset();

        foreach ($match->moves as $move) {
            $sanStart = substr($move->move, 0,2);
            $sanEnd = substr($move->move, 2,2);
            $chess->move(['from' => $sanStart, 'to' => $sanEnd]);
        }
        return $chess->generateFen();
    }
    /**
     * @param Request $request
     * @return array
     * @author Sören Parton
     */
    public function createMatch(Request $request) {
        $match = new Match();
        $description = $request->input('description');
        $match->description = $description;
        $match->save();
        return $this->prepareMatch($match);
    }

    /**
     * @param int $matchId
     * @return void
     * @author Sören Parton
     */
    public function deleteMatch($matchId) {

        Match::destroy($matchId);
    }

    /**
     * @param $match
     * @param $moveString
     * @return Move
     * @author Sören Parton
     */
    public function makeMove($match, $moveString) {
        $move = new Move();
        $move->move = $moveString;
        //@todo validate move string
        $chess = new Chess();
        $chess->move($moveString);
        $move->match()->associate($match);
        $move->save();
        $match = Match::query()->find($match->id);
        return $this->prepareMatch($match);
    }

    /**
     * @param $matchId
     * @return string
     * @author Sören Parton
     */
    public function calculateBestMove($matchId) {
        $match = Match::query()->find($matchId);
        $previousMoves = $this->getMovesString($match);
        $this->chessEngine->setPosition(Engine::STARTPOS);
        return $this->chessEngine->getMove($previousMoves);
    }
} 