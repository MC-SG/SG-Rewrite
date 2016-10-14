<?php
namespace SurvivalGames\ArenaManager;

use pocketmine\Server;

use SurvivalGames\SurvivalGames;

class Arena{

	public $plugin, $data;

	public function __construct(SurvivalGames $plugin, Array $data)
	{
		$this->plugin = $plugin;
		$this->data = $data;
	}

	public function getName()
	{
		return $this->data["name"];
	}

	public function getMaxPlayers()
	{
		return 24;
	}

	public function getLevel()
	{
		return $this->plugin->getServer()->getLevelByName($this->data["name"]);
	}

	public function getGameTime()
	{
		return $this->data["gametime"];
	}

	public function getStartTime()
	{
		return $this->data["starttime"];
	}

	public function reset()
	{
		$this->data["startime"] = (int) 60;
		$this->data["gametime"] = (int) 780;
	}

	public function save()
	{
		ArenaManager::save($this);
	}
}