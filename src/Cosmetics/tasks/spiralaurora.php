<?php

namespace Cosmetics\tasks;

use pocketmine\color\Color;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacketV1;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacketV1;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\particle\DustParticle;
use pocketmine\world\particle\PortalParticle;

class spiralaurora extends Task {
    private $player;
    private $radius;
    private $height;
    private $particlesPerCircle;
    private $currentTick;
    private $rotationSpeed;

    public function __construct(Player $player, float $radius, float $height, int $particlesPerCircle, int $rotationSpeed) {
        $this->player = $player;
        $this->radius = $radius;
        $this->height = $height;
        $this->particlesPerCircle = $particlesPerCircle;
        $this->currentTick = 0;
        $this->rotationSpeed = $rotationSpeed;
    }

    public function onRun() : void {
        $this->currentTick++;
        $yaw = $this->currentTick * $this->rotationSpeed; // Adjust the rotation speed

        $playerPosition = $this->player->getPosition();
        $playerRotation = $this->player->getLocation()->getYaw();

        $swordItem = $this->player->getInventory()->getItemInHand();
        $swordPos = $playerPosition->add(0, $this->height, 0); // Adjust the height offset

        if ($swordItem !== null) {
            $playerRotation += $yaw; // Rotate the particles around the sword based on the current tick
        }

        $angle = 360 / $this->particlesPerCircle;
        $totalHeight = $this->height + $this->radius;

        for ($i = 0; $i < $this->particlesPerCircle; $i++) {
            $theta = deg2rad($angle * $i);
            $x = $swordPos->getX() + ($this->radius * cos($theta));
            $y = $swordPos->getY() + ($totalHeight * ($i / $this->particlesPerCircle));
            $z = $swordPos->getZ() + ($this->radius * sin($theta));
            $particlePos = new Vector3($x, $y, $z);

            // Calculate the particle color dynamically
            $r = $i < ($this->particlesPerCircle / 2) ? 165 : 116; // Upper particles: 165, Lower particles: 116
            $g = $i < ($this->particlesPerCircle / 2) ? 41 : 95; // Upper particles: 41, Lower particles: 95
            $b = $i < ($this->particlesPerCircle / 2) ? 255 : 248; // Upper particles: 255, Lower particles: 248

            // Calculate the visibility of the particle
            $isVisible = ($this->currentTick % $this->particlesPerCircle) >= $i;

            // Create a new particle with the calculated color and visibility
            $effect = new DustParticle(new Color($r, $g, $b), $isVisible);
            $this->player->getWorld()->addParticle($particlePos, $effect);
        }
    }
}