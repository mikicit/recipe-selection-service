<?php

namespace Core;

class View
{
    public function get($template_name, $data = [])
    {
        $html = '';

        $path = 'Views/' . $template_name . '.php';

        if (!file_exists($path))
        {
            return $html;
        }

        ob_start();

        if (!empty($data))
        {
            extract($data);
        }

        include($path);

        $html = ob_get_clean();

        return $html;
    }
}