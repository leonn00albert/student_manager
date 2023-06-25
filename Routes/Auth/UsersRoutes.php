<?php
namespace Routes\Auth;
class UsersRoutes
{
    static function register($app,$controller)
    {
        $app->post("/users",$app->form->sanitize, $controller->register);
        $app->post("/login",$app->form->sanitize, $controller->login);
        $app->get("/signout",$app->form->sanitize, $controller->signout);
    }
}