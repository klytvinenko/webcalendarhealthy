<?php

namespace App;

use App\Controllers;
use App\Controllers\MainController;
use Exception;

enum UserType: string
{
    case LOGINED = "LOGINED";
    case ADMIN = "ADMIN";
    case NOTLOGINED = "NOTLOGINED";
}

class Router
{
    private array $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "DELETE" => []
    ];

    public UserType $user_type;

    public function route(string $url, string $method, array $params)
    {
        try {
            if (!empty($_GET) && !empty($_POST)) $method = "PUT";
            $this->middleware($url, $method);
            $event = $this->routes[$method][$url]['action'] ?? null;
            if ($event === null) {
                Data::Error404($method, $url);
                return;
            }
            if ($method == "GET") {
                (new $event[0])->{$event[1]}(!empty($params) ? $params : "");
            } else if ($method == "POST") {
                $event[2] = [];
                if (str_contains($event[1], "API")) {
                    $json = file_get_contents('php://input');
                    $event[2] = json_decode($json, true);
                }
                else $event[2] = $_POST;
                Validate::validate("$event[1]", $event[2]);
                (new $event[0])->{$event[1]}($event[2] ?? "");
            } else if ($method == "PUT") {
                Validate::validate("$event[1]", $_POST);
                $event[2] = $_POST;
                (new $event[0])->{$event[1]}($params, $event[2] ?? "");
            } else if ($method == "DELETE") {
                (new $event[0])->{$event[1]}($params['id']);
            }
        } catch (Exception $e) {
            Data::Error($e);
        }
    }
    public static function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }
    public static function toMain($permanent = false)
    {
        header('Location: ' . "/", true, $permanent ? 301 : 302);
        exit();
    }

    public function middleware(&$url, &$method)
    {
        $pageUserType = $this->routes[$method][$url]['userType'] ?? null;
        if ($pageUserType == null) {
            return;
        }
        if ($this->user_type == UserType::NOTLOGINED && $pageUserType != UserType::NOTLOGINED) {
            self::redirect("/");
        } elseif ($this->user_type == UserType::LOGINED && $pageUserType != UserType::LOGINED) {
            self::redirect("/profile");
        } elseif ($this->user_type == UserType::ADMIN && $pageUserType != UserType::ADMIN) {
            self::redirect("/admin");
        }
    }

    public function checkAuth(): void
    {
        if (!isset($_SESSION['user']))
            $this->user_type = UserType::NOTLOGINED;
        else {
            if ($_SESSION['user']['login'] == 'admin')
                $this->user_type = UserType::ADMIN;
            else
                $this->user_type = UserType::LOGINED;
        }
    }

    public static function getParams(&$url)
    {
        $url_array = explode('?', $url);

        $url = $url_array[0];

        if (isset($url_array[1])) {
            $params = [];

            foreach (explode('&', $url_array[1]) as $param) {
                $param_array = explode('=', $param);
                $params[$param_array[0]] = $param_array[1];
            }

            return $params;
        } else
            return [];
    }

    public function post(string $path, $action, UserType $userType = null): void
    {
        $this->routes["POST"][$path] = [
            "action" => $action,
            "userType" => $userType
        ];
    }
    public function get(string $path, $action, UserType $userType = null): void
    {
        $this->routes["GET"][$path] = [
            "action" => $action,
            "userType" => $userType
        ];
    }
    public function put(string $path, $action, UserType $userType = null): void
    {
        $this->routes["PUT"][$path] = [
            "action" => $action,
            "userType" => $userType
        ];
    }
    public function delete(string $path, $action, UserType $userType = null): void
    {
        $this->routes["DELETE"][$path] = [
            "action" => $action,
            "userType" => $userType
        ];
    }
}
