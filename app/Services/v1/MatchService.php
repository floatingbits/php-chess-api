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


/**
 * Class MatchService
 * 
 * @author Sören Parton
 */
class MatchService {

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
     * @param Request $request
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
            'movesString' => implode(' ', $moveStrings)
        ];
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

    public function makeMove($match, $moveString) {
        $move = new Move();
        $move->move = $moveString;
        $move->match()->associate($match);
        $move->save();
        return $move;
    }
} 