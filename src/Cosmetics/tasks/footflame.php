<?php

namespace Cosmetics\tasks;
use pocketmine\color\Color;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacketV1;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacketV1;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\particle\FlameParticle;

class  footflame extends Task {
    private $player;
    private $flameCount;

    public function __construct(Player $player, int $flameCount =210) {
        $this->player = $player;
        $this->flameCount = $flameCount;
    }

    public function onRun() : void {
        $playerPosition = $this->player->getPosition();
        $playerFeetPos = $playerPosition->add(0, 0.2, 0); // Player's feet position

        for ($i = 0; $i < $this->flameCount; $i++) {
            $randomX = mt_rand(-5, 5) * 0.1; // Random X offset (-0.5, 0, 0.5)
            $randomZ = mt_rand(-5, 5) * 0.1; // Random Z offset (-0.5, 0, 0.5)

            $particlePos = $playerFeetPos->add($randomX, 0, $randomZ); // Random offset around player's feet

            $effect = new FlameParticle();
            $this->player->getWorld()->addParticle($particlePos, $effect);
        }
    }
}
