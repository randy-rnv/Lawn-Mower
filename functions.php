<?php

/**
 * Return the coordinates of the upper right corner
 */
function getUpperRightCornerPos($file){
    $i = 0;
    $upperRightCornerPos;

    // open the file
    $canal = fopen($file, "r");

    // recovery of the first line of the file
    while(!feof($canal) && $i == 0){
        $line                   = fgets($canal);
        $upperRightCornerPos    = explode(" ", $line);

        $i++;
    }

    return $upperRightCornerPos;
}

/**
 * return the positions that make the line for top and bottom of the rectangle
 */
function getHorizontalLimits($minX, $maxX, $y){
    // all limits position for bottom
    $limits = [];

    for($i=$minX; $i<=$maxX; $i++){
        $position = "$i $y";
        $limits[] = $position;
    }

    return $limits;
}

/**
 * return the positions that make the line for left and right of the rectangle
 */
function getVerticalLimits($minY, $maxY, $x){
    // all limits position for bottom
    $limits = [];

    for($i=$minY; $i<=$maxY; $i++){
        $position = "$x $i";
        $limits[] = $position;
    }

    return $limits;
}

/**
 * return the position of the mower in an array
 */
function getMowerPos($line){
    $mowerPos = explode(" ", $line);
    return $mowerPos;
}

/**
 * change the orientation of the mower
 */
function turnGrassMower($rotate, $orientation){
    switch($rotate){
        case "G":
           $newOrientation = rotateToLeft($orientation);
           break;
        case "D":
            $newOrientation = rotateToRight($orientation);
            break;
    }

    return $newOrientation;
}

/**
 * when the next action is "G"
 */
function rotateToLeft($orientation){
    switch($orientation){
        case "N":
            $newOrientation = "W";
            break;
        case "E":
            $newOrientation = "N";
            break;
        case "W":
            $newOrientation = "S";
            break;
        case "S":
            $newOrientation = "E";
            break;
    }

    return $newOrientation;
}

/**
 * when the next action is "D"
 */
function rotateToRight($orientation){
    switch($orientation){
        case "N":
            $newOrientation = "E";
            break;
        case "E":
            $newOrientation = "S";
            break;
        case "W":
            $newOrientation = "N";
            break;
        case "S":
            $newOrientation = "W";
            break;
    }

    return $newOrientation;
}

function getNextAction($allActions, $posLastAction){
    $nextAction = substr($allActions, $posLastAction, 1);

    return trim($nextAction);
}

/**
 * change mower's position in vertical axis Y
 */
function changeYPosition($currentX, $currentY, $orientation, $bottomLimits, $topLimits){
    $currentMowerPosition = "$currentX $currentY";
    switch($orientation){
        case "N":
            if(in_array($currentMowerPosition, $topLimits)){
                $nextY = $currentY;
            }else{
                $nextY = intval($currentY) + 1;
            }
            break;
        case "S":
            if(in_array($currentMowerPosition, $bottomLimits)){
                $nextY = $currentY;
            }else{
                $nextY = intval($currentY) - 1;
            }
            break;
    }

    return $nextY;
}

/**
 * change mower's position in horizontal axis X
 */
function changeXPosition($currentX, $currentY, $orientation, $leftLimits, $rightLimits){
    $currentMowerPosition = "$currentX $currentY";
    switch($orientation){
        case "W":
            if(in_array($currentMowerPosition, $leftLimits)){
                $nextX = $currentX;
            }else{
                $nextX = intval($currentX) - 1;
            }
            break;
        case "E":
            if(in_array($currentMowerPosition, $rightLimits)){
                $nextX = $currentX;
            }else{
                $nextX = intval($currentX) + 1;
            }
            break;
    }

    return $nextX;
}










