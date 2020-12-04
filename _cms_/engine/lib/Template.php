<?php

class Template
{
    private $template;
    private $tag_name_array = array();
    private $tag_data_array = array();

    public function __construct($name_folder, $name_tpl)
    {
        // '/template/default/tpl/main_page.tpl'
        $file_name_link = $_SERVER['DOCUMENT_ROOT'] . '/template/' . $name_folder . '/tpl/' . $name_tpl . '.tpl';
        if (file_exists($file_name_link)) {
            $this->template = file_get_contents($file_name_link, true);
        } else {
            echo "'$file_name_link' => NOT FOUND THIS TPL FILE!";
        }
    }

    function set($tag_name, $tag_data)
    {
        $this->tag_name_array[] = $tag_name;
        $this->tag_data_array[] = $tag_data;
    }

    function setBlock($tag_name, $tag_data)
    {
        $this->tag_name_array[] = $tag_name;
        $this->tag_data_array[] = $tag_data;
    }

    function generate()
    {
        $file = str_replace($this->tag_name_array, $this->tag_data_array, $this->template);
        echo $file;
    }
}

