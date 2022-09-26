<?php

use Firebase\JWT\JWT;

class Session
{
    public function __construct(public string $username, public string $role)
    {
    }
}

class SessionManager
{

    public static string $SECRET_KEY = "awfdy8i3q78aid73q8diauwgkawd90y3do34yearigawd";

    public static function login(string $username, string $password):bool
    {
        if ($username == "rachmat" && $password == "rachmat") {

            $payload = [
                "username" => $username,
                "role"     => "customer"
            ];

            $jwt = JWT::encode($payload, SessionManager::$SECRET_KEY, 'HS256');
            setcookie("X-PZN-SESSION", $jwt, httponly:true);
            
            return true;
        }else {
            return false;
        }
    }

    public static function getCurrentSession(): Session
    {
        if ($_COOKIE['X-PZN-SESSION']) {
            $jwt = $_COOKIE['X-PZN-SESSION'];

            try {
                $payload = JWT::decode($jwt, SessionManager::$SECRET_KEY, ['HS256']);
                return new Session(username: $payload->username, role: $payload->role);
            } catch (Exception) {
                throw new Exception("User is not login");
            }
        }else {
            throw new Exception("User is not login");
        }
    }
}