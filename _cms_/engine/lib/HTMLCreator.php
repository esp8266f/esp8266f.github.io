<?php
define('PATH_TPL', '/_cms_/template/default/tpl/');

class HTMLCreator
{
    public static $message = array();
    private static $tag_name_array = array();
    private static $tag_data_array = array();

    // CREATE CATEGORY FOLDER
    public static function createCategory($category)
    {
        $category_root = $_SERVER['DOCUMENT_ROOT'] . '/' . $category . '/';
        if (!file_exists($category_root) && !is_dir($category_root)) {                               // 'category' провірка на існування папки
            mkdir($category_root, 0644, true);                  //   './category/about/'
            self::$message['create_category'][] = " ${category} <b style='color: green;'>FOLDER CREATED!</b>";
        } else {
            self::$message['create_category'][] = "Категорія <b style='color: red;'>${category}</b> вже існує.";
        }
    }

    // CREATE CATEGORY FOLDER
    public static function deleteCategory($category)
    {
        $system_path_array = ['engine', '_cms_'];                        // system folder list cms
        if (!in_array($category, $system_path_array)) {
            $dir_root = $_SERVER['DOCUMENT_ROOT'] . '/' . $category . '/';
            if (is_dir($dir_root)) {
                foreach (glob($dir_root . '*') as $file) {
                    if (is_dir($file)) self::deleteCategory($file); else unlink($file);
                }
                rmdir($dir_root);
                self::$message['delete_category'][] = "Папку <b style='color: red;'>${category}</b> видалено.";
            }
        }
    }

    // CREATE NEWS HTML FILE IN CATEGORY FOLDER
    public static function createItem($template, $tpl, $category, $file_name, $add_text = array())
    {
        $PATH_TPL = '/_cms_/template/' . $template . '/tpl/';
        $category_root = $_SERVER['DOCUMENT_ROOT'] . '/' . $category . '/';
        $create_root_file = $_SERVER['DOCUMENT_ROOT'] . '/' . $category . '/' . $file_name . '.html';
        if (is_dir($category_root)) {                                                     //  file_exists => '/path/to/foo.txt'
            $get_template = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $PATH_TPL . $tpl);   // get content from template
            $add_text_to_template = str_replace(array_keys($add_text), array_values($add_text), $get_template);  // replace data in template
//            $add_text_to_template = HTML_minify::minify_html($add_text_to_template);  // minify html
            file_put_contents($create_root_file, $add_text_to_template, LOCK_EX); // create html file
            self::$message['create_news'][] = "${file_name} <b style='color: green;'>ITEM CREATED</b>";
        } else {
            self::$message['create_news'][] = "${file_name} вже існує.";
        }
    }

    // CREATE NEWS HTML FILE IN MAIN FOLDER
    public static function create_news_im_main_folder($template, $tpl, $file_name, $add_text = array())
    {
        $PATH_TPL = '/_cms_/template/' . $template . '/tpl/';

        $create_file = '/' . $file_name . '.html';         //  file_exists => '/path/to/foo.txt'
        $get_template = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $PATH_TPL . $tpl);   // get content from template
        $add_text_to_template = str_replace(array_keys($add_text), array_values($add_text), $get_template);  // replace data in template
//        $add_text_to_template = HTML_minify_::minify_html($add_text_to_template);  // minify html
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . $create_file, $add_text_to_template, LOCK_EX); // create html file
//            echo $add_text_to_template;
        self::$message['create_news'][] = "Стаття ${file_name} успішно створена.";
    }

    // SHOW ALL MESSAGE
    public static function showMessage()
    {
        echo '<pre>';
        print_r(self::$message);
        echo '</pre>';

//        foreach (self::$message as $key => $value) {
//            echo '[' . $key . '] ' . $value . '<br>';
//        }
    }

    // DELETE NEWS BY FILE NAME IN CATEGORY FOLDER
    public static function deleteItem($category, $file_name)
    {
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $category . '/' . $file_name . '.html';
        $category_root = $_SERVER['DOCUMENT_ROOT'] . '/' . $category . '/';
        if (file_exists($file_path) && is_dir($category_root)) {
            $myFileLink = fopen($file_path, 'w') or die('can\'t open file');
            fclose($myFileLink);
            unlink($file_path);   // delete file $file_path_for_delete = "testFolder/sampleDeleteFile.txt";
        }
    }

    // DELETE NEWS BY FILE NAME IN CATEGORY FOLDER
    public static function deleteStaticNewsByUrl($file_path)
    {
        $result = preg_match('#^[\/]{1}(.*)#', $file_path, $matches);
        $file_path_for_delete = isset($matches[1]) ? $matches[1] : null;
        if (file_exists($file_path_for_delete) && $result == 1) {
            $myFileLink = fopen($file_path_for_delete, 'w') or die('can\'t open file');
            fclose($myFileLink);
            unlink($file_path_for_delete);   // delete file $file_path_for_delete = "testFolder/sampleDeleteFile.txt";
            echo $file_path . ' deleted!<br>';
        } else {
            echo $file_path_for_delete . ' not found!<br>';
        }
    }

}

?>