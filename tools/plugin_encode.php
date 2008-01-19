<?php
/*
 * Created on 2008-1-19
 *
 * 把人可读的源码转换为Discuz!插件导入代码。
 * 
 * <p>感谢<a href="http://discuz.net">Discuz! 官方论坛</a>的网友 C43F，介绍我了解了<a 
 * href="http://www.discuz.net/thread-414617-1-1.html">BASE64内容编辑器</a></p>
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @see <a href="http://www.discuz.net/thread-414617-1-1.html">BASE64内容编辑器</a>
 */
define('IN_DISCUZ', '1');
require_once '../include/cache.func.php'; // for function `arrayeval'
$data = file_get_contents("php://stdin", "r");
eval('$array = '.$data.';');
if (isset($array['plugin']['modules'])) $array[plugin][modules] = serialize($array['plugin']['modules']);
$data = wordwrap(base64_encode(serialize($array)), 60, "\n", 1);
echo $data;
?>