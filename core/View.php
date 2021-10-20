<?php

namespace core;

class View
{
    public function get($template_name, $data = [])
    {
        $html = '';
        $path = 'view/' . $template_name . '.php';

        if (!file_exists($path))
        {
            return $html;
        }

        ob_start();
        extract($data);

        include($path);

        $html = ob_get_clean();

        return $html;
    }
}