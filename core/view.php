<?php

/**
 * View
 * 
 * This class is responsible for working with templates.
 */
class View
{
    /**
     * This method loads the template with the required data and returns the finished html as a string.
     * 
     * @param string $template_name
     * @param array $data
     * 
     * @return string
     */
    public function get(string $template_name, array $data = [])
    {
        $html = '';
        $path = 'view/' . $template_name . '.php';

        if (!file_exists($path)) {
            return $html;
        }

        ob_start();
        extract($data);

        include($path);

        $html = ob_get_clean();

        return $html;
    }
}