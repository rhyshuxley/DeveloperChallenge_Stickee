<?php
class Widget{
    // available pack sizes
    const packSizes = [250,500,1000,2000,5000];
    // index for packs sizes
    private $packIndex = 0;
    private $noOfWidgets = 0;

    public function processOrder($noOfWidgets){
        $this->packIndex = count(self::packSizes)-1;
        $this->noOfWidgets = $noOfWidgets;
        $packsToSend = $this->getPacksForOrder($noOfWidgets);
        $this->printOrder($packsToSend);
    }

    private function getPacksForOrder($noOfWidgets){
        // array of pack sizes to fulfill order
        $packsToSend = [];
        
        // if order is below the second pack size
        if($noOfWidgets <= self::packSizes[1]){
            // if order is below the first pack size
            if($noOfWidgets <= self::packSizes[0]){
                // send out first pack size
                $packsToSend[] = self::packSizes[0];
            }else{
                // else send out second pack size
                $packsToSend[] = self::packSizes[1];
            }
        }else{
            $leftOverWidgets = $noOfWidgets;
            while($leftOverWidgets > 0){             
                if($this->packIndex == -1){
                    $this->packIndex = 0;
                }   
                while($leftOverWidgets < self::packSizes[$this->packIndex]){
                    $this->packIndex--;
                }
                if($this->packIndex < 0){
                    $this->packIndex = 0;
                }
                $packsToSend[] = self::packSizes[$this->packIndex];
                $leftOverWidgets = $leftOverWidgets - self::packSizes[$this->packIndex];
            }
        }

        return $packsToSend;
    }

    private function printOrder($packsToSend){
        $packsForPrint = [];
        $prevPack = "";

        foreach($packsToSend as $pack){
            
            $printPack = new stdClass;
            $printPack->size = $pack;
            $printPack->quantity = 1;

            if($pack == $prevPack){
                $printPack->quantity++;
            }

            $packsForPrint[] = $printPack;
            $prevPack = $pack;
        }

        echo "Your order of ".$this->noOfWidgets." widgets contains the following packs:<br>";

        foreach($packsForPrint as $packs){
            echo $packs->quantity." x ".$packs->size."<br>";
        }
    }
}

$widget = new Widget;
$widget->processOrder(1);
$widget->processOrder(250);
$widget->processOrder(251);
$widget->processOrder(501);
$widget->processOrder(12001);
?>