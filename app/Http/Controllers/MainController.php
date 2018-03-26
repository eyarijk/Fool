<?php

namespace App\Http\Controllers;

use Session;
use App\Game\Fool;
use App\StartGame;
use App\Player;
use App\Deck;
use App\Move;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {

    }

    public function moveCard(Request $request)
    {
        dd($request);
    }

    public function onCreateGame(Request $request)
    {
        $gameDb = new StartGame();
        $gameDb->players = $request->countPlayer;
        $gameDb->save();

        $player = new Player();
        $player->start_game_id = $gameDb->id;
        $player->user_id = auth()->id();
        $player->game_player_id = 0;
        $player->save();

        Session::put('game_player_id',$player->game_player_id);

        return redirect('/wait?game_id='.$gameDb->id);
    }

    public function wait(Request $request)
    {
        $game = StartGame::findOrFail($request->game_id);

        if ($game->players <= $game->player->count()){
            $this->generateGame($game->id);
        }

        return view('waitPlayers')->withGame($game);
    }

    public function checkGame(Request $request)
    {
        $game = StartGame::findOrFail($request->id);
        if ($game->players == $game->player->count()){

        }
    }

    public function onJoinGame(Request $request)
    {
        $game = StartGame::findOrFail($request->id);

        $getListPlayers = Player::where('start_game_id',$game->id)->pluck('game_player_id')->toArray();

        if ($game->players <= count($getListPlayers)){
            return redirect('/');
        }

        $player = new Player();
        $player->start_game_id = $game->id;
        $player->user_id = auth()->id();
        $player->game_player_id = array_pop($getListPlayers) + 1;
        $player->save();

        Session::put('game_player_id',$player->game_player_id);

        if ($game->players <= $game->player->count()){
            $this->generateGame($game->id);
        }

    }

    public function generateGame($id)
    {
        $game = StartGame::findOrFail($id);

        $createFool = new Fool($game->players);
        $game->fluffy = $createFool->getFluffy();
        $game->save();

        $cards = $createFool->getDeck();

        $deck = new Deck();
        $deck->start_game_id = $game->id;
        $deck->cards = json_encode($cards);
        $deck->remainder = count($cards);
        $deck->save();

        foreach($game->player as $player){
            $player->card = json_encode($createFool->getCardPlayer($player->game_player_id));
            $player->save();
        }

        $move = new Move();
        $move->start_game_id = $game->id;
        $move->player_id = $createFool->getFirstMove();
        $move->cards = json_encode($createFool->getCardPlayer($move->player_id));
        $move->status = true;

        if ($move->player_id + 1 > $game->players) {
            $move->to_player = 0;
        } else {
            $move->to_player = $move->player_id + 1;
        }

        $move->save();

        return redirect()->route('game.index');
    }

}
