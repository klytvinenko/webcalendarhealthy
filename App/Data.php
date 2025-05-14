<?php

namespace App;

class Data
{
    public static $months_ua = [
        "01" => 'січ',
        "02" => 'лют',
        "03" => 'бер',
        "04" => 'квіт',
        "05" => 'трав',
        "06" => 'черв',
        "07" => 'лип',
        "08" => 'серп',
        "09" => 'вер',
        "10" => 'жовт',
        "11" => 'лист',
        "12" => 'груд',
    ];
    public static $months = [
        "01" => 'Січень',
        "02" => 'Лютий',
        "03" => 'Березень',
        "04" => 'Квітень',
        "05" => 'Травень',
        "06" => 'Червень',
        "07" => 'Липень',
        "08" => 'Серпень',
        "09" => 'Вересень',
        "10" => 'Жовтень',
        "11" => 'Листопад',
        "12" => 'Грудень',
    ];
    public static $week_days_ua = [
        "0" => "нед",
        "1" => "пон",
        "2" => "вівт",
        "3" => "сер",
        "4" => "чет",
        "5" => "п'ят",
        "6" => "суб",
    ];
    public static function pa(array $array)
    {
        echo "<pre>";
        var_dump($array);
        echo "<pre>";
    }
    public static function pp()
    {
        echo "<pre>";
        var_dump($_POST);
        echo "<pre>";
    }
    public static function pg()
    {
        echo "<pre>";
        var_dump($_GET);
        echo "<pre>";
    }
    public static function ps()
    {
        echo "<pre>";
        var_dump($_SESSION);
        echo "<pre>";
    }
    public static function pt($text)
    {
        echo "<pre>";
        var_dump($text);
        echo "<pre>";
    }

    public static function today()
    {
        return date("Y-m-d");
    }
    public static function MySQLError($e, $query = "")
    {
        if ('42S02' != substr($e, 23, 5)) {
            echo "<div style='border: 1px solid brown;font-family: cursive;margin: 5px;padding: 5px;border-radius: 5px; background: mistyrose;color: brown;'>";
            echo "<p>" . $e->getMessage() . "</p>";
            if (!empty($query))
                echo "<b>Query:</b> <i>'" . $query . "'</i>";
            echo "</div>";
        }
    }
    public static function Error($e)
    {
        echo "<div style='border: 1px solid brown;font-family: cursive;margin: 5px;padding: 5px;border-radius: 5px; background: mistyrose;color: brown;'>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "</div>";
    }
    public static function Error404($method, $url)
    {
        http_response_code(404);
        echo "<div style='border: 1px solid brown;font-family: cursive;margin: 5px;padding: 5px;border-radius: 5px; background: mistyrose;color: brown;'>";
        echo "<p>404 Not Found</p>";
        echo "<br>";
        echo "Method: $method";
        echo "<br>";
        echo "URL: $url";
        echo "</div>";
    }
}
