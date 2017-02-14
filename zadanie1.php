<?php
// calculating points given by soldier
function calculateSoldierStrength($soldier, $isNegative, $searchedValue)
{
    // converting input to array with zeros and ones
    $binSoldier = decbin($soldier);
    $binSoldierArray = array_map('intval',  str_split($binSoldier));

    // calculating total amount of points given by soldier
    $result = 0;
    foreach($binSoldierArray as $point) {
        if ($point === $searchedValue) {
            $result++;
        }
    }

    // checking if soldier is a spy
    if($isNegative) {
        return -$result;
    }

    return $result;
}

// calculating points given by an army
function calculateResult($soldiers)
{
    // initial values for sides results
    $oddsResult = 0;
    $evensResult = 0;

    foreach($soldiers as $soldier) {
        // checking if soldier is a spy
        $isNegative = ($soldier<0) ? true : false;
        // defining param fo calculateSoldierStrength(), 0 - even soldier, 1 - odd soldier
        $searchedValue = ($soldier%2 === 0) ? 0 : 1;

        $soldierPoints = calculateSoldierStrength($soldier, $isNegative, $searchedValue);

        // increasing total result of soldier allies
        if($searchedValue) {
            $evensResult += $soldierPoints;
        } else {
            $oddsResult += $soldierPoints;
        }

        return [
            'evens' => $evensResult,
            'odds' => $oddsResult
        ];
    }
}

// determining which side of conflict is the winner and returning proper text
function battle($soldiers)
{
    $result = calculateResult($soldiers);

    if($result['odds'] > $result['evens']) {
        return "Odds win!";
    } elseif($result['odds'] < $result['evens']) {
        return "Evens win!";
    }

    return "Tie!";
}

// array with soldiers who participate in battle
$soldiers = [5, 3, 14];

// returning proper text
echo battle($soldiers);
