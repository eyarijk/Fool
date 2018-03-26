<?php


namespace App\Game;


class Fool
{
    protected $players = array();

    protected $deck = array();

    protected $generalFluffy;

    protected $maxMainCards = 6;

    protected $countPlayers;

    protected $firstMovePlayer;

    protected $fluffys = array(
        'buba',
        'cherva',
        'hresta',
        'pika',
    );

    protected $cards = array(
        array(1,'6'),
        array(2,'7'),
        array(3,'8'),
        array(4,'9'),
        array(5,'10'),
        array(6,'Valet'),
        array(7,'Queen'),
        array(8,'King'),
        array(9,'Ace'),
    );


    public function __construct($players = 1)
    {
        $this->countPlayers = $players;
        $this->generalFluffy = $this->fluffys[random_int(0,3)];
        $this->generateDeck();
        $this->distribution();
        $this->firstMove();

    }

    protected function generateDeck()
    {
        foreach ($this->fluffys as $fluffy){
            foreach ($this->cards as $card){
                array_push($card,$fluffy);
                if ($this->generalFluffy == $fluffy)
                    array_push($card,true);
                else {
                    array_push($card,false);
                }
                $this->deck[] = $card;
            }
        }
        shuffle($this->deck);
    }

    protected function  distribution()
    {
        $deck = $this->deck;
        for ($i = 0; $i < $this->countPlayers; $i++){
            $j = 1;
            foreach ($deck as $key => $card){
                $this->players[$i]['cards'][] = $card;
                unset($deck[$key]);
                $j++;
                if ($j > $this->maxMainCards)
                    break;
            }
        }
        $this->deck = $deck;
    }

    protected function firstMove()
    {
        $min = array(12,'player'=>null);

        foreach ($this->players as $key => $player){
            foreach ($player['cards'] as $card){
                if ($card[3] == true){
                    if ($min[0] > $card[0]){
                        $min['player'] = $key;
                    }
                }
            }
        }

        $this->firstMovePlayer = $min['player'];
    }

    public function getCardPlayer($player)
    {
        return $this->players[$player]['cards'];
    }

    public function getFluffy()
    {
        return $this->generalFluffy;
    }

    public function getDeck()
    {
        return $this->deck;
    }

    public function getFirstMove()
    {
        return $this->firstMovePlayer;
    }

    public function getCountPlayers()
    {
        return $this->countPlayers;
    }

}