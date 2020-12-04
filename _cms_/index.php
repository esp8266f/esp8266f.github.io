<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_cms_/engine/lib/autoloader.php';

define("MAIN_PAGE_URL", "https://esp8266f.github.io/");

//$parsedown = new Parsedown();

//$item = DB::getRow("SELECT * FROM `news` WHERE `id` = :id", array('id' => 1));
//print_r($item);
//$short_text_html = $parsedown->text($item['short_text']);

//$template = new Template('default', 'main_page');
//$template = new Template('default', 'full_news_page');
//$template->set("{#TITLE#}", $item['title']);
//$template->set("{#NEWS_TITLE#}", $item['title']);
//$template->set("{#NEWS_SHORT#}", $short_text_html);
//$template->set("{#CONTENT#}", "CONTENT 1234567890");
//$template->generate();

generateAllNewsFromDB();

function generateAllNewsFromDB()
{
    $parsedown = new Parsedown();
    $items_array = DB::getAll("SELECT * FROM `news`", array());

    foreach ($items_array as $item) {
        $file_name_in_transliteration = Transliteration::convert($item['title']);
        $short_text_html = $parsedown->text($item['short_text']);
        $full_text_html = $parsedown->text($item['full_text']);

        // REPLACE
        $replacements = array(
            '{#LINK_MAIN_PAGE#}' => MAIN_PAGE_URL,
            '{#LINK_THIS_PAGE#}' => MAIN_PAGE_URL . $file_name_in_transliteration . '.html',
            '{#META_DESCRIPTION#}' => $item['meta_description'],
            '{#META_KEYWORDS#}' => $item['meta_keywords'],
            '{#META_AUTHOR#}' => $item['meta_author'],
            '{#TITLE#}' => $item['title'],
            '{#CATEGORY#}' => $item['category'],
            '{#FULL_TEXT#}' => $full_text_html,
            '{#SHORT_TEXT#}' => $short_text_html,
            '{#LEFT_MENU#}' => 'LEFT_MENU',
            '{#RIGHT_MENU#}' => 'right menu'
        );

        HTMLCreator::createCategory($item['category']);                              // create folder with name category
        HTMLCreator::deleteItem($item['category'], $file_name_in_transliteration);   // delete file from folder (update)
        HTMLCreator::createItem('default', 'full_news_page.tpl', $item['category'], $file_name_in_transliteration, $replacements);  // create folder with name category and html file

//        echo "<p>$file_name_in_transliteration</p>";
//        echo $short_text_html;
//        echo $full_text_html;


    }

    HTMLCreator::showMessage();
}

?>