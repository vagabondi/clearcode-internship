<?php
function getValues($path)
{
    $input = fopen($path, "r");
    if ($input) {
        $i = -1;
        $j = 0;
        $terrains = [];
        while (($line = fgets($input)) !== false) {
            $clearedLine =  preg_replace('/\s+/', '',$line);
            if(strlen($clearedLine)===1) {
                $i++;
                $j = 0;
                $size = intval(strlen($clearedLine));
                $first_one = $terrains[$i];
            } else {
                $myArray = explode(',', $clearedLine);
                $myArr = array_map('intval', $myArray);
                $terrains[$i][$j] = $myArr;
                $j++;
            }
        }
    fclose($input);

    return $terrains;

    } else {

        return 'Error opening the file.';

    }
}

getValues('./file.txt');
