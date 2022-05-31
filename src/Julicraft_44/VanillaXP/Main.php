<?php
namespace Julicraft_44\VanillaXP;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;

class Main extends PluginBase {
//Sorry, very messy code, will clean up later 
    public function onEnable(): void {
        $this->saveDefaultConfig();
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool {
        if($cmd->getName() == "xp") {
            if(!$sender->hasPermission("vanillaxp.cmd")) {
                $sender->sendMessage($this->getConfig()->get("no-permission"));
                return false;
            }
            if(!isset($args[0])) {
                $sender->sendMessage($this->getConfig()->get("syntax-error"));
                return false;
            }
            if( str_contains($args[0], "L")) {
                $level = $args[0];
                $level = str_replace("L", "", $level);
                $level = intval($level, 0);
                    
                if(isset($args[1])) {
                    $target = $this->getServer()->getPlayerExact($args[1]);
                    if($target === null || !in_array($target, $this->getServer()->getOnlinePlayers())) {
                        $sender->sendMessage($this->getConfig()->get("player-not-found"));
                        return false;
                    }
                    $this->setXpLevel($level, $sender, $target);
                } else {
                    $this->setXpLevel($level, $sender);
                }
            } else {
                $level = $args[0];
                if(isset($args[1])) {
                    $target = $this->getServer()->getPlayerExact($args[1]);
                    if($target === null || !in_array($target, $this->getServer()->getOnlinePlayers())) {
                        $sender->sendMessage($this->getConfig()->get("player-not-found"));
                        return false;
                    }
                    $this->setXp($level, $sender, $target);
                } else {
                    $this->setXp($level, $sender);
                }
            }
        }
        return true;
    }
    
    public function setXpLevel(int $level, Player $sender, Player $target = null) {
        if($target == null) {
            if($level < 0) {
                if($sender->getXpManager()->getXpLevel() - abs($level) < 0) {
                    $sender->getXpManager()->setXpAndProgress(0, 0.0);
                    $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), abs($level)], $this->getConfig()->get("substract-xp-level")));
                    return;
                }
                $sender->getXpManager()->subtractXpLevels(abs($level));
                $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), abs($level)], $this->getConfig()->get("substract-xp-level")));
            } else {
                if($sender->getXpManager()->getXpLevel() + $level >= 24791) {
                    $sender->getXpManager()->setXpLevel(24790);
                    $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), $level], $this->getConfig()->get("add-xp-level")));
                    return;
                }
                $sender->getXpManager()->addXpLevels($level);
                $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), $level], $this->getConfig()->get("add-xp-level")));
            }
        } else {
            if($level < 0) {
                if($target->getXpManager()->getXpLevel() - abs($level) < 0) {
                    $target->getXpManager()->setXpAndProgress(0, 0.0);
                    $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), abs($level)], $this->getConfig()->get("substract-xp-level")));
                    return;
                }
                $target->getXpManager()->subtractXpLevels(abs($level));
                $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), abs($level)], $this->getConfig()->get("substract-xp-level")));
                
            } else {
                if($target->getXpManager()->getXpLevel() + $level >= 24791) {
                    $target->getXpManager()->setXpLevel(24790);
                    $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), $level], $this->getConfig()->get("add-xp-level")));
                    return;
                }
                $target->getXpManager()->addXpLevels($level);
                $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), $level], $this->getConfig()->get("add-xp-level")));
            }
        }
    }
    
    public function setXp(int $xp, Player $sender, Player $target = null) {
        if($target == null) {
            if($xp < 0) {
                if($sender->getXpManager()->getCurrentTotalXp() - abs($xp) < 0) {
                    $sender->getXpManager()->setXpAndProgress(0, 0.0);
                    $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), abs($xp)], $this->getConfig()->get("substract-xp-level")));
                    return;
                }
                $sender->getXpManager()->subtractXp(abs($xp));
                $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), abs($xp)], $this->getConfig()->get("substract-xp")));
                
            } else {
                if($sender->getXpManager()->getCurrentTotalXp() + $xp >= 24791) {
                    $sender->getXpManager()->setXpLevel(24790);
                    $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), $xp], $this->getConfig()->get("add-xp-level")));
                    return;
                }
                $sender->getXpManager()->addXp($xp);
                $sender->sendMessage(str_replace(["%target", "%amount"], [$sender->getName(), $xp], $this->getConfig()->get("add-xp")));
            }
        } else {
            if($xp < 0) {
                if($target->getXpManager()->getCurrentTotalXp() - abs($xp) < 0) {
                    $target->getXpManager()->setXpAndProgress(0, 0.0);
                    $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), abs($xp)], $this->getConfig()->get("substract-xp-level")));
                    return;
                }
                $target->getXpManager()->subtractXp(abs($xp));
                $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), abs($xp)], $this->getConfig()->get("substract-xp")));
                
            } else {
                if($target->getXpManager()->getCurrentTotalXp() + $xp >= 24791) {
                    $target->getXpManager()->setXpLevel(24790);
                    $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), $xp], $this->getConfig()->get("add-xp-level")));
                    return;
                }
                $target->getXpManager()->addXp($xp);
                $target->sendMessage(str_replace(["%target", "%amount"], [$target->getName(), $xp], $this->getConfig()->get("add-xp")));
            }
        }
    }
}

