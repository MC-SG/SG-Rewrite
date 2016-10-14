<?php
namespace SurvivalGames\ArenaManager;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use SurvivalGames\SurvivalGames;

class ArenaManager extends PluginBase{

	public static function save(Arena $arena){
		$arena->plugin->getLogger()->info(TextFormat::YELLOW . "Saving arena " . $arena->getName() . "...");
		$data = ["name" => $arena->getName(), "starttime" => 30, "gametime" => 780];
		$cfg = new Config($arena->plugin->getDataFolder() . "/arenas.json", Config::JSON, ["Arenas" => []]);
		$cfg->setNested("Arenas." . $data["name"], $data);
		$cfg->save();
		ArenaManager::unload($arena);
	}

	public static function unload(Arena $arena){
		$arena->plugin->getLogger()->info(TextFormat::YELLOW . "Unloading arena " . $arena->getName() . "...");
		foreach($arena->getLevel()->getPlayers() as $p){
			$p->sendMessage($arena->plugin->prefix . "Forced Arena Unload!");
			$p->teleport($arena->plugin->getDefaultLevel()->getSafeSpawn());
		}
	}
}