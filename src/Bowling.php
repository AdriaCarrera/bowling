<?php

class Bowling
{
    public $MAX_FRAMES = 10;
    public $gameInfo;
    public $gameScore;

    public function play(string $game){
        $actualFare = 0;
        $this->gameInfo = array_fill(0, $this->MAX_FRAMES + 2, '');
        $this->gameScore = array_fill(0, $this->MAX_FRAMES + 2, 0);


        while (strlen($game) && $actualFare < $this->MAX_FRAMES){

            $game = $this->playFare($actualFare, $game);
            if ($game === -1) return -1;

            $actualFare++;

            if ($actualFare === $this->MAX_FRAMES ){
                if ($this->playBonus($game) === -1) return -1;
            }
        }

        $totalScore = 0;

        for ($i=0; $i<$this->MAX_FRAMES; $i++){
            $totalScore += $this->gameScore[$i];
        }
        return $totalScore;
    }

    public function playFare($fareNumber, $game){
        if (!$game) return -1;

        $firstThrow = $game[0];

        if ($firstThrow === 'X') { //Strike!
            $this->gameInfo[$fareNumber] = 'X';

            $this->setScore($fareNumber, 10, 0, true);
            $game = substr($game, 1, strlen($game));
        }

        else if ($this->isNumber($firstThrow) && strlen($game) >= 2){
            $secondThrow = $game[1];

            if($secondThrow === '/'){ //Spare!
                $this->gameInfo[$fareNumber] = '/';

                $this->setScore($fareNumber, $firstThrow, 10 - $firstThrow, false);
            }
            else if ($this->isNumber($secondThrow)){
                $firstThrow = intval($firstThrow);
                $secondThrow = intval($secondThrow);
                if ($firstThrow + $secondThrow >= 10) return -1;
                $this->setScore($fareNumber,$firstThrow, $secondThrow, false);

            }
            else return -1;

            $game = substr($game, 2, strlen($game));
        }

        else return -1;

        return $game;
    }

    public function setScore($fareNumber, int $firstThrow, int $secondThrow, bool $isStrike){
        $this->gameScore[$fareNumber] += $firstThrow + $secondThrow;

        if ($fareNumber - 1 >= 0 && $this->gameInfo[$fareNumber-1] === 'X'){
            if ($fareNumber - 2 >= 0 && $this->gameInfo[$fareNumber-2] === 'X'){ //Two Strikes!
                $this->gameScore[$fareNumber-2] += $firstThrow;
            }
            $this->gameScore[$fareNumber-1] += $firstThrow + $secondThrow;
        }
        if ($fareNumber - 1 >= 0 && $this->gameInfo[$fareNumber-1] === '/'){
            $this->gameScore[$fareNumber-1] += $firstThrow;
        }

    }

    public function playBonus($game){
        $lastInfo = $this->gameInfo[$this->MAX_FRAMES - 1];
        $actualFare = $this->MAX_FRAMES;

        if ($lastInfo === 'X'){ //Striked
            $game = $this->playFare($actualFare, $game);
            if ($game === -1) return -1;
            if (strlen($game) && $game[0] === 'X') { //Three strikes!
                $this->playFare($actualFare + 1, $game);
            }
        }
        else if ($lastInfo === '/'){ //Spared
            $this->playFare($actualFare, $game);
        }
    }

    public function isNumber(string $char){
        return $char === '1' || $char === '2' || $char === '3' || $char === '4' || $char === '5' ||
            $char === '6' || $char === '7' || $char === '8' || $char === '9' || $char === '0';
    }
}
