<?php
function getValues($path)
{
    $input = fopen($path, "r");
    if ($input) {
        $i = -1;
        $j = 0;
        $terrains = [];
        $sizes = [];
        while (($line = fgets($input)) !== false) {
            $clearedLine =  preg_replace('/\s+/', '',$line);
            if(strlen($clearedLine)===1) {
                $i++;
                $j = 0;
                $size = intval($clearedLine);
                $sizes[] = $size;
            } else {
                $myArray = explode(',', $clearedLine);
                $myArr = array_map('intval', $myArray);
                $terrains[$i][$j] = $myArr;
                $j++;
            }
        }
    fclose($input);

    return [
      'sizes' => $sizes,
      'terrains' => $terrains
    ];

    } else {
        return 'Error opening the file.';
    }
}

function getConsumedEnergy($sizes, $terrains)
{
    $energies = [];
    foreach($sizes as $index => $size) {
        $i = 0;
        $j = 0;
        $terrain = $terrains[$index];
        $energy = $terrain[$i][$j];

        while($i < $size || $j < $size) {
            $horrizontal = $terrain[$i][$j+1];
            $vertical = $terrain[$i+1][$j];

            if((!is_null($horrizontal) && $horrizontal <= $vertical && $j+1 < $size)) {
                $energy += $horrizontal;
                $j++;
            } elseif(!is_null($vertical) && $i+1 < $size) {
                $energy += $vertical;
                $i++;
            } elseif((is_null($vertical) && !is_null($horrizontal) && $j+1 < $size)) {
                $energy += $horrizontal;
                $j++;
            }  else {
                $i=$size;
                $j=$size;
            }
        }
        $energies[] = $energy;
    }
    return $energies;
}

$array = getValues('./file.txt');

getConsumedEnergy($array['sizes'], $array['terrains']);
