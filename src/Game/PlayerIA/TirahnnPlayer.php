<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class TirahnnPlayers
 * @package Hackathon\PlayerIA
 * @author Clément Davin
 */
 
 /* 
				MA STRATEGIE
	
	- jouer papie au 1er tour
	- jouer ensuite le choix pour battre le move précedent de l'adversaire ou l'inverse si je gagne pas assez
	- si il joue que le même, je joue de quoi le battre
	- si il en joue très souvent un, je joue de quoi battre celui la
	- si je perd trop, je commence d'abord par jouer comme lui
	- si je continue de perdre, je joue l'inverse de lui
 
 */
class TirahnnPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {

		//First Round
		if ($this->result->getNbRound() === 0)
			return parent::paperChoice();
		
		$stats = $this->result->getStatsFor($this->mySide);
		
		//Chain Loose ? Let's change strat
		if ($this->result->getNbRound() > 30 && $this->result->getNbRound() < 50 && $stats['score'] < $this->result->getNbRound())
			return $this->result->getLastChoiceFor($this->opponentSide);
		
		if ($this->result->getNbRound() > 50 && $stats['score'] < $this->result->getNbRound() + 10)
		{
			if ($this->result->getLastChoiceFor($this->opponentSide) === parent::paperChoice())
				return parent::rockChoice();
			else if ($this->result->getLastChoiceFor($this->opponentSide) === parent::scissorsChoice())
				return parent::paperChoice();
			return parent::scissorsChoice();
		}
		
		
		//Repetitive move ?
		$gotRock = false;
		$gotPaper = false;
		$gotScissors = false;
		
		if ($stats['scissors'] !== 0)
			$gotScissors = true;
		if ($stats['rock'] !== 0)
			$gotRock = true;
		if ($stats['paper'] !== 0)
			$gotPaper = true;
		
		if ($gotPaper && !$gotRock && !$gotScissors)
			return parent::scissorsChoice();
		if (!$gotPaper && $gotRock && !$gotScissors)
			return parent::paperChoice();
		if (!$gotPaper && !$gotRock && $gotScissors)
			return parent::rockChoice();	
		
		
		//Lot of one ?
		if ($this->result->getNbRound() > 20 && $stats['scissors'] > $stats['paper'] + $stats['rock'])
			return parent::rockChoice();
		if ($this->result->getNbRound() > 20 && $stats['paper'] > $stats['scissors'] + $stats['rock'])
			return parent::scissorsChoice();
		if ($this->result->getNbRound() > 20 && $stats['rock'] > $stats['paper'] + $stats['scissors'])
			return parent::paperChoice();

		
		//No strat ? Let's play stupid
		if ($stats['score'] > $this->result->getNbRound() * 2)
		{
			if ($this->result->getLastChoiceFor($this->opponentSide) === parent::paperChoice())
				return parent::scissorsChoice();
			else if ($this->result->getLastChoiceFor($this->opponentSide) === parent::scissorsChoice())
				return parent::rockChoice();
			return parent::paperChoice();
			
		}

		//loosing ? lets play even more stupid
		if ($this->result->getLastChoiceFor($this->mySide) === parent::paperChoice())
				return parent::rockChoice();
		else if ($this->result->getLastChoiceFor($this->mySide) === parent::scissorsChoice())
			return parent::paperChoice();
		return parent::scissorsChoice();

    }
};
