<?php
// class to help print order
class PrintPack
{
    public $size;
    public $quantity;
}

// class to calculate Widget orders
class Widget
{
    // available pack sizes
    const packSizes = [250,500,1000,2000,5000];
    // index for packs sizes
    private $packIndex = 0;
    // store number of widgets ordered
    private $noOfWidgets = 0;

    // gets required packs and prints order
    public function processOrder($noOfWidgets)
    {
        // set global variables
        $this->packIndex = count(self::packSizes)-1;
        $this->noOfWidgets = $noOfWidgets;
        // calculate number of packs to send out
        $packsToSend = $this->getPacksForOrder($noOfWidgets);
        // print order
        $this->printOrder($packsToSend);
    }

    // calculates number of packs to send out
    private function getPacksForOrder($noOfWidgets)
    {
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
            // while we have widgets to supply
            while($noOfWidgets > 0){ 
                // while widgets to supply is lower than current pack size
                while($noOfWidgets < self::packSizes[$this->packIndex]){
                    // go to next pack size down
                    $this->packIndex--;
                }
                // if we go past lowest pack size
                if($this->packIndex < 0){
                    // make sure we stay on lowest pack size
                    $this->packIndex = 0;
                }

                // add pack to order
                $packsToSend[] = self::packSizes[$this->packIndex];
                // remove packs added to order from number of widgets to supply
                $noOfWidgets = $noOfWidgets - self::packSizes[$this->packIndex];
            }
        }

        // return full order
        return $packsToSend;
    }

    // formats and prints order
    private function printOrder($packsToSend)
    {
        // set up variables
        $packsForPrint = [];
        $prevPack = "";

        // for each pack
        foreach($packsToSend as $pack){
            // create print pack
            $printPack = new PrintPack;
            // add size and quantity
            $printPack->size = $pack;
            $printPack->quantity = 1;
            
            // if pack size is the same as previous pack
            if($pack == $prevPack->size){
                // update quantity
                $prevPack->quantity++;
            }else{
                // otherwise, add print pack to formatted order
                $packsForPrint[] = $printPack;
            }

            // set previous pack
            $prevPack = $printPack;
        }

        // print order summary
        echo "Your order of ".$this->noOfWidgets." widgets contains the following packs:<br>";
        foreach($packsForPrint as $packs){
            echo $packs->quantity." x ".$packs->size."<br>";
        }
        echo "<br>";
    }
}

$widget = new Widget;
$widget->processOrder(1);
$widget->processOrder(250);
$widget->processOrder(251);
$widget->processOrder(501);
$widget->processOrder(12001);
$widget->processOrder(876);
$widget->processOrder(4532);
?>