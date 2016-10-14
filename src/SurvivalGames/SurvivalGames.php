<?php
namespace SurvivalGames;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use SurvivalGames\ArenaManager\Arena;

class SurvivalGames extends PluginBase implements Listener{

	static $arenas = [];

	protected $arenacount = 0;

	public $prefix = TextFormat::GRAY . "[" . TextFormat::RED . "SG" . TextFormat::GRAY . "]";

	public function onLoad()
	{
		$this->getLogger()->info(TextFormat::YELLOW . "Initilizing Startup...");
	}

	public function onEnable()
	{
		@mkdir($this->getDataFolder());
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$cfg = new Config($this->getDataFolder() . "/arenas.json", Config::JSON, ["Arenas" => []]);
		foreach($cfg->get("Arenas") as $arena){
			$arena2 = new Arena($this, $arena);
			array_push(static::$arenas, $arena2);
			$this->arenacount++;
			$this->getServer()->loadLevel($arena2->getName());
		}
		$this->getLogger()->info(TextFormat::AQUA . "Successfully loaded " . $this->arenacount . " arenas!");
		$this->prefix = $this->getConfig()->get("Prefix") . " ";
	}

	public function onDisable()
	{
		$this->getConfig()->save();
		foreach(static::$arenas as $arena){
			$arena->reset();
			$arena->save();
		}
	}
}