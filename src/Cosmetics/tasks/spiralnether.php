<?php

namespace Cosmetics\tasks;
use pocketmine\color\Color;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacketV1;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacketV1;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\particle\PortalParticle;

class spiralnether extends Task {
    private $player;
    private $radius;
    private $height;
    private $particlesPerCircle;
    private $currentTick;

    public function __construct(Player $player, float $radius, float $height, int $particlesPerCircle) {
        $this->player = $player;
        $this->radius = $radius;
        $this->height = $height;
        $this->particlesPerCircle = $particlesPerCircle;
        $this->currentTick = 0;
    }

    public function onRun() : void {
        $this->currentTick++;
        $yaw = $this->currentTick * 4; // Adjust the rotation speed
    
        $playerPosition = $this->player->getPosition();
        $playerRotation = $this->player->getLocation()->getYaw();
    
        $swordItem = $this->player->getInventory()->getItemInHand();
        $swordPos = $playerPosition->add(0, $this->height, 0); // Adjust the height offset
    
        if ($swordItem !== null) {
            $playerRotation += $yaw; // Rotate the particles around the sword based on the current tick
        }


        
        $angle = 360 / $this->particlesPerCircle;
    
        for ($i = 0; $i < $this->particlesPerCircle; $i++) {
            $theta = deg2rad($angle * $i);
            $x = $swordPos->getX() + ($this->radius * cos($theta));
            $z = $swordPos->getZ() + ($this->radius * sin($theta));
            $particlePos = new Vector3($x, $swordPos->getY(), $z);
            $effect = new PortalParticle(new Color(80, 238, 255));
            $this->player->getWorld()->addParticle($particlePos, $effect);
        }
    
    }
    
}
