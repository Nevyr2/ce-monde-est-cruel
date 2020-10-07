<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class TirahnnPlayers
 * @package Hackathon\PlayerIA
 * @author Clément Davin
 */
class TirahnnPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Choice           ?    $this->result->getLastChoiceFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Choice ?    $this->result->getLastChoiceFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get all the Choices          ?    $this->result->getChoicesFor($this->mySide)
        // How to get the opponent Last Choice ?    $this->result->getChoicesFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get the stats                ?    $this->result->getStats()
        // How to get the stats for me         ?    $this->result->getStatsFor($this->mySide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // How to get the stats for the oppo   ?    $this->result->getStatsFor($this->opponentSide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // -------------------------------------    -----------------------------------------------------
        // How to get the number of round      ?    $this->result->getNbRound()
        // -------------------------------------    -----------------------------------------------------
        // How can i display the result of each round ? $this->prettyDisplay()
        // -------------------------------------    -----------------------------------------------------

		
		
		if ($this->result->getNbRound() === 0)
			return parent::paperChoice();
		
		$moves = $this->result->getChoicesFor($this->opponentSide);
		
		$onlyRock = false;
		$onlyPaper = false;
		$onlyScissors = false;
		
		$gotRock = false;
		$gotPaper = false;
		$gotScissors = false;
		
		foreach ($moves as $move) {
            if ($move === parent::paperChoice())
				$gotPaper = true;
			if ($move === parent::scissorsChoice())
				$gotScissors = true;
			if ($move === parent::rockChoice())
				$gotRock = true;
        }
		
		if ($gotPaper && !$gotRock && !$gotScissors)
			$onlyPaper = true;
		if (!$gotPaper && $gotRock && !$gotScissors)
			$onlyRock = true;
		if (!$gotPaper && !$gotRock && $gotScissors)
			$onlyScissors = true;
		
		if ($onlyPaper)
			return parent::scissorsChoice();
		if ($onlyRock)
			return parent::paperChoice();
		if ($onlyScissors)
			return parent::rockChoice();
			
		if ($this->result->getLastChoiceFor($this->opponentSide) === parent::paperChoice())
		{
			return parent::scissorsChoice();
		}
		else if ($this->result->getLastChoiceFor($this->opponentSide) === parent::scissorsChoice())
		{
			return parent::rockChoice();
		}
		
        return parent::paperChoice();

    }
};
