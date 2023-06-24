<?php

namespace Routes\Admin;

class CMSRoutes
{
    static function register($app, $controller)
    {
        $app->get("/admin/cms", $controller->showIndex);
        $app->post("/admin/cms", $app->form->sanitize, $controller->update);
    }
}
