<?php
namespace Routes\Teachers;
class SectionsRoutes
{
    static function register($app,$controller)
    {
        $app->get("/teachers/sections/new", $controller->showNew);
        $app->get("/teachers/sections/:id/edit", $controller->showEdit);
        $app->post("/sections", $app->form->sanitize,$controller->create);
        $app->put("/sections/:id", $app->form->sanitize,$controller->update);
        $app->delete("/sections/:id",$controller->delete);
    }
}