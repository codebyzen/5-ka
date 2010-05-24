<?
define("PKASASS", md5('PKASASS'));

//echo "<pre>";print_r($_GET);echo "</pre>";

foreach ($_GET as $gk => $gv) {
    $gv = str_replace('..', '', $gv);
    $gv = str_replace('/', '', $gv);
    $gv = str_replace('\\', '', $gv);
    $gv = str_replace('\'', '', $gv);
    $gv = str_replace('"', '', $gv);
    $gv = str_replace(';', '', $gv);
    $gv = str_replace('%', '', $gv);
    $gv = str_replace('&', '', $gv);
    if (is_numeric($gv) || is_string($gv)) {
        $__get[$gk] = $_GET[$gk];
    }
}
unset($_GET);
$_GET = $__get;

//echo "<pre>";print_r($_GET);echo "</pre>";

include ('./gear/config.php');
include ('./gear/func.php');

if (!isset($_GET['page']))
    $_GET['page'] = 0;


if (isset($_GET['page'])) {
    $_content = getArticles($_GET['page']);
}

if (isset($_GET['article']) && !empty($_GET['article'])) {
    $_content = getArticle($_GET['article']);
}

if (isset($_GET['static']) && !empty($_GET['static'])) {
    $_content = getStatic($_GET['static']);
}

$_css = file_get_contents('./tpls/' . $_cfg['theme'] . '/style.css');


ob_start();
include ('./tpls/' . $_cfg['theme'] . '/index.php');
$out = ob_get_contents();
ob_end_clean();

echo $out;

?>