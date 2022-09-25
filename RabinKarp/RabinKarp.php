<?php
CONST PRIME_NUMBER = 20999999;

function string_search($text, $string)
{
    $window_len = mb_strlen($string) - 1;
    $x = rand(1, $window_len);
    $string_hash = get_hash_string($string, $x);
    $result_index_ranges = [];
    $x_pow_max = make_operation_with_mod('^', $x, $window_len);

    $hash_arr = [
        0 => get_hash_string(mb_substr($text, mb_strlen($text) - mb_strlen($string)), $x)
    ];

    if ($hash_arr[0] === $string_hash) {
        $result_index_ranges[] = [mb_strlen($text) - mb_strlen($string), mb_strlen($text) - 1];
    }

    for ($i = mb_strlen($text) - mb_strlen($string), $new_hash_last_element_inx = mb_strlen($text) - 2, $prev_hash_inx = 0; $i > 0; $i--, $new_hash_last_element_inx--, $prev_hash_inx++) {
        $prev_hash_last_element = make_operation_with_mod('*', mb_ord(mb_substr($text, $new_hash_last_element_inx + 1, 1)), $x_pow_max);
        $prev_hash_without_last_element = make_operation_with_mod('-', $hash_arr[$prev_hash_inx], $prev_hash_last_element);
        $prev_hash_with_modify_degree = make_operation_with_mod('*', $prev_hash_without_last_element, $x);
        $new_hash_first_element = make_operation_with_mod('*', mb_ord(mb_substr($text, $new_hash_last_element_inx - $window_len, 1)) , 1);
        $hash_arr[] = make_operation_with_mod('+', $prev_hash_with_modify_degree, $new_hash_first_element);

        if ($hash_arr[count($hash_arr) - 1] === $string_hash) {
            $result_index_ranges[] = [$new_hash_last_element_inx - $window_len, $new_hash_last_element_inx];
        }
    }

    for ($i = 0, $iMax = count($result_index_ranges); $i < $iMax; $i++) {
        if ($result_index_ranges[$i][0] === null || $result_index_ranges[$i][1] === null) {
            continue;
        }

        for($j = $result_index_ranges[$i][0], $windowInx = 0; $j <= $result_index_ranges[$i][1]; $j++, $windowInx++) {
            if (mb_substr($text, $j , 1) !== mb_substr($string, $windowInx , 1)) {
                unset($result_index_ranges[$i]);
                break;
            }
        }
    }

    return $result_index_ranges;
}

function get_hash_string($sting, $x) {
    $result = 0;

    for ($i = 0, $exponent = 0; $i < mb_strlen($sting); $i++, $exponent++) {
        $x_pow = make_operation_with_mod('^', $x, $exponent);
        $hash_part = make_operation_with_mod('*', mb_ord(mb_substr($sting, $i, 1)), $x_pow);
        $result = make_operation_with_mod('+', $hash_part, $result);
    }

    return $result;
}

function make_operation_with_mod($operation, $operand_1, $operand_2)
{
    $result = [];

    switch ($operation) {
        case '+':
            $result = gmp_strval(gmp_mod($operand_1 + $operand_2, PRIME_NUMBER));
            break;
        case '-':
            $result = gmp_strval(gmp_mod($operand_1 - $operand_2, PRIME_NUMBER));
            break;
        case '/':
            $result = gmp_strval(gmp_mod($operand_1 / $operand_2, PRIME_NUMBER));
            break;
        case '*':
            $result = gmp_strval(gmp_mod($operand_1 * $operand_2, PRIME_NUMBER));
            break;
        case '^':
            $result = gmp_strval(gmp_mod(pow($operand_1, $operand_2), PRIME_NUMBER));
            break;
    }

    return $result;
}

$search_result = string_search('Как я ни боялся щекотки, я не вскочил с постели и не отвечал ему, а только глубже запрятал голову под подушки, 
изо всех сил брыкал ногами и употреблял все старания удержаться от смеха.', 'боялся щекотки');
var_dump($search_result);