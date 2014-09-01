<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 01/09/14
 * Time: 16:19
 */

namespace Frontend\Controller;


use Backend\Model\Match;
use View;

class MatchesController extends BaseController{

    /**
     * @author Loris D'antonio
     *
     * Display a listing of matches > current date
     *
     * @return Response
     */
    public function index(){
        //TODO: seleizonare solo i match prossimi, non tutti
        $matches = Match::all();

        return View::make('index',compact('matches'));
    }

    public function info($id){
        $match = Match::with('tickets')->findOrFail($id);

        return View::make('infoMatch',compact('match'));
    }
}