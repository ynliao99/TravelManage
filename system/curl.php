<?php
function curl_get($url){
require_once 'connectsql.php';
	$con = connectSQL ();
	$sql="SELECT * FROM user WHERE email='$_COOKIE[email]'";
	$res=mysql_query($sql,$con);
	$res2=mysql_fetch_array($res);
	$cookie=$res2[4];
$f = new SaeFetchurl();
$f -> setCookie("BDUSS",$cookie);
$content = $f->fetch($url);
if($f->errno() == 0)  return $content;
else return $f->errmsg();
}

function curl_get2($url,$cookie,&$resCookies){
    if($cookie==""){
    require_once 'connectsql.php';
	$con = connectSQL ();
	$sql="SELECT * FROM user WHERE email='$_COOKIE[email]'";
	$res=mysql_query($sql,$con);
	$res2=mysql_fetch_array($res);
	$cookie=$res2[4];
    }

$f = new SaeFetchurl();
$f -> setCookie("BDUSS",$cookie);
$content = $f->fetch($url);
$resCookies = $f->responseCookies(false);
if($f->errno() == 0)  return $content;
else return $f->errmsg();
}

function sign($cookie,$tiebaname,$fid,$urlname){
$f = new SaeFetchurl();
$f->setMethod("post");
$f->setCookie("BDUSS",$cookie);
$tbs = tbs($cookie);
    curl_get2("http://tieba.baidu.com/f/user/json_userinfo",$cookie,$rescookie);
    $cookieT = "TIEBA_USERTYPE=".$rescookie['TIEBA_USERTYPE'].";TIEBAUID=".$rescookie['TIEBAUID'].";BAIDUID=".$rescookie['BAIDUID']."=1;BDUSS=".$cookie;
$poststr = $cookieT."fid=".$fid."from=tiebakw=".$tiebaname."net_type=1tbs=".$tbs;
$sign = md5($poststr."tiebaclient!!!");
$poststr = $cookieT."&fid=".$fid."&from=tieba&kw=".$urlname."&net_type=1&tbs=".$tbs."&sign=".$sign;
$f->setPostData($poststr);
$text = $f->fetch("http://c.tieba.baidu.com/c/c/forum/sign");
if($f->errno() == 0) return $text;
else return false;

}

function tbs($cookie=""){
$f = new SaeFetchurl();
$f->setCookie("BDUSS",$cookie);
$content = $f->fetch("http://tieba.baidu.com/dc/common/tbs");
$tbs = explode('"',$content);
return $tbs[3];
}