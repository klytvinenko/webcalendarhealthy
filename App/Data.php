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
    
    public static $mealtimes = [
        [
            "id" => "breakfast",
            "title" => "Сніданок"
        ],
        [
            "id" => "snack1",
            "title" => "Ранковий перекус"
        ],
        [
            "id" => "lunch",
            "title" => "Обід"
        ],
        [
            "id" => "snack2",
            "title" => "Після обідній перекус"
        ],
        [
            "id" => "dinner",
            "title" => "Вечеря"
        ],
    ];
    /**
     * Print array
     *
     * */
    public static function pa(array $array)
    {
        echo "<pre>";
        var_dump($array);
        echo "<pre>";
        exit;
    }
    /**
     * Print $_POST data
     *
     * */
    public static function pp()
    {
        echo "<pre>";
        var_dump($_POST);
        echo "<pre>";
        exit;
    }
    /**
     * Print $_GET data
     *
     * */
    public static function pg()
    {
        echo "<pre>";
        var_dump($_GET);
        echo "<pre>";
        exit;
    }
    /**
     * Print $_SESSION data
     *
     * */
    public static function ps()
    {
        echo "<pre>";
        var_dump($_SESSION);
        echo "<pre>";
        exit;
    }
    /**
     * Print text
     *
     * */
    public static function pt($text)
    {
        echo "<pre>";
        var_dump($text);
        echo "<pre>";
        exit;
    }

    public static function today($withTime=false)
    {
        if($withTime) return date("Y-m-d H:m");
        else return date("Y-m-d");
    }

    public static function getTime($date)
    {
        return date('Y-m-d', timestamp: strtotime($date));
    }

    public static function getDate($date)
    {
        return date('H:m', timestamp: strtotime($date));
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
    public static function calcProcent($procents, $full_value)
    {
        return round(($procents * $full_value) / 100, 2);
    }
    public static function randBool()
    {
        return (bool)random_int(0, 1);
    }
    //from stack overflow: https://stackoverflow.com/questions/41669246/how-to-write-own-dd-function-same-as-laravel
    public static function d($data){
        if(is_null($data)){
            $str = "<i>NULL</i>";
        }elseif($data == ""){
            $str = "<i>Empty</i>";
        }elseif(is_array($data)){
            if(count($data) == 0){
                $str = "<i>Empty array.</i>";
            }else{
                $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
                foreach ($data as $key => $value) {
                    $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . self::d($value) . "</td></tr>";
                }
                $str .= "</table>";
            }
        }elseif(is_resource($data)){
            while($arr = mysql_fetch_array($data)){
                $data_array[] = $arr;
            }
            $str = self::d($data_array);
        }elseif(is_object($data)){
            $str = self::d(get_object_vars($data));
        }elseif(is_bool($data)){
            $str = "<i>" . ($data ? "True" : "False") . "</i>";
        }else{
            $str = $data;
            $str = preg_replace("/\n/", "<br>\n", $str);
        }
        return $str;
    }
    
    public static function dnl($data){
        echo self::d($data) . "<br>\n";
    }
    
    public static function dd($data){
        echo self::dnl($data);
        exit;
    }
    
    public static function ddt($message = ""){
        echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
    }
}
