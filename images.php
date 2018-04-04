<?php
error_reporting(E_ERROR);
require_once 'imgdata.php';
$karnc = new imgdata();

/**
 * 遍历获取目录下的指定类型的文件
 * @param $path
 * @param array $files
 * @return array
 */
function getfiles($path, $allowFiles, &$files = array()) {
    if (!is_dir($path)) return null;
    if (substr($path, strlen($path) - 1) != '/') $path .= '/';
    $handle = opendir($path);
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            $path2 = $path . $file;
            if (is_dir($path2)) {
                getfiles($path2, $allowFiles, $files);
            } else {
                if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                    $files[] = substr($path2, strlen($_SERVER['DOCUMENT_ROOT']));
                }
            }
        }
    }
    return $files;
}

/**
 * 域名白名单校验函数
 * @param $domain_list
 * @return true/false
 */
function checkReferer($domain_list = array(
    'haremu.com',
    'acg.sx'
)) {
    $status = false;
    $refer = $_SERVER['HTTP_REFERER']; //前一URL
    if ($refer) {
        $referhost = parse_url($refer);
        /**来源地址主域名**/
        $host = strtolower($referhost['host']);
        if ($host == $_SERVER['HTTP_HOST'] || in_array($host, $domain_list)) {
            $status = true;
        }
    }
    return $status;
}

//列出指定目录下的图片
$CONFIG = array();
$CONFIG['imageManagerAllowFiles'] = array(".png", ".jpg", ".jpeg", ".gif", ".bmp");

$base_Path = '/picture/'; //默认主目录
$category = 'a'; //默认分类目录

if ($_GET['folder']) {
    $folder = trim($_GET['folder']);
    $CONFIG['imageManagerListPath'] = $base_Path . $folder . '/';  //有GET访问的分类目录
} else {
    $CONFIG['imageManagerListPath'] = $base_Path . $category . '/'; //无GET访问的默认目录
}

$allowFiles = $CONFIG['imageManagerAllowFiles'];
$path = $CONFIG['imageManagerListPath'];

$allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

//获取文件列表
$path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "" : "/") . $path;
$files = getfiles($path, $allowFiles);
if (!count($path)) {
    return "抱歉，没有找到匹配的文件！";
}

//获取指定范围的列表
$len = count($files);
for ($i = 0, $list = array(); $i < $len; $i++) {
    $list[] = $files[$i];
}

$rand = array_rand($list, 1);
$img = $list[$rand];
$imgFile = $_SERVER['DOCUMENT_ROOT'] . (substr($list[$rand], 0, 1) == "/" ? "" : "/") . $img;
$imgNot = $_SERVER['DOCUMENT_ROOT'] . '/' . 'nico.gif'; //无授权域名图片
$refer = $_SERVER['HTTP_REFERER']; //前一URL

//存在前一URL
if ($refer) {
    if (!checkReferer()) {
        $karnc->getdir($imgNot);
        $karnc->img2data();
        $karnc->data2img();
        die;
    } else {
        $karnc->getdir($imgFile);
        $karnc->img2data();
        $karnc->data2img();
        die;
    }
} else {
    //直接访问API地址
    $imgWeb = file_get_contents('imgweb.html');
    echo $imgWeb;
    die;
}
?>