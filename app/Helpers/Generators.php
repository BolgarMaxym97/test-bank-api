<?php
/**
 * Created by IntelliJ IDEA.
 * User: Max00766
 * Date: 15.05.2019
 * Time: 21:55
 */

namespace App\Helpers;


use App\Models\Card;

class Generators
{
    public static function creditCardNumber()
    {
        $number = '';
        for ($i = 0; $i < Card::NUMBER_LENGTH; $i++) {
            $number .= rand(1, 9);
        }
        return (int)$number;
    }
}
