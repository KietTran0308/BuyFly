<?php

namespace BuyFly;

use pocketmine\command\{CommandSender, Command};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\{Server, Player};

use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent};

class Main extends PluginBase implements Listener{

        public function onEnable(){
            $this->getLogger()->info("\n\n§a§lPlugin Đã Hoạt Động\n\n");
            $this->Eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
            $this->getServer()->getPluginManager()->registerEvents($this, $this);
        }

        public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool {
            switch($cmd->getName()){
                case "buyfly":
                    $name = $sender->getName();
                    $mymoney = $this->Eco->myMoney($sender);
                    $cost = 50000; // Đổi 50000 Thành Số Tiền Bạn Mún :33
                    if($mymoney < $cost) { 
                        $sender->sendPopup("§cBạn Không Đủ Tiền Để Mua. Giá Fly Là §a$cost");
                    }else{
                        $sender->sendMessage("§bBạn Đã Mua Fly Thành Công");
                        $sender->setAllowFlight(TRUE);
                        $this->Eco->reduceMoney($name, $cost);
                    }
                    return true;
            }
        }
        
        public function JoinEvent(PlayerJoinEvent $ev){
            $sender = $ev->getPlayer();
            $sender->setAllowFlight(FALSE);
        }
        
        public function LeaveEvent(PlayerQuitEvent $ev){
            $sender = $ev->getPlayer();
            $sender->setAllowFlight(FALSE);
        }
}