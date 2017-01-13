<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\v1\MatchService;
class MatchController extends Controller
{
    /**
     * @var \App\Services\v1\MatchService
     */
    private $matches;

    public function __construct(MatchService $service) {
        $this->matches = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();
        return $this->matches->getMatches($parameters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->matches->createMatch($request);
    }
}
