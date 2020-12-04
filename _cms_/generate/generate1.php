<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_cms_/engine/lib/autoloader.php';

$parsedown = new Parsedown();

$item = DB::getRow("SELECT * FROM `news` WHERE `id` = :id", array('id' => 1));
//print_r($item);
$short_text_html = $parsedown->text($item['short_text']);

//$template = new Template('default', 'main_page');
//$template = new Template('default', 'full_news_page');
//$template->set("{#TITLE#}", $item['title']);
//$template->set("{#NEWS_TITLE#}", $item['title']);
//$template->set("{#NEWS_SHORT#}", $short_text_html);
//$template->set("{#CONTENT#}", "CONTENT 1234567890");
//$template->generate();



$file_name_in_transliteration = Transliteration::convert('тест8');

// REPLACE
$replacements = array(
//    '{#HEADER#}' => LayoutBlock::get('header_layout'),
    '{#TITLE#}' => $item['title'],
    '{#DESCRIPTION#}' => 'DESCRIPTION',
    '{#KEYWORDS#}' => 'KEYWORDS',
    '{#FULL_DESCRIPTION#}' => $short_text_html,
    '{#LEFT_MENU#}' => 'LEFT_MENU',
    '{#RIGHT_MENU#}' => 'right menu',
);

HTMLCreator::createCategory('item1');                              // create folder with name category
//HTMLCreator::deleteItem('item/1', $file_name_in_transliteration);         // delete file from folder (update)
HTMLCreator::createItem('default','main_page.tpl', 'item1', $file_name_in_transliteration, $replacements);  // create folder with name category and html file
//HTMLCreator::deleteCategory('item1');


//StaticGenerator::createItems();
HTMLCreator::showMessage();



?>