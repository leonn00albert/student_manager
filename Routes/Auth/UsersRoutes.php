<?php
namespace Routes\Auth;
class UsersRoutes
{
    static function register($app,$controller)
    {
        $app->post("/users",$app->form->sanitize, $controller->register);
  
    }
}