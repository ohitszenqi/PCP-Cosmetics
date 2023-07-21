<?php

namespace Cosmetics;

use Cosmetics\entities\latom;
use Cosmetics\tasks\footflame;
use Cosmetics\tasks\footflames;
use Cosmetics\tasks\ParticleSpiralTask as TasksParticleSpiralTask;
use Cosmetics\tasks\spiralnether as TasksSpiralnether;
use Cosmetics\tasks\sword;
use ParticleSpiralTask;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\world\particle\FlameParticle;
use spiralnether;

class Main extends PluginBase implements Listener {
    public function onEnable() : void {
        
        $this->getLogger()->info("Cosmetics plugin initialized.");
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $event) {

        $player = $event->getPlayer();

        if ($player->getName() !== "iWaSWhiteBox") {
            return;
        }

        $radius = 1; // Adjust the radius as desired
        $height = 1.0; // Adjust the height as desired
        $particlesPerCircle = 20; // Adjust the number of particles per circle as desired
        $particleSpiralTask = new footflame($player);

        // Get the server's task scheduler
        $taskScheduler = $this->getScheduler();

        // Schedule the task to run every tick (20 ticks per second)
        $taskScheduler->scheduleRepeatingTask($particleSpiralTask, 1); // Adjust the tick delay as desired
    }

    
    
    
    
}