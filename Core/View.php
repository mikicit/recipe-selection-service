<?php

namespace Core;

class View
{
    public function get($template_name, $data = [])
    {
        $html = '';

        ob_start();

        if (!empty($data))
        {
            extract($data);
        }

        include 'view/' . $template_name . '.php';

        $html = ob_get_clean();

        return $html;
    }
}