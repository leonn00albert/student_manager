<?php
namespace Routes\Admin;
class ClassroomsRoutes
{
    static function register($app,$controller)
    {
        $app->get("/admin/classrooms", $controller->showIndex);
        $app->get("/admin/classrooms/:id/edit", $controller->showIndex);
        $app->get("/admin/classrooms/:id/delete", $controller->delete);
        $app->post("/classrooms", $app->form->sanitize,$controller->create);
        $app->put("/classrooms/:id", $controller->update);
    }
}