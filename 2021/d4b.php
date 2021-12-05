<?php

$lines = file("input/d4.txt", FILE_IGNORE_NEW_LINES);

$drawn_numbers = explode(",", array_shift($lines));

$boards = [];
for ($i = 0; $i < count($lines); $i+=6) {
    $board = [
        "values" => [],
        "rows" => array_fill(0, 5, []),
        "columns" => array_fill(0, 5, []),
    ];
    for ($j = 0; $j < 5; $j++) {
        $row = preg_split("/ +/", trim($lines[$i + $j + 1]));
        foreach ($row as $k => $num) {
            $num_int = intval($num);
            array_push($board["values"], $num_int);
            array_push($board["rows"][$j], $num_int);
            array_push($board["columns"][$k], $num_int);
        }
    }
    array_push($boards, $board);
}

function mark_num_on_board_and_check_if_winner($num, &$board): bool {
    delete_value_from_array($num, $board["values"]);
    for ($i = 0; $i < 5; $i++) {
        delete_value_from_array($num, $board["rows"][$i]);
        delete_value_from_array($num, $board["columns"][$i]);
        if (count($board["rows"][$i]) == 0 || count($board["columns"][$i]) == 0) {
            return true;
        }
    }
    return false;
}

function delete_value_from_array($value, &$array) {
    if (($key = array_search($value, $array)) !== false) {
        unset($array[$key]);
    }
}

$remaining_boards = array_keys($boards);
$final_board = -1;
$final_number = -1;
while (count($drawn_numbers) > 0) {
    $num = intval(array_shift($drawn_numbers));
    for($b = 0; $b < count($boards); $b++) {
        if (!in_array($b, $remaining_boards)) {
            continue;
        }
        $is_winner = mark_num_on_board_and_check_if_winner($num, $boards[$b]);
        if ($is_winner){
            unset($remaining_boards[$b]);
        }
        if (count($remaining_boards) == 0) {
            $final_board = $b;
            $final_number = $num;
            break 2;
        }
    }
}

if ($final_board >= 0) {
    print("FINAL BINGO! Board {$final_board}: \n");
    $sum = array_sum($boards[$final_board]["values"]);
    $value = $sum * $final_number;
    print("Board value: {$sum} * {$final_number} = {$value}\n");
} else {
    echo "no found board\n";
}
