<?php
namespace Routes\Teachers;
class ModulesRoutes
{
    static function register($app,$controller)
    {
        $app->get("/teachers/modules/new", $controller->showNew);
        $app->get("/teachers/modules/:id/edit", $controller->showEdit);
        $app->post("/modules", $app->form->sanitize,$controller->create);
        $app->delete("/modules/:id", $controller->delete);
    }
}