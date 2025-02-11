<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2023 iDB Support - https://idb.osdn.jp/support/category.php?act=view&id=1
    Copyright 2004-2023 Game Maker 2k - https://idb.osdn.jp/support/category.php?act=view&id=2

    $FileInfo: functions.php - Last Update: 6/28/2023 SVN 996 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="functions.php"||$File3Name=="/functions.php") {
	require('index.php');
	exit(); }
// Check the file names
function CheckFile($FileName) {
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name==$FileName||$File3Name=="/".$FileName) {
	require('index.php');
	exit(); }
return null; }
function CheckFiles($FileName) {
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name==$FileName||$File3Name=="/".$FileName) {
	return true; } }
CheckFile("functions.php");
require($SettDir['misc']."compression.php");
if($Settings['sqltype']=="mysql") {
if(!in_array("ini_set", $disfunc)) {
@ini_set("mysql.default_host",$Settings['sqlhost']);
@ini_set("mysql.default_user",$Settings['sqluser']);
@ini_set("mysql.default_password",$Settings['sqlpass']); }
require($SettDir['sql']."mysql.php"); }
if($Settings['sqltype']=="mysqli") {
if(!in_array("ini_set", $disfunc)) {
@ini_set("mysqli.default_host",$Settings['sqlhost']);
@ini_set("mysqli.default_user",$Settings['sqluser']);
@ini_set("mysqli.default_pw",$Settings['sqlpass']); }
require($SettDir['sql']."mysqli.php"); }
if($Settings['sqltype']=="pgsql") {
require($SettDir['sql']."pgsql.php"); }
if($Settings['sqltype']=="sqlite") {
require($SettDir['sql']."sqlite.php"); }
if($Settings['sqltype']=="sqlite3") {
require($SettDir['sql']."sqlite3.php"); }
if($Settings['sqltype']=="pdo_sqlite3") {
require($SettDir['sql']."pdo_sqlite3.php"); }
if($Settings['sqltype']=="cubrid") {
require($SettDir['sql']."cubrid.php"); }
require($SettDir['misc']."useragents.php");
require($SettDir['misc']."password.php");
/* 
if ($_GET['act']=="DeleteSession") { session_destroy(); }
if ($_GET['act']=="ResetSession") { session_unset(); }
if ($_GET['act']=="NewSessionID") { session_regenerate_id(); }
if ($_GET['act']=="PHPInfo") { phpinfo(); exit(); }
if ($_GET['act']=="phpinfo") { phpinfo(); exit(); }
if ($_GET['act']=="PHPCredits") { phpcredits(); exit(); }
if ($_GET['act']=="phpcredits") { phpcredits(); exit(); } 
*/
function header_protocol($header) {
if(isset($_SERVER['SERVER_PROTOCOL'])&&strstr($_SERVER['SERVER_PROTOCOL'],"/1.0")) {
	return "HTTP/1.0 ".$header; }
else {
	return "HTTP/1.1 ".$header; } }
// Change the title and gzip page
function change_title($new_title,$use_gzip="off",$gzip_type="gzip") {
global $Settings,$urlstatus;
if(!isset($urlstatus)||!is_numeric($urlstatus)) { $urlstatus = 200; }
if($gzip_type!="gzip"&&$gzip_type!="deflate"&&$gzip_type!="brotli"&&$gzip_type!="zstd") { $gzip_type = "gzip"; }
if($gzip_type=="brotli"&&!function_exists('brotli_compress')) { $gzip_type = "gzip"; }
if($gzip_type=="zstd"&&!function_exists('zstd_compress')) { $gzip_type = "gzip"; }
$output = trim(ob_get_clean());
$output = preg_replace("/<title>(.*?)<\/title>/i", "<title>".$new_title."</title>", $output);
$new_title_html = htmlentities($new_title, ENT_QUOTES, $Settings['charset']);
$output = preg_replace("/<meta itemprop=\"title\" property=\"og:title\" content=\"(.*?)\" \/>/i", "<meta itemprop=\"title\" property=\"og:title\" content=\"".$new_title_html."\" />", $output);
$output = preg_replace("/<meta itemprop=\"title\" property=\"twitter:title\" content=\"(.*?)\" \/>/i", "<meta itemprop=\"title\" property=\"twitter:title\" content=\"".$new_title_html."\" />", $output);
$output = preg_replace("/<meta name=\"title\" content=\"(.*?)\" \/>/i", "<meta name=\"title\" content=\"".$new_title_html."\" />", $output);
/* Change Some PHP Settings Fix the &PHPSESSID to &amp;PHPSESSID */
$SessName = session_name();
$output = preg_replace("/&PHPSESSID/", "&amp;PHPSESSID", $output);
$qstrcode = htmlentities($Settings['qstr'], ENT_QUOTES, $Settings['charset']);
$output = str_replace($Settings['qstr'].$SessName, $qstrcode.$SessName, $output);
if (extension_loaded('tidy') && (isset($Settings['clean_html']) && $Settings['clean_html']==true)) {
 $tidyxhtml = false;
 if($Settings['output_type']=="html") {
  $tidyxhtml = false; }
 if($Settings['output_type']=="xhtml") {
  $tidyxhtml = true; }
 if($Settings['output_type']!="html" && $Settings['output_type']!="xhtml") {
  $tidyxhtml = false; }
  $config = array(
            'indent' => true,
            'clean' => true,
            'output-xhtml' => $tidyxhtml,
            'show-body-only' => true,
            'wrap' => 0);
 $output = tidy_parse_string($output, $config, 'UTF8');
 $output ->cleanRepair(); }
if($use_gzip!="on") {
	if($Settings['send_pagesize']=="on") {
	@header("Content-Length: ".decoct(strlen($output))); 
	@header("Content-MD5: ".base64_encode(md5($output))); }
	idb_log_maker($urlstatus,strlen($output));
	echo $output; }
if($use_gzip=="on") {
	if($gzip_type=="brotli"&&function_exists('brotli_compress')) {
	$goutput = brotli_compress($output); }
	if($gzip_type=="zstd"&&function_exists('zstd_compress')) {
	$goutput = zstd_compress($output); }
	if($gzip_type=="brotli"&&!function_exists('brotli_compress')) {
	$gzip_type = "gzip"; }
	if($gzip_type=="zstd"&&!function_exists('zstd_compress')) {
	$gzip_type = "gzip"; }
	if($gzip_type=="gzip") {
	$goutput = gzencode($output); }
	if($gzip_type=="deflate") {
	$goutput = gzcompress($output); }
	if($Settings['send_pagesize']=="on") {
	@header("Content-Length: ".decoct(strlen($goutput))); 
	@header("Content-MD5: ".base64_encode(md5($goutput))); }
	idb_log_maker($urlstatus,strlen($goutput));
	echo $goutput; } }
// Fix amp => (&) to &amp; and gzip page
function fix_amp($use_gzip="off",$gzip_type="gzip") {
global $Settings,$urlstatus;
if(!isset($urlstatus)||!is_numeric($urlstatus)) { $urlstatus = 200; }
if($gzip_type!="gzip"&&$gzip_type!="deflate"&&$gzip_type!="brotli"&&$gzip_type!="zstd") { $gzip_type = "gzip"; }
if($gzip_type=="brotli"&&!function_exists('brotli_compress')) { $gzip_type = "gzip"; }
if($gzip_type=="zstd"&&!function_exists('zstd_compress')) { $gzip_type = "gzip"; }
$output = trim(ob_get_clean());
/* Change Some PHP Settings Fix the &PHPSESSID to &amp;PHPSESSID */
$SessName = session_name();
$output = preg_replace("/&PHPSESSID/", "&amp;PHPSESSID", $output);
if(!isset($Settings['qstr'])) { $Settings['qstr'] = '&'; }
$qstrcode = htmlentities($Settings['qstr'], ENT_QUOTES, $Settings['charset']);
$output = str_replace($Settings['qstr'].$SessName, $qstrcode.$SessName, $output);
if (extension_loaded('tidy') && (isset($Settings['clean_html']) && $Settings['clean_html']==true)) {
 $tidyxhtml = false;
 if($Settings['output_type']=="html") {
  $tidyxhtml = false; }
 if($Settings['output_type']=="xhtml") {
  $tidyxhtml = true; }
 if($Settings['output_type']!="html" && $Settings['output_type']!="xhtml") {
  $tidyxhtml = false; }
  $config = array(
            'indent' => true,
            'clean' => true,
            'output-xhtml' => $tidyxhtml,
            'show-body-only' => true,
            'wrap' => 0);
 $output = tidy_parse_string($output, $config, 'UTF8');
 $output ->cleanRepair(); }
if(!isset($Settings['send_pagesize'])) { $Settings['send_pagesize'] = "on"; }
if($use_gzip!="on") {
	if($Settings['send_pagesize']=="on") {
	@header("Content-Length: ".decoct(strlen($output))); 
	@header("Content-MD5: ".base64_encode(md5($output))); }
	idb_log_maker($urlstatus,strlen($output));
	echo $output; }
if($use_gzip=="on") {
	if($gzip_type=="brotli"&&function_exists('brotli_compress')) {
	$goutput = brotli_compress($output); }
	if($gzip_type=="zstd"&&function_exists('zstd_compress')) {
	$goutput = zstd_compress($output); }
	if($gzip_type=="brotli"&&!function_exists('brotli_compress')) {
	$gzip_type = "gzip"; }
	if($gzip_type=="zstd"&&!function_exists('zstd_compress')) {
	$gzip_type = "gzip"; }
	if($gzip_type=="gzip") {
	$goutput = gzencode($output); }
	if($gzip_type=="deflate") {
	$goutput = gzcompress($output); }
	if($Settings['send_pagesize']=="on") {
	@header("Content-Length: ".decoct(strlen($goutput))); 
	@header("Content-MD5: ".base64_encode(md5($goutput))); }
	idb_log_maker($urlstatus,strlen($goutput));
	echo $goutput; } }
// GZip page for faster download
function gzip_page($use_gzip="off",$gzip_type="gzip") {
global $Settings,$urlstatus;
if(!isset($urlstatus)||!is_numeric($urlstatus)) { $urlstatus = 200; }
$output = trim(ob_get_clean());
if (extension_loaded('tidy') && (isset($Settings['clean_html']) && $Settings['clean_html']==true)) {
 $tidyxhtml = false;
 if($Settings['output_type']=="html") {
  $tidyxhtml = false; }
 if($Settings['output_type']=="xhtml") {
  $tidyxhtml = true; }
 if($Settings['output_type']!="html" && $Settings['output_type']!="xhtml") {
  $tidyxhtml = false; }
  $config = array(
            'indent' => true,
            'clean' => true,
            'output-xhtml' => $tidyxhtml,
            'show-body-only' => true,
            'wrap' => 0);
 $output = tidy_parse_string($output, $config, 'UTF8');
 $output ->cleanRepair(); }
if($gzip_type!="gzip"&&$gzip_type!="deflate"&&$gzip_type!="brotli"&&$gzip_type!="zstd") { $gzip_type = "gzip"; }
if($gzip_type=="brotli"&&!function_exists('brotli_compress')) { $gzip_type = "gzip"; }
if($gzip_type=="zstd"&&!function_exists('zstd_compress')) { $gzip_type = "gzip"; }
if($use_gzip!="on") {
	if($Settings['send_pagesize']=="on") {
	@header("Content-Length: ".decoct(strlen($output))); 
	@header("Content-MD5: ".base64_encode(md5($output))); }
	idb_log_maker($urlstatus,strlen($output));
	echo $output; }
if($use_gzip=="on") {
	if($gzip_type=="brotli"&&function_exists('brotli_compress')) {
	$goutput = brotli_compress($output); }
	if($gzip_type=="zstd"&&function_exists('zstd_compress')) {
	$goutput = zstd_compress($output); }
	if($gzip_type=="brotli"&&!function_exists('brotli_compress')) {
	$gzip_type = "gzip"; }
	if($gzip_type=="zstd"&&!function_exists('zstd_compress')) {
	$gzip_type = "gzip"; }
	if($gzip_type=="gzip") {
	$goutput = gzencode($output); }
	if($gzip_type=="deflate") {
	$goutput = gzcompress($output); }
	if($Settings['send_pagesize']=="on") {
	@header("Content-Length: ".decoct(strlen($goutput))); 
	@header("Content-MD5: ".base64_encode(md5($goutput))); }
	idb_log_maker($urlstatus,strlen($goutput));
	echo $goutput; } }
$foo="bar"; $$foo="foo";
// Kill bad vars for some functions
function killbadvars($varname) {
$badphp1 = array('$'); $badphp2 = array(null);
$varname = str_replace($badphp1, $badphp2, $varname);
$varname = preg_replace("/(_SERVER|_ENV|_COOKIE|_SESSION)/i", null, $varname);
$varname = preg_replace("/(_GET|_POST|_FILES|_REQUEST|GLOBALS)/i", null, $varname);
$varname = preg_replace("/(HTTP_SERVER_VARS|HTTP_ENV_VARS)/i", null, $varname);
$varname = preg_replace("/(HTTP_COOKIE_VARS|HTTP_SESSION_VARS)/i", null, $varname);
$varname = preg_replace("/(HTTP_GET_VARS|HTTP_POST_VARS|HTTP_POST_FILES)/i", null, $varname);
	return $varname; }
// Trying to fix this bug. ^_^
// http://xforce.iss.net/xforce/xfdb/49697
if(!isset($Settings['DefaultTheme'])) {
	$Settings['DefaultTheme'] = "iDB"; }
// Change the text to icons(smileys)
function text2icons($Text,$sqlt,$link=null) {
global $SQLStat;
if(!isset($link)) { $link = $SQLStat; }
$melaniequery=sql_pre_query("SELECT * FROM \"".$sqlt."smileys\"", array(null));
$melanieresult=sql_query($melaniequery,$link);
$melanienum=sql_num_rows($melanieresult);
$melanies=0;
while ($melanies < $melanienum) {
$FileName=sql_result($melanieresult,$melanies,"FileName");
$SmileName=sql_result($melanieresult,$melanies,"SmileName");
$SmileText=sql_result($melanieresult,$melanies,"SmileText");
$SmileDirectory=sql_result($melanieresult,$melanies,"Directory");
$ShowSmile=sql_result($melanieresult,$melanies,"Display");
$ReplaceType=sql_result($melanieresult,$melanies,"ReplaceCI");
if($ReplaceType=="on") { $ReplaceType = "yes"; }
if($ReplaceType=="off") { $ReplaceType = "no"; }
if($ReplaceType!="yes"||$ReplaceType!="no") { $ReplaceType = "no"; }
$Smile1 = $SmileText;
$Smile2 = '<img src="'.$SmileDirectory.''.$FileName.'" style="vertical-align: middle; border: 0px;" title="'.$SmileName.'" alt="'.$SmileName.'" />';
if($ReplaceType=="no") {
$Text = str_replace($Smile1, $Smile2, $Text); }
if($ReplaceType=="yes") {
	$Smile1 = preg_quote($SmileText,"/");
$Text = preg_replace("/".$Smile1."/i",$Smile2,$Text); }
++$melanies; } return $Text; }
// Removes the bad stuff
// Disabling to relax harsh restrictions ^_^ 
function remove_bad_entities($Text) {
/*//HTML Entities Dec Version
$Text = preg_replace("/&#8238;/isU","",$Text);
$Text = preg_replace("/&#8194;/isU","",$Text);
$Text = preg_replace("/&#8195;/isU","",$Text);
$Text = preg_replace("/&#8201;/isU","",$Text);
$Text = preg_replace("/&#8204;/isU","",$Text);
$Text = preg_replace("/&#8205;/isU","",$Text);
$Text = preg_replace("/&#8206;/isU","",$Text);
$Text = preg_replace("/&#8207;/isU","",$Text);
//HTML Entities Hex Version
$Text = preg_replace("/&#x202e;/isU","",$Text);
$Text = preg_replace("/&#x2002;/isU","",$Text);
$Text = preg_replace("/&#x2003;/isU","",$Text);
$Text = preg_replace("/&#x2009;/isU","",$Text);
$Text = preg_replace("/&#x200c;/isU","",$Text);
$Text = preg_replace("/&#x200d;/isU","",$Text);
$Text = preg_replace("/&#x200e;/isU","",$Text);
$Text = preg_replace("/&#x200f;/isU","",$Text);
//HTML Entities Name Version
$Text = preg_replace("/&ensp;/isU","",$Text);
$Text = preg_replace("/&emsp;/isU","",$Text);
$Text = preg_replace("/&thinsp;/isU","",$Text);
$Text = preg_replace("/&zwnj;/isU","",$Text);
$Text = preg_replace("/&zwj;/isU","",$Text);
$Text = preg_replace("/&lrm;/isU","",$Text);
$Text = preg_replace("/&rlm;/isU","",$Text);*/
return $Text; }
// Remove the bad stuff
function remove_spaces($Text) {
$Text = preg_replace("/(^\t+|\t+$)/","",$Text);
$Text = preg_replace("/(^\n+|\n+$)/","",$Text);
$Text = preg_replace("/(^\r+|\r+$)/","",$Text);
$Text = preg_replace("/(\r|\n|\t)+/"," ",$Text);
$Text = preg_replace("/\s\s+/"," ",$Text);
$Text = preg_replace("/(^\s+|\s+$)/","",$Text);
$Text = trim($Text, "\x00..\x1F");
$Text = remove_bad_entities($Text);
return $Text; }
// Fix some chars
function fixbamps($text) {
$fixamps1 = array("&amp;copy;","&amp;reg;","&amp;trade;","&amp;quot;","&amp;amp;","&amp;lt;","&amp;gt;","&amp;(a|e|i|o|u|y)acute;","&amp;(a|e|i|o|u)grave;","&amp;(a|e|i|o|u)circ;","&amp;(a|e|i|o|u|y)uml;","&amp;(a|o|n)tilde;","&amp;aring;","&amp;aelig;","&amp;ccedil;","&amp;eth;","&amp;oslash;","&amp;szlig;","&amp;thorn;");
$fixamps2 = array("&#169;","&reg;","&trade;","&quot;","&amp;","&lt;","&gt;","&\\1acute;","&\\1grave;","&\\1circ;","&\\1uml;","&\\1tilde;","&aring;","&aelig;","&ccedil;","&eth;","&oslash;","&szlig;","&thorn;");
$ampnum = count($fixamps1); $ampi=0;
while ($ampi < $ampnum) {
$text = preg_replace("/".$fixamps1[$ampi]."/i", $fixamps2[$ampi], $text);
++$ampi; }
$text = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $text);
return $text; }
$utshour = $dayconv['hour'];
$utsminute = $dayconv['minute'];
// Change Time Stamp to a readable time
function GMTimeChange($format,$timestamp,$offset,$minoffset=null,$dst=null) {
global $utshour,$utsminute;
$dstake = null;
if(!is_numeric($minoffset)) { $minoffset = "00"; }
$ts_array = explode(":",$offset);
if(count($ts_array)!=2) {
	if(!isset($ts_array[0])) { $ts_array[0] = "0"; }
	if(!isset($ts_array[1])) { $ts_array[1] = "00"; }
	$offset = $ts_array[0].":".$ts_array[1]; }
if(!is_numeric($ts_array[0])) { $ts_array[0] = "0"; }
if(!is_numeric($ts_array[1])) { $ts_array[1] = "00"; }
if($ts_array[1]<0) { $ts_array[1] = "00"; $offset = $ts_array[0].":".$ts_array[1]; }
$tsa = array("offset" => $offset, "hour" => $ts_array[0], "minute" => $ts_array[1]);
//$tsa['minute'] = $tsa['minute'] + $minoffset;
if($dst!="on"&&$dst!="off") { $dst = "off"; }
if($dst=="on") { if($dstake!="done") { 
	$dstake = "done"; $tsa['hour'] = $tsa['hour']+1; } }
$utimestamp = $tsa['hour'] * $utshour;
$utimestamp = $utimestamp + $tsa['minute'] * $utsminute;
$utimestamp = $utimestamp + $minoffset * $utsminute;
$timestamp = $timestamp + $utimestamp;
return date($format,$timestamp); }
// Change Time Stamp to a readable time
function TimeChange($format,$timestamp,$offset,$minoffset=null,$dst=null) {
return GMTimeChange($format,$timestamp,$offset,$minoffset,$dst); }
// Make a GMT Time Stamp
function GMTimeStamp() {
$GMTHour = gmdate("H");
$GMTMinute = gmdate("i");
$GMTSecond = gmdate("s");
$GMTMonth = gmdate("n");
$GMTDay = gmdate("d");
$GMTYear = gmdate("Y");
return mktime($GMTHour,$GMTMinute,$GMTSecond,$GMTMonth,$GMTDay,$GMTYear); }
// Make a GMT Time Stamp alt version
function GMTimeStampS() { return time() - date('Z', time()); }
// Get GMT Time
function GMTimeGet($format,$offset,$minoffset=null,$dst=null,$taddon=null) {
	if(!is_numeric($taddon)) { $taddon = null; }
	if($taddon!==null) {
	return GMTimeChange($format,GMTimeStamp()+$taddon,$offset,$minoffset,$dst); }
	if($taddon===null) {
	return GMTimeChange($format,GMTimeStamp(),$offset,$minoffset,$dst); } }
// Get GMT Time alt version
function GMTimeGetS($format,$offset,$minoffset=null,$dst=null) {
global $utshour,$utsminute;
$dstake = null;
if(!is_numeric($offset)) { $offset = "0"; }
if(!is_numeric($minoffset)) { $minoffset = "00"; }
$ts_array = explode(":",$offset);
if(count($ts_array)!=2) {
	if(!isset($ts_array[0])) { $ts_array[0] = "0"; }
	if(!isset($ts_array[1])) { $ts_array[1] = "00"; }
	$offset = $ts_array[0].":".$ts_array[1]; }
if(!is_numeric($ts_array[0])) { $ts_array[0] = "0"; }
if(!is_numeric($ts_array[1])) { $ts_array[1] = "00"; }
if($ts_array[1]<0) { $ts_array[1] = "00"; $offset = $ts_array[0].":".$ts_array[1]; }
$tsa = array("offset" => $offset, "hour" => $ts_array[0], "minute" => $ts_array[1]);
//$tsa['minute'] = $tsa['minute'] + $minoffset;
if($dst!="on"&&$dst!="off") { $dst = "off"; }
if($dst=="on") { if($dstake!="done") { 
	$dstake = "done"; $tsa['hour'] = $tsa['hour']+1; } }
$utimestamp = $tsa['hour'] * $utshour;
$utimestamp = $utimestamp + $tsa['minute'] * $utsminute;
$utimestamp = $utimestamp + $minoffset * $utsminute;
$timestamp = $timestamp + $utimestamp;
return date($format,mktime()+$timestamp); }
// Get Server offset
function GetSeverZone() {
$TestHour1 = date("H");
@putenv("OTZ=".getenv("TZ"));
@putenv("TZ=GMT");
$TestHour2 = date("H");
@putenv("TZ=".getenv("OTZ"));
$TestHour3 = $TestHour1-$TestHour2;
return $TestHour3; }
// Get Server offset alt version
function SeverOffSet() {
$TestHour1 = date("H");
$TestHour2 = gmdate("H");
$TestHour3 = $TestHour1-$TestHour2;
return $TestHour3; }
// Get Server offset new version
function SeverOffSetNew() {
return gmdate("g",mktime(0,date("Z"))); }
function gmtime() { return time() - (int) date('Z'); }
// Acts like highlight_file();
function file_get_source($filename,$return = FALSE) {
$phpsrc = file_get_contents($filename);
$phpsrcs = highlight_string($phpsrc,$return);
return $phpsrcs; }
// Also acts like highlight_file(); but valid xhtml
function valid_get_source($filename) {
$phpsrcs = file_get_source($filename,TRUE);
// Change font tag to span tag for valid xhtml
$phpsrcs = preg_replace("/\<font color=\"(.*?)\"\>/i", "<span style=\"color: \\1;\">", $phpsrcs);
$phpsrcs = preg_replace("/\<\/font>/i", "</span>", $phpsrcs);
return $phpsrcs; }
// Check to see if the user is hidden/shy/timid. >_> | ^_^ | <_<
function GetUserName($idu,$sqlt,$link=null) { $UsersName = null;
global $SQLStat;
if(!isset($link)) { $link = $SQLStat; }
$gunquery = sql_pre_query("SELECT * FROM \"".$sqlt."members\" WHERE \"id\"=%i LIMIT 1", array($idu));
$gunresult=sql_query($gunquery,$link);
$gunnum=sql_num_rows($gunresult);
// I'm now hidden from you. ^_^ | <_< I cant find you.
$UsersHidden = "yes";
if($gunnum>0){
$UsersName=sql_result($gunresult,0,"Name");
// Am i still hidden. o_O <_< I can see you.
$UsersHidden=sql_result($gunresult,0,"HiddenMember"); }
sql_free_result($gunresult);
$UsersInfo['Name'] = $UsersName;
$UsersInfo['Hidden'] = $UsersHidden;
return $UsersInfo; }
if(!function_exists('hash')) {
function hash($algo, $data, $raw_output = false) {
if($algo!="md5"&&$algo!="sha1") { $algo = "md5"; }
return $algo($data); } }
if(!function_exists('hash_algos')) {
function hash_algos() {
return array(0 => "md5", 1 => "sha1"); } }
if(!function_exists('hash_hmac')) {
function hash_hmac($hash, $data, $key, $raw_output = false) {
  if($hash=="sha3-224") { $hash = "sha3224"; }
  if($hash=="sha3-256") { $hash = "sha3256"; }
  if($hash=="sha3-384") { $hash = "sha3384"; }
  if($hash=="sha3-512") { $hash = "sha3512"; }
  $blocksize = 64;
  if (strlen($key)>$blocksize) {
  if (function_exists('hash')) {
  if($hash=="sha3224") { $hash = "sha3-224"; }
  if($hash=="sha3256") { $hash = "sha3-256"; }
  if($hash=="sha3384") { $hash = "sha3-384"; }
  if($hash=="sha3512") { $hash = "sha3-512"; }
  $key=pack('H*',hash($hash, $key)); }
  if (!function_exists('hash')) {
  $key=pack('H*',$hash($key)); } }
  $key=str_pad($key, $blocksize, chr(0x00));
  $ipad=str_repeat(chr(0x36),$blocksize);
  $opad=str_repeat(chr(0x5c),$blocksize);
  if($hash=="sha3224") { $hash = "sha3-224"; }
  if($hash=="sha3256") { $hash = "sha3-256"; }
  if($hash=="sha3384") { $hash = "sha3-384"; }
  if($hash=="sha3512") { $hash = "sha3-512"; }
  return hash($hash, ($key^$opad).pack('H*',hash($hash, ($key^$ipad).$data))); } }
// hmac hash function
function hmac($data,$key,$hash='sha1',$blocksize=64) {
  if($hash=="sha3-224") { $hash = "sha3224"; }
  if($hash=="sha3-256") { $hash = "sha3256"; }
  if($hash=="sha3-384") { $hash = "sha3384"; }
  if($hash=="sha3-512") { $hash = "sha3512"; }
  if (!function_exists('hash_hmac')) {
  if (strlen($key)>$blocksize) {
  if (function_exists('hash')) {
  $key=pack('H*',hash($hash, $key)); }
  if (!function_exists('hash')) {
  $key=pack('H*',$hash($key)); } }
  $key=str_pad($key, $blocksize, chr(0x00));
  $ipad=str_repeat(chr(0x36),$blocksize);
  $opad=str_repeat(chr(0x5c),$blocksize);
  if (function_exists('hash')) {
  if($hash=="sha3224") { $hash = "sha3-224"; }
  if($hash=="sha3256") { $hash = "sha3-256"; }
  if($hash=="sha3384") { $hash = "sha3-384"; }
  if($hash=="sha3512") { $hash = "sha3-512"; }
  return hash($hash, ($key^$opad).pack('H*',hash($hash, ($key^$ipad).$data))); }
  if (!function_exists('hash')) {
  return $hash(($key^$opad).pack('H*',$hash(($key^$ipad).$data))); } }
  if (function_exists('hash_hmac')) { 
  if($hash=="sha3224") { $hash = "sha3-224"; }
  if($hash=="sha3256") { $hash = "sha3-256"; }
  if($hash=="sha3384") { $hash = "sha3-384"; }
  if($hash=="sha3512") { $hash = "sha3-512"; }
  return hash_hmac($hash,$data,$key); } }
// b64hmac hash function
function b64e_hmac($data,$key,$extdata,$hash='sha1',$blocksize=64) {
	$extdata2 = hexdec($extdata); $key = $key.$extdata2;
  return base64_encode(hmac($data,$key,$hash,$blocksize).$extdata); }
// b64hmac rot13 hash function
function b64e_rot13_hmac($data,$key,$extdata,$hash='sha1',$blocksize=64) {
	$data = str_rot13($data);
	$extdata2 = hexdec($extdata); $key = $key.$extdata2;
  return base64_encode(hmac($data,$key,$hash,$blocksize).$extdata); }
// salt hmac hash function
function salt_hmac($size1=6,$size2=12) {
$hprand = rand($size1,$size2); $i = 0; $hpass = "";
while ($i < $hprand) {
$hspsrand = rand(1,2);
if($hspsrand!=1&&$hspsrand!=2) { $hspsrand=1; }
if($hspsrand==1) { $hpass .= chr(rand(48,57)); }
/* if($hspsrand==2) { $hpass .= chr(rand(65,70)); } */
if($hspsrand==2) { $hpass .= chr(rand(97,102)); }
++$i; } return $hpass; }
/* is_empty by M at http://us2.php.net/manual/en/function.empty.php#74093 */
function is_empty($var) {
    if (((is_null($var) || rtrim($var) == "") &&
		$var !== false) || (is_array($var) && empty($var))) {
        return true; } else { return false; } }
// PHP 5 hash algorithms to functions :o 
if(function_exists('hash')&&function_exists('hash_algos')) {
if(in_array("md2",hash_algos())&&!function_exists("md2")) { 
function md2($data) { return hash("md2",$data); } } 
if(in_array("md4",hash_algos())&&!function_exists("md4")) { 
function md4($data) { return hash("md4",$data); } }
if(in_array("md5",hash_algos())&&!function_exists("md5")) { 
function md5($data) { return hash("md5",$data); } }
if(in_array("sha1",hash_algos())&&!function_exists("sha1")) { 
function sha1($data) { return hash("sha1",$data); } }
if(in_array("sha224",hash_algos())&&!function_exists("sha224")) { 
function sha224($data) { return hash("sha224",$data); } }
if(in_array("sha256",hash_algos())&&!function_exists("sha256")) { 
function sha256($data) { return hash("sha256",$data); } }
if(in_array("sha384",hash_algos())&&!function_exists("sha384")) { 
function sha384($data) { return hash("sha384",$data); } }
if(in_array("sha512",hash_algos())&&!function_exists("sha512")) { 
function sha512($data) { return hash("sha512",$data); } }
if(in_array("sha3-224",hash_algos())&&!function_exists("sha3224")) { 
function sha3224($data) { return hash("sha3-224",$data); } }
if(in_array("sha3-256",hash_algos())&&!function_exists("sha3256")) { 
function sha3256($data) { return hash("sha3-256",$data); } }
if(in_array("sha3-384",hash_algos())&&!function_exists("sha3384")) { 
function sha3384($data) { return hash("sha3-384",$data); } }
if(in_array("sha3-512",hash_algos())&&!function_exists("sha3512")) { 
function sha3512($data) { return hash("sha3-512",$data); } }
if(in_array("ripemd128",hash_algos())&&!function_exists("ripemd128")) { 
function ripemd128($data) { return hash("ripemd128",$data); } }
if(in_array("ripemd160",hash_algos())&&!function_exists("ripemd160")) { 
function ripemd160($data) { return hash("ripemd160",$data); } }
if(in_array("ripemd256",hash_algos())&&!function_exists("ripemd256")) { 
function ripemd256($data) { return hash("ripemd256",$data); } }
if(in_array("ripemd512",hash_algos())&&!function_exists("ripemd512")) { 
function ripemd320($data) { return hash("ripemd320",$data); } } }
// Try and convert IPB 2.0.0 style passwords to iDB style passwords
function hash2xkey($data,$key,$hash1='md5',$hash2='md5') {
  return $hash1($hash2($key).$hash2($data)); }
// Hash two times with md5 and sha1 for DF2k
function PassHash2x($Text) {
$Text = md5($Text);
$Text = sha1($Text);
return $Text; }
// Hash two times with hmac-md5 and hmac-sha1
function PassHash2x2($data,$key,$extdata,$blocksize=64) {
$extdata2 = hexdec($extdata); $key = $key.$extdata2;
$Text = hmac($data,$key,"md5").$extdata; 
$Text = hmac($Text,$key,"sha1").$extdata;
return base64_encode($Text); }
function cp($infile,$outfile,$mode="w") { 
   $contents = file_get_contents($infile);
   $cpfp = fopen($outfile,$mode);
   fwrite($cpfp, $contents);
   fclose($cpfp);
   return true; }

// b64hmac hash function
function neo_b64e_hmac($data,$key,$extdata,$hash='sha1',$blocksize=64) {
	$extdata2 = hexdec($extdata); $key = $key.$extdata2;
  return base64_encode(password_hash($data.$extdata, PASSWORD_BCRYPT)); }
// b64hmac rot13 hash function
function neo_b64e_rot13_hmac($data,$key,$extdata,$hash='sha1',$blocksize=64) {
	$data = str_rot13($data);
	$extdata2 = hexdec($extdata); $key = $key.$extdata2;
  return base64_encode(password_hash($data.$extdata, PASSWORD_BCRYPT)); }

if(!function_exists('password_hash')) { 
function bcrypt($data) { return password_hash($data,PASSWORD_BCRYPT); } }

/* is_empty by s rotondo90 at gmail com at https://www.php.net/manual/en/function.hash-equals.php#119576*/
if(!function_exists('hash_equals')) {
    function hash_equals($known_string, $user_string) {
        $ret = 0;
       
        if (strlen($known_string) !== strlen($user_string)) {
            $user_string = $known_string;
            $ret = 1;
        }
       
        $res = $known_string ^ $user_string;
       
        for ($i = strlen($res) - 1; $i >= 0; --$i) {
            $ret |= ord($res[$i]);
        }
       
        return !$ret;
    }
}

/* str_ireplace for PHP below ver. 5 updated // 
//       by Kazuki Przyborowski - Cool Dude 2k      //
//      and upaded by Kazuki Przyborowski again     */
if(!function_exists('str_ireplace')) {
function str_ireplace($search,$replace,$subject) {
if(!is_array($search)&&is_array($replace)) {
	$search = array($search); }
if(is_array($search)&&!is_array($replace)) {
	$replace = array($replace); }
if(is_array($search)&&is_array($replace)) {
	$sc=count($search); $rc=count($replace); $sn=0;
	if($sc!=$rc) { return false; }
while ($sc > $sn) {
	$search[$sn] = preg_quote($search[$sn], "/");
	$subject = preg_replace("/".$search[$sn]."/i", $replace[$sn], $subject);
	++$sn; } }
if(!is_array($search)&&!is_array($replace)) {
$search = preg_quote($search, "/");
$subject = preg_replace("/".$search."/i", $replace, $subject); }
return $subject; } }
/*   Adds httponly to PHP below Ver. 5.2.0   // 
//       by Kazuki Przyborowski - Cool Dude 2k      */
function http_set_cookie($name,$value=null,$expire=null,$path=null,$domain=null,$secure=false,$httponly=false) {
	$mkcookie = null; $expireGMT = null;
	if(!isset($name)) { 
	output_error("Error: You need to enter a name for cookie.",E_USER_ERROR); 
	return false; }
	if(!isset($expire)) { 
	output_error("Error: You need to enter a time for cookie to expire.",E_USER_ERROR); 
	return false; }
	$expireGMT = gmdate("D, d-M-Y H:i:s \G\M\T", $expire);
	if(!isset($value)) { $value = null; }
	if(!isset($httponly)||$httponly==false) {
	setcookie($name, $value, $expire, $path, $domain, $secure); return true; }
	if(version_compare(PHP_VERSION,"5.2.0",">=")&&$httponly==true) {
	setcookie($name, $value, $expire, $path, $domain, $secure, $httponly); return true; }
	if(version_compare(PHP_VERSION,"5.2.0","<")&&$httponly==true) {
	$mkcookie = "Set-Cookie: ".rawurlencode($name)."=".rawurlencode($value);
	$mkcookie = $mkcookie."; expires=".$expireGMT;
	if(isset($path)&&$path!=null) { $mkcookie = $mkcookie."; path=".$path; }
	if(isset($domain)&&$domain!=null) { $mkcookie = $mkcookie."; domain=".$domain; }
	if(isset($secure)&&$secure===true) { $mkcookie = $mkcookie."; secure"; }
	if(isset($httponly)&&$httponly===true) { $mkcookie = $mkcookie."; HttpOnly"; }
header($mkcookie, false); return true; } }
$foobar="fubar"; $$foobar="foobar";
// Debug info
function dump_included_files($type="var_dump") {
	if(!isset($type)) { $type = "var_dump"; }
	if($type=="print_r") { return print_r(get_included_files()); }
	if($type=="var_dump") { return var_dump(get_included_files()); }
	if($type=="var_export") { return var_export(get_included_files()); } }
function count_included_files() {	return count(get_included_files()); }
function dump_extensions($type="var_dump") {
	if(!isset($type)) { $type = "var_dump"; }
	if($type=="print_r") { return print_r(get_loaded_extensions()); }
	if($type=="var_dump") { return var_dump(get_loaded_extensions()); }
	if($type=="var_export") { return var_export(get_loaded_extensions()); } }
function count_extensions() {	return count(get_loaded_extensions()); }
// human_filesize by evgenij at kostanay dot kz 
// URL: https://www.php.net/manual/en/function.filesize.php#120250
function human_filesize($bytes, $decimals = 2) {
    $factor = floor((strlen($bytes) - 1) / 3);
    if ($factor > 0) $sz = 'KMGT';
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor - 1] . 'B';
}
?>
