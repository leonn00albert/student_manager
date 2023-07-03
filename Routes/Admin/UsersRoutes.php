<?php
namespace Routes\Admin;
class UsersRoutes
{
    static function register($app,$controller)
    {
        $app->get("/admin/users/:id/edit", $controller->showEdit);
        $app->get("/admin/users/:id/delete", $controller->delete);
        $app->get("/admin/users",$controller->showIndex);
        $app->put("/users/:id", $app->form->sanitize, $controller->update);
    }
}