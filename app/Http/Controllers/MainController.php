<?php

namespace App\Http\Controllers;

use Session;
use App\Game\Fool;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $game = new Fool(2);
        $deck = $game->getDeck();
        $fluffy = $game->getFluffy();
        $firstMove = $game->getFirstMove();
        $cards = $game->getCardPlayer(0);

        return view('game')
            ->withCards($cards)
            ->withFluffy($fluffy)
            ->withCountDeck(count($deck))
            ->withFirstMove($firstMove);
    }

    public function moveCard(Request $request)
    {
        dd($request);
    }

}
