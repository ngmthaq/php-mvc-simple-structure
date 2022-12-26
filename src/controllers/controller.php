<?php

abstract class Controller
{
    private $auth;
    private $remember;

    public function __construct()
    {
        $this->auth = array_key_exists(AUTH_KEY, $_COOKIE) ? $_COOKIE[AUTH_KEY] : "";
        $this->remember = array_key_exists(AUTH_REMEMBER_KEY, $_COOKIE) ? $_COOKIE[AUTH_REMEMBER_KEY] : "";
    }

    final protected function getAuth(): string
    {
        if ($this->remember === "1") {
            setcookie(AUTH_REMEMBER_KEY, "1", time() + 360000, "/");
            setcookie(AUTH_KEY, $this->auth, time() + 360000, "/");
        }

        return $this->auth;
    }

    final protected function setAuth(string $userId, bool $remember): void
    {
        setcookie(AUTH_REMEMBER_KEY, $remember ? "1" : "", time() + 360000, "/");
        setcookie(AUTH_KEY, $userId, time() + 360000, "/");
        $this->auth = $userId;
        $this->remember = $remember ? "1" : "";
    }

    final protected function removeAuth(): void
    {
        unset($_COOKIE[AUTH_KEY]);
        unset($_COOKIE[AUTH_REMEMBER_KEY]);
        $this->auth = "";
        $this->remember = "";
    }
}
