<?php

require_once "functions.php";

$file = "file.txt";

// position of the upper right corner
$upperRightCornerPos    = getUpperRightCornerPos($file);

$upperRightCornerX      = trim($upperRightCornerPos[0]);
$upperRightCornerY      = trim($upperRightCornerPos[1]);

// as the grass has a rectangular surface
// these array will define the limits position for grass mower
$bottomLimits   = getHorizontalLimits(0, $upperRightCornerX, 0);
$topLimits      = getHorizontalLimits(0, $upperRightCornerX, $upperRightCornerY);

$leftLimits     = getVerticalLimits(0, $upperRightCornerY, 0);
$rightLimits    = getVerticalLimits(0, $upperRightCornerY, $upperRightCornerX);

// reading file
$canal  = fopen($file, "r");
// this variable $k will help to skip the first line in the file
// and to check if the current line is odd or pair
$k      = 0;

while(!feof($canal)){
    $line   = fgets($canal);
    
    // this first condition will avoid errors if there are more useless lines at the end of the file
    if(trim($line) != ""){
        // mower's position given by file
        // all odd lines are for mower's position
        if($k>0 && ($k%2 != 0)){
            $pos         = getMowerPos($line);
            $x           = $pos[0];
            $y           = $pos[1];
            $orientation = trim($pos[2]);
        }

        // moving mower
        // all pair lines are for action
        if($k>0 && ($k%2 == 0)){
            $allActions = trim($line);
            $numberOfAction = strlen($allActions);

            for($m=0; $m<$numberOfAction; $m++){
                $nextAction = getNextAction($allActions, $m);

                if($nextAction == "A"){
                    if($orientation == "N" || $orientation == "S"){
                        $y = changeYPosition($x, $y, $orientation, $bottomLimits, $topLimits);

                    }else if($orientation == "W" || $orientation == "E"){
                        $x = changeXPosition($x, $y, $orientation, $leftLimits, $rightLimits);
                    } // if elseif

                }else if($nextAction != "A"){
                    // turning the mower according to $nextAction
                    switch($nextAction){
                        case "G":
                            $orientation = turnGrassMower("G", $orientation);
                            break;
                        case "D":
                            $orientation = turnGrassMower("D", $orientation);
                            break;
                    } // switch
                } // if elseif
            } // for

            $lastMowerPosition = "$x $y $orientation";
            
            echo $lastMowerPosition . "\n";
        }
    }
   
    $k++;
}

