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

    $FileInfo: groupsetup.php - Last Update: 6/22/2023 SVN 984 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="groupsetup.php"||$File3Name=="/groupsetup.php") {
	require('index.php');
	exit(); }
//Set members temp location
if(isset($_SESSION['OldViewingPage'])) { $_SESSION['AncientViewingPage'] = $_SESSION['OldViewingPage']; } else { $_SESSION['AncientViewingPage'] = url_maker(null,"no+ext","act=view","&","=",$prexqstr['index'],$exqstr['index']); }
if(isset($_SESSION['OldViewingFile'])) { $_SESSION['AncientViewingFile'] = $_SESSION['OldViewingFile']; } else { 
	 if($Settings['file_ext']!="no+ext"&&$Settings['file_ext']!="no ext") {
	    $_SESSION['AncientViewingFile'] = $exfile['index'].$Settings['file_ext']; }
	 if($Settings['file_ext']=="no+ext"||$Settings['file_ext']=="no ext") {
	    $_SESSION['AncientViewingFile'] = $exfile['index']; } }
if(isset($_SESSION['OldPreViewingTitle'])) { $_SESSION['AncientPreViewingTitle'] = $_SESSION['OldPreViewingTitle']; } else { $_SESSION['AncientPreViewingTitle'] = "Viewing"; }
if(isset($_SESSION['OldViewingTitle'])) { $_SESSION['AncientViewingTitle'] = $_SESSION['OldViewingTitle']; } else { $_SESSION['AncientViewingTitle'] = "Board index"; }
if(isset($_SESSION['OldExtraData'])) { $_SESSION['AncientExtraData'] = $_SESSION['OldExtraData']; } else { $_SESSION['AncientExtraData'] = "currentact:view; currentcategoryid:0; currentforumid:0; currenttopicid:0; currentmessageid:0; currenteventid:0; currentmemberid:0;"; }
if(isset($_SESSION['ViewingPage'])) { $_SESSION['OldViewingPage'] = $_SESSION['ViewingPage']; } else { $_SESSION['OldViewingPage'] = url_maker(null,"no+ext","act=view","&","=",$prexqstr['index'],$exqstr['index']); }
if(isset($_SESSION['ViewingFile'])) { $_SESSION['OldViewingFile'] = $_SESSION['ViewingFile']; } else { 
	 if($Settings['file_ext']!="no+ext"&&$Settings['file_ext']!="no ext") {
	    $_SESSION['OldViewingFile'] = $exfile['index'].$Settings['file_ext']; }
	 if($Settings['file_ext']=="no+ext"||$Settings['file_ext']=="no ext") {
	    $_SESSION['OldViewingFile'] = $exfile['index']; } }
if(isset($_SESSION['PreViewingTitle'])) { $_SESSION['OldPreViewingTitle'] = $_SESSION['PreViewingTitle']; } else { $_SESSION['OldPreViewingTitle'] = "Viewing"; }
if(isset($_SESSION['ViewingTitle'])) { $_SESSION['OldViewingTitle'] = $_SESSION['ViewingTitle']; } else { $_SESSION['OldViewingTitle'] = "Board index"; }
if(isset($_SESSION['ExtraData'])) { $_SESSION['OldExtraData'] = $_SESSION['ExtraData']; } else { $_SESSION['OldExtraData'] = "currentact:view; currentcategoryid:0; currentforumid:0; currenttopicid:0; currentmessageid:0; currenteventid:0; currentmemberid:0;"; }
$_SESSION['ViewingPage'] = url_maker(null,"no+ext","act=view","&","=",$prexqstr['index'],$exqstr['index']);
if($Settings['file_ext']!="no+ext"&&$Settings['file_ext']!="no ext") {
$_SESSION['ViewingFile'] = $exfile['index'].$Settings['file_ext']; }
if($Settings['file_ext']=="no+ext"||$Settings['file_ext']=="no ext") {
$_SESSION['ViewingFile'] = $exfile['index']; }
$_SESSION['PreViewingTitle'] = "Viewing";
$_SESSION['ViewingTitle'] = "Board index";
$_SESSION['ExtraData'] = "currentact:view; currentcategoryid:0; currentforumid:0; currenttopicid:0; currentmessageid:0; currenteventid:0; currentmemberid:0;";
/*$ggidquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"Name\"='%s' LIMIT 1", array($Settings['GuestGroup']));
$ggidresult=sql_query($ggidquery,$SQLStat);
$Settings['GuestGroupID']=sql_result($ggidresult,0,"id");*/
// Check to make sure MemberInfo is right
$MyPostCountChk = null; $MyKarmaCount = null;
if(!isset($_SESSION['UserID'])) { $_SESSION['UserID'] = 0; }
if($_SESSION['UserID']!=0&&$_SESSION['UserID']!=null) { $BanError = null;
$kgbquerychkusr = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"Name\"='%s' AND \"UserPassword\"='%s' AND \"id\"=%i LIMIT 1", array($_SESSION['MemberName'],$_SESSION['UserPass'],$_SESSION['UserID'])); 
$resultchkusr=sql_query($kgbquerychkusr,$SQLStat);
$numchkusr=sql_num_rows($resultchkusr);
if($numchkusr==1) {
$ChkUsrID=sql_result($resultchkusr,0,"id");
$ChkUsrName=sql_result($resultchkusr,0,"Name");
$ChkUsrGroup=sql_result($resultchkusr,0,"GroupID");
$ChkUsrGroupID=$ChkUsrGroup;
$ChkUsrLevel=sql_result($resultchkusr,0,"LevelID");
$ChkUsrLevelID=$ChkUsrLevel;
$ChkUsrRank=sql_result($resultchkusr,0,"RankID");
$ChkUsrRankID=$ChkUsrRank;
$ChkUsrPass=sql_result($resultchkusr,0,"UserPassword");
$ChkUsrTimeZone=sql_result($resultchkusr,0,"TimeZone");
$ChkUsrDateFormat=sql_result($resultchkusr,0,"DateFormat");
$ChkUsrTimeFormat=sql_result($resultchkusr,0,"TimeFormat");
$ChkUsrTheme=sql_result($resultchkusr,0,"UseTheme");
$ChkUsrLastPostTime=sql_result($resultchkusr,0,"LastPostTime");
$MyPostCountChk=sql_result($resultchkusr,0,"PostCount");
$MyKarmaCount=sql_result($resultchkusr,0,"Karma");
$MyKarmaUpdate=sql_result($resultchkusr,0,"KarmaUpdate");
$MyRepliesPerPage=sql_result($resultchkusr,0,"RepliesPerPage");
$Settings['max_posts'] = $MyRepliesPerPage;
$MyTopicsPerPage=sql_result($resultchkusr,0,"TopicsPerPage");
$Settings['max_topics'] = $MyTopicsPerPage;
$MyMessagesPerPage=sql_result($resultchkusr,0,"MessagesPerPage");
$Settings['max_memlist'] = $MyMessagesPerPage;
$Settings['max_pmlist'] = $MyMessagesPerPage;
$svrquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i LIMIT 1", array($ChkUsrGroup));
$svrgresultkgb=sql_query($svrquery,$SQLStat);
$ChkUsrGroup=sql_result($svrgresultkgb,0,"Name"); 
$ChkUsrBanTime=sql_result($resultchkusr,0,"BanTime");
$ChkUsrGMTime = $utccurtime->getTimestamp();
if($ChkUsrBanTime!=0&&$ChkUsrBanTime!=null) {
if($ChkUsrBanTime>=$ChkUsrGMTime) { $BanError = "yes"; }
if($ChkUsrBanTime<0) { $BanError = "yes"; } }
if($BanError!="yes") {
$_SESSION['Theme']=$ChkUsrTheme;
$_SESSION['MemberName']=$ChkUsrName;
$_SESSION['UserID']=$ChkUsrID;
$_SESSION['UserIP']=$_SERVER['REMOTE_ADDR'];
$_SESSION['UserTimeZone']=$ChkUsrTimeZone;
$usertz = new DateTimeZone($_SESSION['UserTimeZone']);
$usercurtime->setTimestamp($defcurtime->getTimestamp());
$usercurtime->setTimezone($usertz);
$_SESSION['iDBDateFormat']=$ChkUsrDateFormat;
$_SESSION['iDBTimeFormat']=$ChkUsrTimeFormat;
$_SESSION['UserGroup']=$ChkUsrGroup;
$_SESSION['UserGroupID']=$ChkUsrGroupID;
$_SESSION['UserPass']=$ChkUsrPass;
$_SESSION['LastPostTime'] = $ChkUsrLastPostTime; } }
if($numchkusr<=0||$numchkusr>1||$BanError=="yes") { session_unset();
if($cookieDomain==null) {
setcookie("MemberName", null, $utccurtime->getTimestamp() - 3600, $cbasedir);
setcookie("UserID", null, $utccurtime->getTimestamp() - 3600, $cbasedir);
setcookie("SessPass", null, $utccurtime->getTimestamp() - 3600, $cbasedir);
setcookie(session_name(), "", $utccurtime->getTimestamp() - 3600, $cbasedir); }
if($cookieDomain!=null) {
if($cookieSecure===true) {
setcookie("MemberName", null, $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 1);
setcookie("UserID", null, $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 1);
setcookie("SessPass", null, $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 1);
setcookie(session_name(), "", $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 1); }
if($cookieSecure===false) {
setcookie("MemberName", null, $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 0);
setcookie("UserID", null, $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 0);
setcookie("SessPass", null, $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 0);
setcookie(session_name(), "", $utccurtime->getTimestamp() - 3600, $cbasedir, $cookieDomain, 0); } }
unset($_COOKIE[session_name()]);
$_SESSION = array(); session_unset(); session_destroy();
redirect("location",$rbasedir.url_maker($exfile['member'],$Settings['file_ext'],"act=login",$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member'],false)); sql_free_result($resultchkusr); sql_free_result($svrgresultkgb);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
sql_free_result($resultchkusr); sql_free_result($svrgresultkgb); }
if($_SESSION['UserID']==0||$_SESSION['UserID']==null) {
$_SESSION['UserIP']=$_SERVER['REMOTE_ADDR'];
$_SESSION['MemberName'] = null;
$_SESSION['UserGroup'] = $Settings['GuestGroup']; 
$gidquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"Name\"='%s' LIMIT 1", array($Settings['GuestGroup']));
$gidresult=sql_query($gidquery,$SQLStat);
$_SESSION['UserGroupID']=sql_result($gidresult,0,"id"); 
sql_free_result($gidresult); }
if($_SESSION['MemberName']==null) { $_SESSION['UserID'] = "0";
$_SESSION['UserIP']=$_SERVER['REMOTE_ADDR'];
$_SESSION['UserGroup'] = $Settings['GuestGroup']; 
$gidquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"Name\"='%s' LIMIT 1", array($Settings['GuestGroup']));
$gidresult=sql_query($gidquery,$SQLStat);
$_SESSION['UserGroupID']=sql_result($gidresult,0,"id"); 
sql_free_result($gidresult); }
if($_SESSION['UserID']==0||$_SESSION['UserID']==null) {
 $levnum = 0; }
if($_SESSION['UserID']!=0&&$_SESSION['UserID']!=null) {
$levquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."levels\" WHERE \"id\"=%i LIMIT 1", array($ChkUsrLevelID));
$levresult=sql_query($levquery,$SQLStat);
$levnum=sql_num_rows($levresult);
/*if($levnum<=0) { $GruError = true; sql_free_result($levresult);
header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 503;
ob_clean(); echo "Sorry could not find level data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }*/ }
if($levnum>=1) {
$LevelInfo['ID']=sql_result($levresult,0,"id");
if(!is_numeric($LevelInfo['ID'])) { $GruError = true; }
$LevelInfo['Name']=sql_result($levresult,0,"Name");
$LevelInfo['PromoteTo']=sql_result($levresult,0,"PromoteTo");
$LevelInfo['PromotePosts']=sql_result($levresult,0,"PromotePosts");
if(!is_numeric($LevelInfo['PromotePosts'])) { 
	$LevelInfo['PromotePosts'] = 0; $LevelInfo['PromoteTo'] = 0; }
$LevelInfo['PromoteKarma']=sql_result($levresult,0,"PromoteKarma");
if(!is_numeric($LevelInfo['PromoteKarma'])) { 
	$LevelInfo['PromoteKarma'] = 0; $LevelInfo['PromoteTo'] = 0; } }
if($_SESSION['UserID']==0||$_SESSION['UserID']==null) {
$ranquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."ranks\" WHERE \"id\"=%i LIMIT 1", array($ChkUsrRankID));
$ranresult=sql_query($ranquery,$SQLStat);
$rannum=sql_num_rows($ranresult);
/*if($rannum<=0) { $GruError = true; sql_free_result($ranresult);
header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 503;
ob_clean(); echo "Sorry could not find ranel data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }*/ }
if($rannum>=1) {
$RankInfo['ID']=sql_result($ranresult,0,"id");
if(!is_numeric($RankInfo['ID'])) { $GruError = true; }
$RankInfo['Name']=sql_result($ranresult,0,"Name");
$RankInfo['PromotePosts']=sql_result($ranresult,0,"PromotePosts");
if(!is_numeric($RankInfo['PromotePosts'])) { 
	$RankInfo['PromotePosts'] = 0; }
$RankInfo['PromoteKarma']=sql_result($ranresult,0,"PromoteKarma");
if(!is_numeric($RankInfo['PromoteKarma'])) { 
	$RankInfo['PromoteKarma'] = 0; } }
// Member Group Setup
if(!isset($_SESSION['UserGroup'])) { $_SESSION['UserGroup'] = null; }
if($_SESSION['UserGroup']==null) { 
$_SESSION['UserGroup']=$Settings['GuestGroup']; } $GruError = null;
$gruquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"Name\"='%s' LIMIT 1", array($_SESSION['UserGroup']));
$gruresult=sql_query($gruquery,$SQLStat);
$grunum=sql_num_rows($gruresult);
if($grunum<=0) { $GruError = true; sql_free_result($gruresult);
header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 503;
ob_clean(); echo "Sorry could not find group data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($_SESSION['UserID']!=0) {
$memprequery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."mempermissions\" WHERE \"id\"=%i LIMIT 1", array($_SESSION['UserID'])); }
if($_SESSION['UserID']==0) {
$memprequery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."mempermissions\" WHERE \"id\"=%i LIMIT 1", array(-1)); }
$mempreresult=sql_query($memprequery,$SQLStat);
$memprenum=sql_num_rows($mempreresult);
if($grunum>=1) {
$GroupInfo['ID']=sql_result($gruresult,0,"id");
if(!is_numeric($GroupInfo['ID'])) { $GruError = true; }
$GroupInfo['Name']=sql_result($gruresult,0,"Name");
$GroupInfo['PermissionID']=sql_result($mempreresult,0,"PermissionID");
if(!is_numeric($GroupInfo['PermissionID'])||$GroupInfo['PermissionID']=="0") {
$GroupInfo['PermissionID']=sql_result($gruresult,0,"PermissionID");
if(!is_numeric($GroupInfo['PermissionID'])) { $GruError = true; } }
$GroupInfo['NamePrefix']=sql_result($gruresult,0,"NamePrefix");
$GroupInfo['NameSuffix']=sql_result($gruresult,0,"NameSuffix");
$GroupInfo['CanViewBoard']=sql_result($mempreresult,0,"CanViewBoard");
if($GroupInfo['CanViewBoard']!="yes"&&$GroupInfo['CanViewBoard']!="no"&&$GroupInfo['CanViewBoard']!="group") {
		$GruError = true; }
if($GroupInfo['CanViewBoard']=="group") {
$GroupInfo['CanViewBoard']=sql_result($gruresult,0,"CanViewBoard");
if($GroupInfo['CanViewBoard']!="yes"&&$GroupInfo['CanViewBoard']!="no") {
		$GruError = true; } }
$GroupInfo['CanViewOffLine']=sql_result($mempreresult,0,"CanViewOffLine");
if($GroupInfo['CanViewOffLine']!="yes"&&$GroupInfo['CanViewOffLine']!="no"&&$GroupInfo['CanViewOffLine']!="group") {
		$GruError = true; }
if($GroupInfo['CanViewOffLine']=="group") {
$GroupInfo['CanViewOffLine']=sql_result($gruresult,0,"CanViewOffLine");
if($GroupInfo['CanViewOffLine']!="yes"&&$GroupInfo['CanViewOffLine']!="no") {
		$GruError = true; } }
$GroupInfo['FloodControl']=sql_result($mempreresult,0,"FloodControl");
if(!is_numeric($GroupInfo['FloodControl'])) { $GroupInfo['FloodControl'] = 30; }
if($GroupInfo['FloodControl']==-1) {
$GroupInfo['FloodControl']=sql_result($gruresult,0,"FloodControl");
if(!is_numeric($GroupInfo['FloodControl'])) { $GroupInfo['FloodControl'] = 30; } }
$GroupInfo['SearchFlood']=sql_result($mempreresult,0,"SearchFlood");
if(!is_numeric($GroupInfo['SearchFlood'])) { $GroupInfo['SearchFlood'] = 30; }
if($GroupInfo['SearchFlood']==-1) {
$GroupInfo['SearchFlood']=sql_result($gruresult,0,"SearchFlood");
if(!is_numeric($GroupInfo['SearchFlood'])) { $GroupInfo['SearchFlood'] = 30; } }
$GroupInfo['CanEditProfile']=sql_result($mempreresult,0,"CanEditProfile");
if($GroupInfo['CanEditProfile']!="yes"&&$GroupInfo['CanEditProfile']!="no"&&$GroupInfo['CanEditProfile']!="group") {
		$GruError = true; }
if($GroupInfo['CanEditProfile']=="group") {
$GroupInfo['CanEditProfile']=sql_result($gruresult,0,"CanEditProfile");
if($GroupInfo['CanEditProfile']!="yes"&&$GroupInfo['CanEditProfile']!="no") {
		$GruError = true; } }
$GroupInfo['CanAddEvents']=sql_result($mempreresult,0,"CanAddEvents");
if($GroupInfo['CanAddEvents']!="yes"&&$GroupInfo['CanAddEvents']!="no"&&$GroupInfo['CanAddEvents']!="group") {
		$GruError = true; }
if($GroupInfo['CanAddEvents']=="group") {
$GroupInfo['CanAddEvents']=sql_result($gruresult,0,"CanAddEvents");
if($GroupInfo['CanAddEvents']!="yes"&&$GroupInfo['CanAddEvents']!="no") {
		$GruError = true; } }
$GroupInfo['CanPM']=sql_result($mempreresult,0,"CanPM");
if($GroupInfo['CanPM']!="yes"&&$GroupInfo['CanPM']!="no"&&$GroupInfo['CanPM']!="group") {
		$GruError = true; }
if($GroupInfo['CanPM']=="group") {
$GroupInfo['CanPM']=sql_result($gruresult,0,"CanPM");
if($GroupInfo['CanPM']!="yes"&&$GroupInfo['CanPM']!="no") {
		$GruError = true; } }
$GroupInfo['CanSearch']=sql_result($mempreresult,0,"CanSearch");
if($GroupInfo['CanSearch']!="yes"&&$GroupInfo['CanSearch']!="no"&&$GroupInfo['CanSearch']!="group") {
		$GruError = true; }
if($GroupInfo['CanSearch']=="group") {
$GroupInfo['CanSearch']=sql_result($gruresult,0,"CanSearch");
if($GroupInfo['CanSearch']!="yes"&&$GroupInfo['CanSearch']!="no") {
		$GruError = true; } }
$GroupInfo['CanExecPHP']=sql_result($mempreresult,0,"CanExecPHP");
if($GroupInfo['CanExecPHP']!="yes"&&$GroupInfo['CanExecPHP']!="no"&&$GroupInfo['CanExecPHP']!="group") {
	$GroupInfo['CanExecPHP'] = "no"; }
if($GroupInfo['CanExecPHP']=="group") {
$GroupInfo['CanExecPHP']=sql_result($gruresult,0,"CanExecPHP");
if($GroupInfo['CanExecPHP']!="yes"&&$GroupInfo['CanExecPHP']!="no") {
	$GroupInfo['CanExecPHP'] = "no"; } }
$GroupInfo['CanDoHTML']=sql_result($mempreresult,0,"CanDoHTML");
if($GroupInfo['CanDoHTML']!="yes"&&$GroupInfo['CanDoHTML']!="no"&&$GroupInfo['CanDoHTML']!="group") {
	$GroupInfo['CanDoHTML'] = "no"; }
if($GroupInfo['CanDoHTML']=="group") {
$GroupInfo['CanDoHTML']=sql_result($gruresult,0,"CanDoHTML");
if($GroupInfo['CanDoHTML']!="yes"&&$GroupInfo['CanDoHTML']!="no") {
	$GroupInfo['CanDoHTML'] = "no"; } }
$GroupInfo['CanUseBBTags']=sql_result($mempreresult,0,"CanUseBBTags");
if($GroupInfo['CanUseBBTags']!="yes"&&$GroupInfo['CanUseBBTags']!="no"&&$GroupInfo['CanUseBBTags']!="group") {
	$GroupInfo['CanUseBBTags'] = "no"; }
if($GroupInfo['CanUseBBTags']=="group") {
$GroupInfo['CanUseBBTags']=sql_result($gruresult,0,"CanUseBBTags");
if($GroupInfo['CanUseBBTags']!="yes"&&$GroupInfo['CanUseBBTags']!="no") {
	$GroupInfo['CanUseBBTags'] = "no"; } }
$GroupInfo['PromoteTo']=sql_result($gruresult,0,"PromoteTo");
$GroupInfo['PromotePosts']=sql_result($gruresult,0,"PromotePosts");
if(!is_numeric($GroupInfo['PromotePosts'])) { 
	$GroupInfo['PromotePosts'] = 0; $GroupInfo['PromoteTo'] = 0; }
$GroupInfo['PromoteKarma']=sql_result($gruresult,0,"PromoteKarma");
if(!is_numeric($GroupInfo['PromoteKarma'])) { 
	$GroupInfo['PromoteKarma'] = 0; $GroupInfo['PromoteTo'] = 0; }
if(!isset($Settings['KarmaBoostDays'])) {
	$Settings['KarmaBoostDays'] = null; }
$Settings['OldKarmaBoostDays'] = $Settings['KarmaBoostDays'];
if(!isset($Settings['KBoostPercent'])) {
	$Settings['KBoostPercent'] = "6|10"; }
//Update karma and group upgrade on post count or karma count.
if($_SESSION['UserID']!=0) { $BoostTotal = null;
$KarmaExp = explode("&",$Settings['KarmaBoostDays']);
$KarmaNow = $usercurtime->format("md");
$kupdate = false;
if(in_array($KarmaNow,$KarmaExp)) {
$KarmaNum = count($KarmaExp); 
$Karmai = 0;
while ($Karmai < $KarmaNum) {
if($KarmaExp[$Karmai]==$KarmaNow) { 
$Settings['KarmaBoostDays'] = $KarmaExp[$Karmai]; 
$kupdate = true; break 1; }
++$Karmai; } }
if($kupdate===false) {
$Settings['KarmaBoostDays'] = $KarmaExp[0]; }
$NewKarmaUpdate = $usercurtime->format("Ymd");
$ThisYearUpdate = $usercurtime->format("Y");
if($MyKarmaUpdate<$NewKarmaUpdate&&$MyPostCountChk>0) { 
	$KarmaBoostDay = $Settings['KarmaBoostDays'];
	$KBoostPercent = explode("|",$Settings['KBoostPercent']);
	if(count($KBoostPercent)<1) { 
	$KBoostPercent[0] = rand(1,4); }
	if(!is_numeric($KBoostPercent[0])) {
	$KBoostPercent[0] = 6; }
	if(count($KBoostPercent)==1) { 
	$KBoostPercent[1] = $KBoostPercent[0] + rand(3,6); }
	if(!is_numeric($KBoostPercent[1])) {
	$KBoostPercent[0] = 10; }
	$KBoostPercent = rand($KBoostPercent[0],$KBoostPercent[1]);
	if($ThisYearUpdate.$KarmaBoostDay==$NewKarmaUpdate&&
	is_numeric($KarmaBoostDay)) {
	$KBoostPercent = $KBoostPercent / 100;
	$BoostTotal = $MyKarmaCount * $KBoostPercent;
	$BoostTotal = round($BoostTotal,0); }
	if($BoostTotal!=null) {
	$MyKarmaCount = $MyKarmaCount + $BoostTotal; }
	if($BoostTotal==null) {
	$MyKarmaCount = $MyKarmaCount + 1; }
	$querykarmaup = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"Karma\"=%i,\"KarmaUpdate\"=%i WHERE \"id\"=%i", array($MyKarmaCount,$NewKarmaUpdate,$_SESSION['UserID']));
	sql_query($querykarmaup,$SQLStat); }
	$Settings['KarmaBoostDays'] = $Settings['OldKarmaBoostDays'];
	$sql_rank_check = sql_query(sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."ranks\" WHERE \"PromoteKarma\">=%i AND \"PromotePosts\">=%i AND \"id\"<>%i AND \"id\">0 LIMIT 1", array($MyKarmaCount, $MyPostCountChk, $RankInfo['ID'])),$SQLStat);
	$rank_check = sql_num_rows($sql_rank_check);
	if($rank_check > 0) {
    $NewRankID=sql_result($sql_rank_check,0,"id");
	$queryupgrade = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"RankID\"=%i WHERE \"id\"=%i", array($NewRankID,$_SESSION['UserID']));
	sql_query($queryupgrade,$SQLStat); }
    sql_free_result($sql_rank_check);
if($LevelInfo['PromoteTo']!=0&&$MyPostCountChk>=$LevelInfo['PromotePosts']) {
	$sql_level_check = sql_query(sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."levels\" WHERE \"id\"=%i LIMIT 1", array($LevelInfo['PromoteTo'])),$SQLStat);
	$level_check = sql_num_rows($sql_level_check);
	sql_free_result($sql_level_check);
	if($level_check > 0) {
	$queryupgrade = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"LevelID\"=%i WHERE \"id\"=%i", array($LevelInfo['PromoteTo'],$_SESSION['UserID']));
	sql_query($queryupgrade,$SQLStat); } }
if($LevelInfo['PromotePosts']==0&&$LevelInfo['PromoteTo']!=0&&$MyKarmaCount>=$LevelInfo['PromoteKarma']) {
	$sql_level_check = sql_query(sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."levels\" WHERE \"id\"=%i LIMIT 1", array($LevelInfo['PromoteTo'])),$SQLStat);
	$level_check = sql_num_rows($sql_level_check);
	sql_free_result($sql_level_check);
	if($level_check > 0) {
	$queryupgrade = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"LevelID\"=%i WHERE \"id\"=%i", array($LevelInfo['PromoteTo'],$_SESSION['UserID']));
	sql_query($queryupgrade,$SQLStat); } }
if($GroupInfo['PromoteTo']!=0&&$MyPostCountChk>=$GroupInfo['PromotePosts']) {
	$sql_group_check = sql_query(sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i LIMIT 1", array($GroupInfo['PromoteTo'])),$SQLStat);
	$group_check = sql_num_rows($sql_group_check);
	sql_free_result($sql_group_check);
	if($group_check > 0) {
	$queryupgrade = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"GroupID\"=%i WHERE \"id\"=%i", array($GroupInfo['PromoteTo'],$_SESSION['UserID']));
	sql_query($queryupgrade,$SQLStat); } }
if($GroupInfo['PromotePosts']==0&&$GroupInfo['PromoteTo']!=0&&$MyKarmaCount>=$GroupInfo['PromoteKarma']) {
	$sql_group_check = sql_query(sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i LIMIT 1", array($GroupInfo['PromoteTo'])),$SQLStat);
	$group_check = sql_num_rows($sql_group_check);
	sql_free_result($sql_group_check);
	if($group_check > 0) {
	$queryupgrade = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"GroupID\"=%i WHERE \"id\"=%i", array($GroupInfo['PromoteTo'],$_SESSION['UserID']));
	sql_query($queryupgrade,$SQLStat); } } }
$GroupInfo['HasModCP']=sql_result($mempreresult,0,"HasModCP");
if($GroupInfo['HasModCP']!="yes"&&$GroupInfo['HasModCP']!="no"&&$GroupInfo['HasModCP']!="group") {
	$GroupInfo['HasModCP'] = "no"; }
if($GroupInfo['HasModCP']=="group") {
$GroupInfo['HasModCP']=sql_result($gruresult,0,"HasModCP");
if($GroupInfo['HasModCP']!="yes"&&$GroupInfo['HasModCP']!="no") {
	$GroupInfo['HasModCP'] = "no"; } }
$GroupInfo['HasAdminCP']=sql_result($mempreresult,0,"HasAdminCP");
if($GroupInfo['HasAdminCP']!="yes"&&$GroupInfo['HasAdminCP']!="no"&&$GroupInfo['HasAdminCP']!="group") {
	$GroupInfo['HasAdminCP'] = "no"; }
if($GroupInfo['HasAdminCP']=="group") {
$GroupInfo['HasAdminCP']=sql_result($gruresult,0,"HasAdminCP");
if($GroupInfo['HasAdminCP']!="yes"&&$GroupInfo['HasAdminCP']!="no") {
	$GroupInfo['HasAdminCP'] = "no"; } }
$GroupInfo['CanViewIPAddress']=sql_result($mempreresult,0,"CanViewIPAddress");
if($GroupInfo['CanViewIPAddress']!="yes"&&$GroupInfo['CanViewIPAddress']!="no"&&$GroupInfo['CanViewIPAddress']!="group") {
	$GroupInfo['CanViewIPAddress'] = "no"; }
if($GroupInfo['CanViewIPAddress']=="group") {
$GroupInfo['CanViewIPAddress']=sql_result($gruresult,0,"CanViewIPAddress");
if($GroupInfo['CanViewIPAddress']!="yes"&&$GroupInfo['CanViewIPAddress']!="no") {
	$GroupInfo['CanViewIPAddress'] = "no"; } }
$GroupInfo['CanViewUserAgent']=sql_result($mempreresult,0,"CanViewUserAgent");
if($GroupInfo['CanViewUserAgent']!="yes"&&$GroupInfo['CanViewUserAgent']!="no"&&$GroupInfo['CanViewUserAgent']!="group") {
	$GroupInfo['CanViewUserAgent'] = "no"; }
if($GroupInfo['CanViewUserAgent']=="group") {
$GroupInfo['CanViewUserAgent']=sql_result($gruresult,0,"CanViewUserAgent");
if($GroupInfo['CanViewUserAgent']!="yes"&&$GroupInfo['CanViewUserAgent']!="no") {
	$GroupInfo['CanViewUserAgent'] = "no"; } }
$GroupInfo['ViewDBInfo']=sql_result($mempreresult,0,"ViewDBInfo");
if($GroupInfo['ViewDBInfo']!="yes"&&$GroupInfo['ViewDBInfo']!="no"&&$GroupInfo['ViewDBInfo']!="group") {
	$GroupInfo['ViewDBInfo'] = "no"; }
if($GroupInfo['ViewDBInfo']=="group") {
$GroupInfo['ViewDBInfo']=sql_result($gruresult,0,"ViewDBInfo"); 
if($GroupInfo['ViewDBInfo']!="yes"&&$GroupInfo['ViewDBInfo']!="no") {
	$GroupInfo['ViewDBInfo'] = "no"; } }
if($GruError==true) {
header("Content-Type: text/plain; charset=".$Settings['charset']); 
sql_free_result($gruresult); sql_free_result($levresult); sql_free_result($mempreresult); $urlstatus = 503;
ob_clean(); echo "Sorry could not load all group data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); } }
sql_free_result($gruresult);
if($_SESSION['UserID']!=0&&$_SESSION['UserID']!=null) {
 sql_free_result($levresult); }
if($GroupInfo['CanViewBoard']=="no") { 
header("Content-Type: text/plain; charset=".$Settings['charset']); 
ob_clean(); echo "Sorry you can not view the board."; $urlstatus = 503;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
// Member Group Permissions Setup
$perquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."permissions\" WHERE \"PermissionID\"=%i ORDER BY \"ForumID\" ASC", array($GroupInfo['PermissionID']));
$peresult=sql_query($perquery,$SQLStat);
$pernum=sql_num_rows($peresult);
$peri=0; $PerError = null;
if($pernum<0) { $PerError = true; sql_free_result($peresult);
header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 503;
ob_clean(); echo "Sorry could not find permission data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$ForumIgnoreList1 = null; $ForumIgnoreList2 = null;
$ForumIgnoreList3 = null; $ForumIgnoreList4 = null;
$ForumIgnoreList5 = null; $ForumIgnoreList6 = null;
$ModForumIgnoreList1 = null; $ModForumIgnoreList2 = null;
$ModForumIgnoreList3 = null; $ModForumIgnoreList4 = null;
if($pernum>=1) { while ($peri < $pernum) {
$PerForumID=sql_result($peresult,$peri,"ForumID");
if(!is_numeric($PerForumID)) { $PerError = true; }
$PermissionInfo['ID'][$PerForumID]=sql_result($peresult,$peri,"id");
if(!is_numeric($PermissionInfo['ID'][$PerForumID])) { $PerError = true; }
$PermissionInfo['PermissionID'][$PerForumID]=sql_result($peresult,$peri,"PermissionID");
if(!is_numeric($PermissionInfo['PermissionID'][$PerForumID])) { $PerError = true; }
$PermissionInfo['Name'][$PerForumID]=sql_result($peresult,$peri,"Name");
$PermissionInfo['ForumID'][$PerForumID]=sql_result($peresult,$peri,"ForumID");
if(!is_numeric($PermissionInfo['ForumID'][$PerForumID])) { $PerError = true; }
$PermissionInfo['CanViewForum'][$PerForumID]=sql_result($peresult,$peri,"CanViewForum");
if($PermissionInfo['CanViewForum'][$PerForumID]!="yes"&&$PermissionInfo['CanViewForum'][$PerForumID]!="no") {
		$PerError = true; }
if($PermissionInfo['CanViewForum'][$PerForumID]=="no") {
if(strlen($ForumIgnoreList1)>1) { $ForumIgnoreList1 .= " AND \"id\"<>".$PerForumID; }
if(strlen($ForumIgnoreList1)<1) { $ForumIgnoreList1 = " \"id\"<>".$PerForumID; }
if(strlen($ForumIgnoreList2)>1) { $ForumIgnoreList2 .= " AND \"id\"<>".$PerForumID; }
if(strlen($ForumIgnoreList2)<1) { $ForumIgnoreList2 = " AND \"id\"<>".$PerForumID; }
if(strlen($ForumIgnoreList3)>1) { $ForumIgnoreList3 .= " AND \"ForumID\"<>".$PerForumID; }
if(strlen($ForumIgnoreList3)<1) { $ForumIgnoreList3 = " WHERE \"ForumID\"<>".$PerForumID; }
if(strlen($ForumIgnoreList4)>1) { $ForumIgnoreList4 .= " AND \"ForumID\"<>".$PerForumID; }
if(strlen($ForumIgnoreList4)<1) { $ForumIgnoreList4 = " AND \"ForumID\"<>".$PerForumID; }
if(strlen($ForumIgnoreList5)>1) { $ForumIgnoreList5 .= " AND \"OldForumID\"<>".$PerForumID; }
if(strlen($ForumIgnoreList5)<1) { $ForumIgnoreList5 = " WHERE \"OldForumID\"<>".$PerForumID; }
if(strlen($ForumIgnoreList6)>1) { $ForumIgnoreList6 .= " AND \"OldForumID\"<>".$PerForumID; }
if(strlen($ForumIgnoreList6)<1) { $ForumIgnoreList6 = " AND \"OldForumID\"<>".$PerForumID; } }
$PermissionInfo['CanMakePolls'][$PerForumID]=sql_result($peresult,$peri,"CanMakePolls");
if($PermissionInfo['CanMakePolls'][$PerForumID]!="yes"&&$PermissionInfo['CanMakePolls'][$PerForumID]!="no") {
		$PerError = true; }
$PermissionInfo['CanMakeTopics'][$PerForumID]=sql_result($peresult,$peri,"CanMakeTopics");
if($PermissionInfo['CanMakeTopics'][$PerForumID]!="yes"&&$PermissionInfo['CanMakeTopics'][$PerForumID]!="no") {
		$PerError = true; }
$PermissionInfo['CanMakeReplys'][$PerForumID]=sql_result($peresult,$peri,"CanMakeReplys");
if($PermissionInfo['CanMakeReplys'][$PerForumID]!="yes"&&$PermissionInfo['CanMakeReplys'][$PerForumID]!="no") {
		$PerError = true; }
$PermissionInfo['CanMakeReplysClose'][$PerForumID]=sql_result($peresult,$peri,"CanMakeReplysCT");
if($PermissionInfo['CanMakeReplysClose'][$PerForumID]!="yes"&&$PermissionInfo['CanMakeReplysClose'][$PerForumID]!="no") {
		$PerError = true; }
$PermissionInfo['CanEditTopics'][$PerForumID]=sql_result($peresult,$peri,"CanEditTopics");
if($PermissionInfo['CanEditTopics'][$PerForumID]!="yes"&&$PermissionInfo['CanEditTopics'][$PerForumID]!="no") {
	$PermissionInfo['CanEditTopics'][$PerForumID] = "no"; }
$PermissionInfo['CanEditTopicsClose'][$PerForumID]=sql_result($peresult,$peri,"CanEditTopicsCT");
if($PermissionInfo['CanEditTopicsClose'][$PerForumID]!="yes"&&$PermissionInfo['CanEditTopicsClose'][$PerForumID]!="no") {
	$PermissionInfo['CanEditTopicsClose'][$PerForumID] = "no"; }
$PermissionInfo['CanEditReplys'][$PerForumID]=sql_result($peresult,$peri,"CanEditReplys");
if($PermissionInfo['CanEditReplys'][$PerForumID]!="yes"&&$PermissionInfo['CanEditReplys'][$PerForumID]!="no") {
	$PermissionInfo['CanEditReplys'][$PerForumID] = "no"; }
$PermissionInfo['CanEditReplysClose'][$PerForumID]=sql_result($peresult,$peri,"CanEditReplysCT");
if($PermissionInfo['CanEditReplysClose'][$PerForumID]!="yes"&&$PermissionInfo['CanEditReplysClose'][$PerForumID]!="no") {
	$PermissionInfo['CanEditReplysClose'][$PerForumID] = "no"; }
$PermissionInfo['CanDeleteTopics'][$PerForumID]=sql_result($peresult,$peri,"CanDeleteTopics");
if($PermissionInfo['CanDeleteTopics'][$PerForumID]!="yes"&&$PermissionInfo['CanDeleteTopics'][$PerForumID]!="no") {
	$PermissionInfo['CanDeleteTopics'][$PerForumID] = "no"; }
$PermissionInfo['CanDeleteTopicsClose'][$PerForumID]=sql_result($peresult,$peri,"CanDeleteTopicsCT");
if($PermissionInfo['CanDeleteTopicsClose'][$PerForumID]!="yes"&&$PermissionInfo['CanDeleteTopicsClose'][$PerForumID]!="no") {
	$PermissionInfo['CanDeleteTopicsClose'][$PerForumID] = "no"; }
$PermissionInfo['CanDeleteReplys'][$PerForumID]=sql_result($peresult,$peri,"CanDeleteReplys");
if($PermissionInfo['CanDeleteReplys'][$PerForumID]!="yes"&&$PermissionInfo['CanDeleteReplys'][$PerForumID]!="no") {
	$PermissionInfo['CanDeleteReplys'][$PerForumID] = "no"; }
$PermissionInfo['CanDeleteReplysClose'][$PerForumID]=sql_result($peresult,$peri,"CanDeleteReplysCT");
if($PermissionInfo['CanDeleteReplysClose'][$PerForumID]!="yes"&&$PermissionInfo['CanDeleteReplysClose'][$PerForumID]!="no") {
	$PermissionInfo['CanDeleteReplysClose'][$PerForumID] = "no"; }
$PermissionInfo['CanCloseTopics'][$PerForumID]=sql_result($peresult,$peri,"CanCloseTopics");
if($PermissionInfo['CanCloseTopics'][$PerForumID]!="yes"&&$PermissionInfo['CanCloseTopics'][$PerForumID]!="no") {
	$PermissionInfo['CanCloseTopics'][$PerForumID] = "no"; }
$PermissionInfo['CanPinTopics'][$PerForumID]=sql_result($peresult,$peri,"CanPinTopics");
if($PermissionInfo['CanPinTopics'][$PerForumID]!="yes"&&$PermissionInfo['CanPinTopics'][$PerForumID]!="no") {
	$PermissionInfo['CanPinTopics'][$PerForumID] = "no"; }
$PermissionInfo['CanDoHTML'][$PerForumID]=sql_result($peresult,$peri,"CanDoHTML");
if($PermissionInfo['CanDoHTML'][$PerForumID]!="yes"&&$PermissionInfo['CanDoHTML'][$PerForumID]!="no") {
	$PermissionInfo['CanDoHTML'][$PerForumID] = "no"; }
$PermissionInfo['CanUseBBTags'][$PerForumID]=sql_result($peresult,$peri,"CanUseBBTags");
if($PermissionInfo['CanUseBBTags'][$PerForumID]!="yes"&&$PermissionInfo['CanUseBBTags'][$PerForumID]!="no") {
	$PermissionInfo['CanUseBBTags'][$PerForumID] = "no"; }
$PermissionInfo['CanModForum'][$PerForumID]=sql_result($peresult,$peri,"CanModForum");
if($PermissionInfo['CanModForum'][$PerForumID]!="yes"&&$PermissionInfo['CanModForum'][$PerForumID]!="no") {
	$PermissionInfo['CanModForum'][$PerForumID] = "no"; }
if($PermissionInfo['CanModForum'][$PerForumID]=="no") {
if(isset($ModForumIgnoreList1)) {
if(strlen($ModForumIgnoreList1)>1) { $ModForumIgnoreList1 .= " AND \"id\"<>".$PerForumID; }
if(strlen($ModForumIgnoreList1)<1) { $ModForumIgnoreList1 = " \"id\"<>".$PerForumID; } }
if(isset($ModForumIgnoreList2)) {
if(strlen($ModForumIgnoreList2)>1) { $ModForumIgnoreList2 .= " AND \"id\"<>".$PerForumID; }
if(strlen($ModForumIgnoreList2)<1) { $ModForumIgnoreList2 = " AND \"id\"<>".$PerForumID; } }
if(isset($ModForumIgnoreList3)) {
if(strlen($ModForumIgnoreList3)>1) { $ModForumIgnoreList3 .= " AND \"ForumID\"<>".$PerForumID; }
if(strlen($ModForumIgnoreList3)<1) { $ModForumIgnoreList3 = " WHERE \"ForumID\"<>".$PerForumID; } }
if(isset($ModForumIgnoreList4)) {
if(strlen($ModForumIgnoreList4)>1) { $ModForumIgnoreList4 .= " AND \"ForumID\"<>".$PerForumID; }
if(strlen($ModForumIgnoreList4)<1) { $ModForumIgnoreList4 = " AND \"ForumID\"<>".$PerForumID; } } }
if($PerError===true) { $peri = $pernum; }
++$peri; } if($PerError===true) {
header("Content-Type: text/plain; charset=".$Settings['charset']); sql_free_result($peresult); $urlstatus = 503;
ob_clean(); echo "Sorry could not load all permission data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); } }
sql_free_result($peresult);
$per2query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."catpermissions\" WHERE \"PermissionID\"=%i ORDER BY \"CategoryID\" ASC", array($GroupInfo['PermissionID']));
$per2esult=sql_query($per2query,$SQLStat);
$per2num=sql_num_rows($per2esult);
$per2i=0; $Per2Error = null;
if($per2num<=0) { $Per2Error = true; sql_free_result($per2esult);
header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 503;
ob_clean(); echo "Sorry could not find permission data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$CatIgnoreList1 = null; $CatIgnoreList2 = null;
$CatIgnoreList3 = null; $CatIgnoreList4 = null;
$CatIgnoreList5 = null; $CatIgnoreList6 = null;
if($per2num>=1) { while ($per2i < $per2num) {
$PerCatID=sql_result($per2esult,$per2i,"CategoryID");
if(!is_numeric($PerCatID)) { $Per2Error = true; }
$CatPermissionInfo['ID'][$PerCatID]=sql_result($per2esult,$per2i,"id");
if(!is_numeric($CatPermissionInfo['ID'][$PerCatID])) { $Per2Error = true; }
$CatPermissionInfo['PermissionID'][$PerCatID]=sql_result($per2esult,$per2i,"PermissionID");
if(!is_numeric($CatPermissionInfo['PermissionID'][$PerCatID])) { $Per2Error = true; }
$CatPermissionInfo['Name'][$PerCatID]=sql_result($per2esult,$per2i,"Name");
$CatPermissionInfo['CategoryID'][$PerCatID]=sql_result($per2esult,$per2i,"CategoryID");
if(!is_numeric($CatPermissionInfo['CategoryID'][$PerCatID])) { $Per2Error = true; }
$CatPermissionInfo['CanViewCategory'][$PerCatID]=sql_result($per2esult,$per2i,"CanViewCategory");
if($CatPermissionInfo['CanViewCategory'][$PerCatID]!="yes"&&$CatPermissionInfo['CanViewCategory'][$PerCatID]!="no") { $Per2Error = true; }
if($CatPermissionInfo['CanViewCategory'][$PerCatID]=="no") {
if(strlen($CatIgnoreList1)>1) { $CatIgnoreList1 .= " AND \"id\"<>".$PerCatID; }
if(strlen($CatIgnoreList1)<1) { $CatIgnoreList1 = " \"id\"<>".$PerCatID; }
if(strlen($CatIgnoreList2)>1) { $CatIgnoreList2 .= " AND \"id\"<>".$PerCatID; }
if(strlen($CatIgnoreList2)<1) { $CatIgnoreList2 = " AND \"id\"<>".$PerCatID; }
if(strlen($CatIgnoreList3)>1) { $CatIgnoreList3 .= " AND \"CategoryID\"<>".$PerCatID; }
if(strlen($CatIgnoreList3)<1) { $CatIgnoreList3 = " WHERE \"CategoryID\"<>".$PerCatID; }
if(strlen($CatIgnoreList4)>1) { $CatIgnoreList4 .= " AND \"CategoryID\"<>".$PerCatID; }
if(strlen($CatIgnoreList4)<1) { $CatIgnoreList4 = " AND \"CategoryID\"<>".$PerCatID; }
if(strlen($CatIgnoreList5)>1) { $CatIgnoreList5 .= " AND \"OldCategoryID\"<>".$PerCatID; }
if(strlen($CatIgnoreList5)<1) { $CatIgnoreList5 = " WHERE \"OldCategoryID\"<>".$PerCatID; }
if(strlen($CatIgnoreList6)>1) { $CatIgnoreList6 .= " AND \"OldCategoryID\"<>".$PerCatID; }
if(strlen($CatIgnoreList6)<1) { $CatIgnoreList6 = " AND \"OldCategoryID\"<>".$PerCatID; } }
if($Per2Error===true) { $per2i = $per2num; }
++$per2i; } if($Per2Error===true) {
header("Content-Type: text/plain; charset=".$Settings['charset']); sql_free_result($per2esult); $urlstatus = 503;
ob_clean(); echo "Sorry could not load all permission data in database.\nContact the board admin about error."; 
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); } }
sql_free_result($per2esult);
?>