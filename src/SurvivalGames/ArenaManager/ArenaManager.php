<?php
namespace SurvivalGames\ArenaManager;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use SurvivalGames\SurvivalGames;

class ArenaManager{

	protected $plugin;

	public function __construct(SurvivalGames $plugin){
		$this->plugin = $plugin;
	}

	static function save(Arena $arena){
		$data = ["name" => $arena->getName(), "starttime" => 30, "gametime" => 780];
		$cfg = new Config($this->plugin->getDataFolder() . "/arenas.json", Config::JSON, ["Arenas" => []]);
		$cfg->set($data["name"], $data);
		$cfg->save();
		$this->unload($arena);
	}

	static function unload(Arena $arena){
		$this->plugin->getLogger()->info(TextFormat::YELLOW . "Unloading Arena " . $arena->getName() . "...");
		foreach($arena->getPlayers() as $p){
			$p->sendMessage($this->plugin->prefix . "Forced Arena Unload!");
			$p->teleport($this->plugin->getDefaultLevel()->getSafeSpawn());
		}
	}
}