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

    $FileInfo: replies.php - Last Update: 6/22/2023 SVN 984 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="replies.php"||$File3Name=="/replies.php") {
	require('index.php');
	exit(); }
$pstring = null; $pagenum = null;
if(!is_numeric($_GET['id'])) { $_GET['id'] = null; }
if(!is_numeric($_GET['post'])) { $_GET['post'] = null; }
if(!is_numeric($_GET['page'])) { $_GET['page'] = 1; }
if(!isset($_GET['st'])) { $_GET['st'] = 0; }
if(!is_numeric($_GET['st'])) { $_GET['st'] = 0; }
if(!isset($_GET['modact'])) { $_GET['modact'] = null; }
if(!isset($_GET['link'])) { $_GET['link'] = "no"; } 
if(!isset($_GET['level'])) { $_GET['level'] = 1; } 
if(!is_numeric($_GET['level'])) { $_GET['level'] = 1; }
if($_GET['link']!="yes"&&$_GET['link']!="no") { $_GET['link'] = "no"; }
if($_GET['modact']=="pin"||$_GET['modact']=="unpin"||$_GET['modact']=="open"||
	$_GET['modact']=="move"||$_GET['modact']=="close"||$_GET['modact']=="edit"||
	$_GET['modact']=="delete"||$_GET['modact']=="announce")
		{ $_GET['act'] = $_GET['modact']; }
if($_GET['act']=="announce") { $_GET['act'] = "pin"; $_GET['level'] = 2; }
$prequery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i".$ForumIgnoreList4." LIMIT 1", array($_GET['id']));
$preresult=sql_query($prequery,$SQLStat);
$prenum=sql_num_rows($preresult);
if($prenum==0) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($prenum>=1) {
$TopicName=sql_result($preresult,0,"TopicName");
$TopicID=sql_result($preresult,0,"id");
$TopicForumID=sql_result($preresult,0,"ForumID");
$TopicCatID=sql_result($preresult,0,"CategoryID");
$TopicClosed=sql_result($preresult,0,"Closed");
if($TopicClosed==3&&$PermissionInfo['CanModForum'][$TopicForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if(!isset($_GET['post'])||$_GET['post']!==null) {
$NumberReplies=sql_result($preresult,0,"NumReply"); }
if(isset($_GET['post'])&&$_GET['post']!==null) {
$NumberReplies=1; }
$ViewTimes=sql_result($preresult,0,"NumViews");
sql_free_result($preresult);
$forumcheckx = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."forums\" WHERE \"id\"=%i".$ForumIgnoreList2."  LIMIT 1", array($TopicForumID));
$fmckresult=sql_query($forumcheckx,$SQLStat);
$fmcknum=sql_num_rows($fmckresult);
if($fmcknum==0) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$ForumID=sql_result($fmckresult,0,"id");
$ForumName=sql_result($fmckresult,0,"Name");
$ForumType=sql_result($fmckresult,0,"ForumType");
$ForumShow=sql_result($fmckresult,0,"ShowForum");
$InSubForum=sql_result($fmckresult,0,"InSubForum");
if($InSubForum!=0) {
$subforumcheckx = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."forums\" WHERE \"id\"=%i".$ForumIgnoreList2."  LIMIT 1", array($InSubForum));
$subfmckresult=sql_query($subforumcheckx,$SQLStat);
$subfmcknum=sql_num_rows($subfmckresult);
$SubForumName=sql_result($subfmckresult,0,"Name");
$SubForumType=sql_result($subfmckresult,0,"ForumType");
$SubForumShow=sql_result($subfmckresult,0,"ShowForum");
sql_free_result($subfmckresult); }
if($ForumShow=="no") { $_SESSION['ShowActHidden'] = "yes"; }
$CanHaveTopics=sql_result($fmckresult,0,"CanHaveTopics");
$ForumPostCountView=sql_result($fmckresult,0,"PostCountView");
$ForumKarmaCountView=sql_result($fmckresult,0,"KarmaCountView");
sql_free_result($fmckresult);
$catcheck = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."categories\" WHERE \"id\"=%i".$CatIgnoreList2."  LIMIT 1", array($TopicCatID));
$catresult=sql_query($catcheck,$SQLStat);
$CategoryID=sql_result($catresult,0,"id");
$CategoryName=sql_result($catresult,0,"Name");
$CategoryShow=sql_result($catresult,0,"ShowCategory");
if($CategoryShow=="no") { $_SESSION['ShowActHidden'] = "yes"; }
$CategoryType=sql_result($catresult,0,"CategoryType");
$InSubCategory=sql_result($catresult,0,"InSubCategory");
$CategoryPostCountView=sql_result($catresult,0,"PostCountView");
$CategoryKarmaCountView=sql_result($catresult,0,"KarmaCountView");
sql_free_result($catresult);
if($GroupInfo['HasAdminCP']!="yes"||$GroupInfo['HasModCP']!="yes") {
if($MyPostCountChk==null) { $MyPostCountChk = 0; }
if($MyKarmaCount==null) { $MyKarmaCount = 0; }
if($ForumPostCountView!=0&&$MyPostCountChk<$ForumPostCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($CategoryPostCountView!=0&&$MyPostCountChk<$CategoryPostCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($ForumKarmaCountView!=0&&$MyKarmaCount<$ForumKarmaCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($CategoryKarmaCountView!=0&&$MyKarmaCount<$CategoryKarmaCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); } }
if($ForumCheck!="skip") {
?>
<div class="NavLinks"><?php echo $ThemeSet['NavLinkIcon']; ?><a href="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>"><?php echo $Settings['board_name']; ?></a><?php echo $ThemeSet['NavLinkDivider']; ?><a href="<?php echo url_maker($exfile[$CategoryType],$Settings['file_ext'],"act=view&id=".$TopicCatID,$Settings['qstr'],$Settings['qsep'],$prexqstr[$CategoryType],$exqstr[$CategoryType]); ?>"><?php echo $CategoryName; ?></a><?php echo $ThemeSet['NavLinkDivider']; if($InSubForum!=0 && $subfmcknum>0) { ?><a href="<?php echo url_maker($exfile[$ForumType],$Settings['file_ext'],"act=view&id=".$InSubForum."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr[$ForumType],$exqstr[$ForumType]); ?>"><?php echo $SubForumName; ?></a><?php echo $ThemeSet['NavLinkDivider']; } ?><a href="<?php echo url_maker($exfile[$ForumType],$Settings['file_ext'],"act=view&id=".$TopicForumID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr[$ForumType],$exqstr[$ForumType]); ?>"><?php echo $ForumName; ?></a><?php echo $ThemeSet['NavLinkDivider']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></div>
<div class="DivNavLinks">&#160;</div>
<?php }
if(!isset($CatPermissionInfo['CanViewCategory'][$TopicCatID])) {
	$CatPermissionInfo['CanViewCategory'][$TopicCatID] = "no"; }
if($CatPermissionInfo['CanViewCategory'][$TopicCatID]=="no"||
	$CatPermissionInfo['CanViewCategory'][$TopicCatID]!="yes") {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if(!isset($PermissionInfo['CanViewForum'][$TopicForumID])) {
	$PermissionInfo['CanViewForum'][$TopicForumID] = "no"; }
if($PermissionInfo['CanViewForum'][$TopicForumID]=="no"||
	$PermissionInfo['CanViewForum'][$TopicForumID]!="yes") {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($_GET['act']!="view") { 
$CanMakeReply = "no"; $CanMakeTopic = "no";
if($PermissionInfo['CanMakeTopics'][$TopicForumID]=="yes"&&$CanHaveTopics=="yes") { 
	$CanMakeTopic = "yes"; }
if($TopicClosed==0&&$PermissionInfo['CanMakeReplys'][$TopicForumID]=="yes") {
	$CanMakeReply = "yes"; }
if($TopicClosed==1&&$PermissionInfo['CanMakeReplysClose'][$TopicForumID]=="yes"
	&&$PermissionInfo['CanMakeReplys'][$TopicForumID]=="yes") {
		$CanMakeReply = "yes"; } ?>
<table style="width: 100%;" class="Table2">
<tr>
 <td style="width: 30%; text-align: left;"><?php echo $pstring; ?></td>
 <td style="width: 70%; text-align: right;">
 <?php if($CatPermissionInfo['CanViewCategory'][$TopicCatID]=="yes"&&$PermissionInfo['CanViewForum'][$TopicForumID]=="yes") {
 if($CanMakeReply=="yes") { ?>
 <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=create&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $ThemeSet['AddReply']; ?></a>
 <?php } if($PermissionInfo['CanMakeTopics'][$TopicForumID]=="yes") {
	if($CanMakeTopic=="yes"&&$CanMakeReply=="yes") { ?>
 <?php echo $ThemeSet['ButtonDivider']; } ?>
 <a href="<?php echo url_maker($exfile['forum'],$Settings['file_ext'],"act=create&id=".$TopicForumID,$Settings['qstr'],$Settings['qsep'],$prexqstr['forum'],$exqstr['forum']); ?>"><?php echo $ThemeSet['NewTopic']; ?></a>
 <?php } ?></td>
</tr>
</table>
<div class="DivTable2">&#160;</div>
<?php } } if($_GET['act']=="view") {
if($ForumCheck!="skip") {
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
$_SESSION['ViewingPage'] = url_maker(null,"no+ext","act=view&id=".$_GET['id']."&page=".$_GET['page'],"&","=",$prexqstr['topic'],$exqstr['topic']);
if($Settings['file_ext']!="no+ext"&&$Settings['file_ext']!="no ext") {
$_SESSION['ViewingFile'] = $exfile['topic'].$Settings['file_ext']; }
if($Settings['file_ext']=="no+ext"||$Settings['file_ext']=="no ext") {
$_SESSION['ViewingFile'] = $exfile['topic']; }
$_SESSION['PreViewingTitle'] = "Viewing Topic:";
$_SESSION['ViewingTitle'] = $TopicName; 
$_SESSION['ExtraData'] = "currentact:".$_GET['act']."; currentcategoryid:".$InSubCategory.",".$CategoryID."; currentforumid:".$InSubForum.",".$ForumID."; currenttopicid:".$TopicID."; currentmessageid:0; currenteventid:0; currentmemberid:0;"; }
if($NumberReplies==null) { 
	$NumberReplies = 0; }
$num=$NumberReplies+1;
//Start Reply Page Code
if(!isset($Settings['max_posts'])) { $Settings['max_posts'] = 10; }
if($_GET['page']==null) { $_GET['page'] = 1; } 
if($_GET['page']<=0) { $_GET['page'] = 1; }
if($_GET['st']<=0||!isset($_GET['st'])) {
$nums = $_GET['page'] * $Settings['max_posts']; }
if($_GET['st']>0&&isset($_GET['st'])) {
$nums = $_GET['st']; }
if($nums>$num) { $nums = $num; }
$numz = $nums - $Settings['max_posts'];
if($numz<=0) { $numz = 0; }
//$i=$numz;
if($nums<$num) { $nextpage = $_GET['page'] + 1; }
if($nums>=$num) { $nextpage = $_GET['page']; }
if($numz>=$Settings['max_posts']) { $backpage = $_GET['page'] - 1; }
if($_GET['page']<=1) { $backpage = 1; }
$pnum = $num; $l = 1; $Pages = array();;
while ($pnum>0) {
if($pnum>=$Settings['max_posts']) { 
	$pnum = $pnum - $Settings['max_posts']; 
	$Pages[$l] = $l; ++$l; }
if($pnum<$Settings['max_posts']&&$pnum>0) { 
	$pnum = $pnum - $pnum; 
	$Pages[$l] = $l; ++$l; } }
$snumber = $_GET['page'] - 1;
if($_GET['st']<=0||!isset($_GET['st'])) {
$PageLimit = $Settings['max_posts'] * $snumber; }
if($_GET['st']>0&&isset($_GET['st'])) {
$PageLimit = $_GET['st']; }
if($PageLimit<0) { $PageLimit = 0; }
//End Reply Page Code
$i=0;
if(!isset($_GET['post'])||$_GET['post']!==null) {
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i ORDER BY \"TimeStamp\" ASC ".$SQLimit, array($_GET['id'],$PageLimit,$Settings['max_posts'])); }
if(isset($_GET['post'])&&$_GET['post']!==null) {
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i AND \"id\"=%i ORDER BY \"TimeStamp\" ASC ".$SQLimit, array($_GET['id'],$_GET['post'],$PageLimit,$Settings['max_posts'])); }
$result=sql_query($query,$SQLStat);
$num=sql_num_rows($result);
if($num==0) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($num!=0) { 
if($ViewTimes==0||$ViewTimes==null) { $NewViewTimes = 1; }
if($ViewTimes!=0&&$ViewTimes!=null) { $NewViewTimes = $ViewTimes + 1; }
$viewsup = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"NumViews\"='%s' WHERE \"id\"=%i", array($NewViewTimes,$_GET['id']));
sql_query($viewsup,$SQLStat); }
//List Page Number Code Start
$pagenum=count($Pages);
if($_GET['page']>$pagenum) {
	$_GET['page'] = $pagenum; }
$pagei=0; $pstring = null;
if($pagenum>1) {
$pstring = "<div class=\"PageList\"><span class=\"pagelink\">".$pagenum." Pages:</span> "; }
if($_GET['page']<4) { $Pagez[0] = null; }
if($_GET['page']>=4) { $Pagez[0] = "First"; }
if($_GET['page']>=3) {
$Pagez[1] = $_GET['page'] - 2; }
if($_GET['page']<3) {
$Pagez[1] = null; }
if($_GET['page']>=2) {
$Pagez[2] = $_GET['page'] - 1; }
if($_GET['page']<2) {
$Pagez[2] = null; }
$Pagez[3] = $_GET['page'];
if($_GET['page']<$pagenum) {
$Pagez[4] = $_GET['page'] + 1; }
if($_GET['page']>=$pagenum) {
$Pagez[4] = null; }
$pagenext = $_GET['page'] + 1;
if($pagenext<$pagenum) {
$Pagez[5] = $_GET['page'] + 2; }
if($pagenext>=$pagenum) {
$Pagez[5] = null; }
if($_GET['page']<$pagenum) { $Pagez[6] = "Last"; }
if($_GET['page']>=$pagenum) { $Pagez[6] = null; }
$pagenumi=count($Pagez);
if($num==0) {
$pagenumi = 0;
$pstring = null; }
if($pagenum>1) {
while ($pagei < $pagenumi) {
if($_GET['page']!=1&&$pagei==1) {
$Pback = $_GET['page'] - 1;
$pstring = $pstring."<span class=\"pagelink\"><a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$Pback,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">&lt;</a></span> "; }
if($Pagez[$pagei]!=null&&
   $Pagez[$pagei]!="First"&&
   $Pagez[$pagei]!="Last") {
if($pagei!=3) { 
$pstring = $pstring."<span class=\"pagelink\"><a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$Pagez[$pagei],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">".$Pagez[$pagei]."</a></span> "; }
if($pagei==3) { 
$pstring = $pstring."<span class=\"pagecurrent\"><a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$Pagez[$pagei],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">".$Pagez[$pagei]."</a></span> "; } }
if($Pagez[$pagei]=="First") {
$pstring = $pstring."<span class=\"pagelinklast\"><a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">&laquo;</a></span> "; }
if($Pagez[$pagei]=="Last") {
$ptestnext = $pagenext + 1;
$paget = $pagei - 1;
$Pnext = $_GET['page'] + 1;
$pstring = $pstring."<span class=\"pagelink\"><a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$Pnext,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">&gt;</a></span> ";
if($ptestnext<$pagenum) {
$pstring = $pstring."<span class=\"pagelinklast\"><a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$pagenum,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">&raquo;</a></span> "; } }
	++$pagei; } $pstring = $pstring."</div>"; }
//List Page Number Code end
$CanMakeReply = "no"; $CanMakeTopic = "no";
if($PermissionInfo['CanMakeTopics'][$TopicForumID]=="yes"&&$CanHaveTopics=="yes") { 
	$CanMakeTopic = "yes"; }
if($TopicClosed==0&&$PermissionInfo['CanMakeReplys'][$TopicForumID]=="yes") {
	$CanMakeReply = "yes"; }
if($TopicClosed==1&&$PermissionInfo['CanMakeReplysClose'][$TopicForumID]=="yes"
	&&$PermissionInfo['CanMakeReplys'][$TopicForumID]=="yes") {
		$CanMakeReply = "yes"; }
if($pstring!=null||$CanMakeReply=="yes"||$CanMakeTopic=="yes") {
?>
<table style="width: 100%;" class="Table2">
<tr>
 <td style="width: 30%; text-align: left;"><?php echo $pstring; ?></td>
 <td style="width: 70%; text-align: right;">
 <?php if($CatPermissionInfo['CanViewCategory'][$TopicCatID]=="yes"&&$PermissionInfo['CanViewForum'][$TopicForumID]=="yes") {
 if($CanMakeReply=="yes") { ?>
 <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=create&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $ThemeSet['AddReply']; ?></a>
 <?php } if($PermissionInfo['CanMakeTopics'][$TopicForumID]=="yes") {
	if($CanMakeTopic=="yes"&&$CanMakeReply=="yes") { ?>
 <?php echo $ThemeSet['ButtonDivider']; } ?>
 <a href="<?php echo url_maker($exfile['forum'],$Settings['file_ext'],"act=create&id=".$TopicForumID,$Settings['qstr'],$Settings['qsep'],$prexqstr['forum'],$exqstr['forum']); ?>"><?php echo $ThemeSet['NewTopic']; ?></a>
 <?php } ?></td>
</tr>
</table>
<?php }
/* <div class="DivPageLinks">&#160;</div> */
?>
<div class="DivTable2">&#160;</div>
<?php }
while ($i < $num) {
$MyPostID=sql_result($result,$i,"id");
$MyTopicID=sql_result($result,$i,"TopicID");
$MyPostIP=sql_result($result,$i,"IP");
$MyForumID=sql_result($result,$i,"ForumID");
$MyCategoryID=sql_result($result,$i,"CategoryID");
$MyUserID=sql_result($result,$i,"UserID");
$MyGuestName=sql_result($result,$i,"GuestName");
$MyTimeStamp=sql_result($result,$i,"TimeStamp");
$MyEditTime=sql_result($result,$i,"LastUpdate");
$MyEditUserID=sql_result($result,$i,"EditUser");
$MyEditUserName=sql_result($result,$i,"EditUserName");
$tmpusrcurtime = new DateTime();
$tmpusrcurtime->setTimestamp($MyTimeStamp);
$tmpusrcurtime->setTimezone($usertz);
$MyTimeStamp=$tmpusrcurtime->format($_SESSION['iDBDateFormat'].", ".$_SESSION['iDBTimeFormat']);
$MyPost=sql_result($result,$i,"Post");
$MyDescription=sql_result($result,$i,"Description");
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($MyUserID));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult);
if($renum<1) { $MyUserID = -1;
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($MyUserID));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult); }
$memrequery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."mempermissions\" WHERE \"id\"=%i LIMIT 1", array($MyUserID));
$memreresult=sql_query($memrequery,$SQLStat);
$memrenum=sql_num_rows($memreresult);
$rei=0; $ipshow = "two";
$User1ID=$MyUserID; $GuestsName = $MyGuestName;
$User1Name=sql_result($reresult,$rei,"Name");
$User1IP=sql_result($reresult,$rei,"IP");
if($User1IP==$MyPostIP) { $ipshow = "one"; }
$User1Email=sql_result($reresult,$rei,"Email");
$User1Title=sql_result($reresult,$rei,"Title");
$PreUserCanExecPHP=sql_result($memreresult,$rei,"CanExecPHP");
if($PreUserCanExecPHP!="yes"&&$PreUserCanExecPHP!="no"&&$PreUserCanExecPHP!="group") {
	$PreUserCanExecPHP = "no"; }
$PreUserCanDoHTML=sql_result($memreresult,$rei,"CanDoHTML");
if($PreUserCanDoHTML!="yes"&&$PreUserCanDoHTML!="no"&&$PreUserCanDoHTML!="group") {
	$PreUserCanDoHTML = "no"; }
$PreUserCanUseBBTags=sql_result($memreresult,$rei,"CanUseBBTags");
if($PreUserCanUseBBTags!="yes"&&$PreUserCanUseBBTags!="no"&&$PreUserCanUseBBTags!="group") {
	$PreUserCanUseBBTags = "no"; }
sql_free_result($memreresult);
$User1Joined=sql_result($reresult,$rei,"Joined");
$tmpusrcurtime = new DateTime();
$tmpusrcurtime->setTimestamp($User1Joined);
$tmpusrcurtime->setTimezone($usertz);
$User1Joined=$tmpusrcurtime->format($_SESSION['iDBDateFormat']);
$User1Hidden=sql_result($reresult,$rei,"HiddenMember");
$User1LevelID=sql_result($reresult,$rei,"LevelID");
$User1RankID=sql_result($reresult,$rei,"RankID");
$lquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."levels\" WHERE \"id\"=%i LIMIT 1", array($User1LevelID));
$lresult=sql_query($lquery,$SQLStat);
$User1Level=sql_result($lresult,0,"Name");
$User1GroupID=sql_result($reresult,$rei,"GroupID");
$rquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."ranks\" WHERE \"id\"=%i LIMIT 1", array($User1RankID));
$rresult=sql_query($rquery,$SQLStat);
$User1Rank=sql_result($rresult,0,"Name");
sql_free_result($rresult);
$gquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i LIMIT 1", array($User1GroupID));
$gresult=sql_query($gquery,$SQLStat);
$User1Group=sql_result($gresult,0,"Name");
$User1CanExecPHP = $PreUserCanExecPHP;
if($PreUserCanExecPHP=="group") {
$User1CanExecPHP=sql_result($gresult,0,"CanExecPHP"); }
if($User1CanExecPHP!="yes"&&$User1CanExecPHP!="no") {
	$User1CanExecPHP = "no"; }
$User1CanDoHTML = $PreUserCanDoHTML;
if($PreUserCanDoHTML=="group") {
$User1CanDoHTML=sql_result($gresult,0,"CanDoHTML"); }
if($User1CanDoHTML!="yes"&&$User1CanDoHTML!="no") {
	$User1CanDoHTML = "no"; }
$User1CanUseBBTags = $PreUserCanUseBBTags;
if($User1CanUseBBTags=="group") {
$User1CanUseBBTags=sql_result($gresult,0,"CanUseBBTags"); }
if($User1CanUseBBTags!="yes"&&$User1CanUseBBTags!="no") {
	$User1CanUseBBTags = "no"; }
$GroupNamePrefix=sql_result($gresult,0,"NamePrefix");
$GroupNameSuffix=sql_result($gresult,0,"NameSuffix");
$User1PermissionID=sql_result($gresult,0,"PermissionID");
sql_free_result($gresult); sql_free_result($lresult);
$per1query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."permissions\" WHERE \"PermissionID\"=%i LIMIT 1", array($User1PermissionID));
$per1esult=sql_query($per1query,$SQLStat);
$per1num=sql_num_rows($per1esult);
$User1CanDoHTML1=sql_result($per1esult,0,"CanDoHTML");
if($User1CanDoHTML1!="yes"&&$User1CanDoHTML1!="no") {
	$User1CanDoHTML1 = "no"; }
$User1CanUseBBTags1=sql_result($per1esult,0,"CanUseBBTags");
if($User1CanUseBBTags1!="yes"&&$User1CanUseBBTags1!="no") {
	$User1CanUseBBTags1 = "no"; }
sql_free_result($per1esult);
if($User1Title=="") { $User1Title = $User1Group; }
$User1Signature=sql_result($reresult,$rei,"Signature");
$User1Avatar=sql_result($reresult,$rei,"Avatar");
$User1AvatarSize=sql_result($reresult,$rei,"AvatarSize");
if ($User1Avatar=="http://"||$User1Avatar==null||
	strtolower($User1Avatar)=="noavatar") {
$User1Avatar=$ThemeSet['NoAvatar'];
$User1AvatarSize=$ThemeSet['NoAvatarSize']; }
$AvatarSize1=explode("x", $User1AvatarSize);
$AvatarSize1W=$AvatarSize1[0]; $AvatarSize1H=$AvatarSize1[1];
$User1Website=sql_result($reresult,$rei,"Website");
if($User1Website=="http://") { 
	$User1Website = $Settings['idburl']; }
$User1Website = urlcheck($User1Website);
$BoardWWWChCk = parse_url($Settings['idburl']);
$User1WWWChCk = parse_url($User1Website);
$opennew = " onclick=\"window.open(this.href);return false;\"";
if($BoardWWWChCk['host']==$User1WWWChCk['host']) {
	$opennew = null; }
$User1PostCount=sql_result($reresult,$rei,"PostCount");
$User1Karma=sql_result($reresult,$rei,"Karma");
$User1IP=sql_result($reresult,$rei,"IP");
sql_free_result($reresult);
if($User1Name=="Guest") { $User1Name=$GuestsName;
if($User1Name==null) { $User1Name="Guest"; } }
if(isset($GroupNamePrefix)&&$GroupNamePrefix!=null) {
	$User1Name = $GroupNamePrefix.$User1Name; }
if(isset($GroupNameSuffix)&&$GroupNameSuffix!=null) {
	$User1Name = $User1Name.$GroupNameSuffix; }
$MySubPost = null;
if($MyEditTime!=$MyTimeStamp&&$MyEditUserID!=0) {
if($MyEditUserID!=$MyUserID) {
$euquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($MyEditUserID));
$euresult = sql_query($euquery,$SQLStat);
$eunum = sql_num_rows($euresult);
if($eunum<1) { $MyEditUserID = -1;
$euquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($MyEditUserID));
$euresult = sql_query($euquery,$SQLStat);
$eunum = sql_num_rows($euresult); }
	$EditUserID = $MyEditUserID;
	$EditUserGroupID = sql_result($euresult,0,"GroupID");
	$EditUserHidden=sql_result($euresult,0,"HiddenMember");
	$EditUserName = sql_result($euresult,0,"Name");
	sql_free_result($euresult);
	$eugquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i LIMIT 1", array($EditUserGroupID));
	$eugresult=sql_query($eugquery,$SQLStat);
	$EditUserGroup=sql_result($eugresult,0,"Name");
	$EditUserNamePrefix=sql_result($eugresult,0,"NamePrefix");
	$EditUserNameSuffix=sql_result($eugresult,0,"NameSuffix");
	sql_free_result($eugresult);	}
	if($MyEditUserID==$MyUserID) {
	$EditUserID = $User1ID;
	$EditUserGroupID = $User1GroupID;
	$EditUserHidden=$User1Hidden;
	$EditUserName = $User1Name;
	$EditUserGroup=$User1Group;
	$EditUserNamePrefix=null;
	$EditUserNameSuffix=null; }
	if($EditUserName=="Guest") { $EditUserName=$MyEditUserName;
	if($EditUserName==null) { $EditUserName="Guest"; } }
	if(isset($GroupNamePrefix)&&$GroupNamePrefix!=null) {
		$EditUserName = $EditUserNamePrefix.$EditUserName; }
	if(isset($GroupNameSuffix)&&$GroupNameSuffix!=null) {
		$EditUserName = $EditUserName.$EditUserNameSuffix; }
	$tmpusrcurtime = new DateTime();
	$tmpusrcurtime->setTimestamp($MyEditTime);
	$tmpusrcurtime->setTimezone($usertz);
	$MyEditTime = $tmpusrcurtime->format($_SESSION['iDBDateFormat'].", ".$_SESSION['iDBTimeFormat']);
	$MySubPost = "<div class=\"EditReply\"><br />This post has been edited by <b>".$EditUserName."</b> on ".$MyEditTime."</div>"; }
if($User1CanUseBBTags1=="yes") { $MyPost = bbcode_parser($MyPost); }
if($User1CanExecPHP=="no") {
$MyPost = preg_replace("/\[ExecPHP\](.*?)\[\/ExecPHP\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute php code.",$MyPost); }
if($User1CanExecPHP=="yes") { $MyPost = php_execute($MyPost); }
if($User1CanDoHTML1=="no") {
$MyPost = preg_replace("/\[DoHTML\](.*?)\[\/DoHTML\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute html.",$MyPost); }
if($User1CanDoHTML1=="yes") { $MyPost = do_html_bbcode($MyPost); }
$MyPost = text2icons($MyPost,$Settings['sqltable'],$SQLStat);
$MyPost = preg_replace("/\<br\>/", "<br />", nl2br($MyPost));
$MyPost = url2link($MyPost);
if($MySubPost!=null) { $MyPost = $MyPost."\n".$MySubPost; }
if($User1CanUseBBTags=="yes") { $User1Signature = bbcode_parser($User1Signature); }
if($User1CanExecPHP=="no") {
$User1Signature = preg_replace("/\[ExecPHP\](.*?)\[\/ExecPHP\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute php code.",$User1Signature); }
if($User1CanExecPHP=="yes") { $User1Signature = php_execute($User1Signature); }
if($User1CanDoHTML1=="no") {
$User1Signature = preg_replace("/\[DoHTML\](.*?)\[\/DoHTML\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute html.",$User1Signature); }
if($User1CanDoHTML=="yes") { $User1Signature = do_html_bbcode($User1Signature); }
$User1Signature = text2icons($User1Signature,$Settings['sqltable'],$SQLStat);
$User1Signature = preg_replace("/\<br\>/", "<br />", nl2br($User1Signature));
$User1Signature = url2link($User1Signature);
$CanEditReply = false; $CanDeleteReply = false;
if($_SESSION['UserGroup']!=$Settings['GuestGroup']) {
if($PermissionInfo['CanEditReplys'][$MyForumID]=="yes"&&
	$_SESSION['UserID']==$MyUserID) { $CanEditReply = true; }
if($PermissionInfo['CanDeleteReplys'][$MyForumID]=="yes"&&
	$_SESSION['UserID']==$MyUserID) { $CanDeleteReply = true; }
if($PermissionInfo['CanModForum'][$MyForumID]=="yes") { 
	$CanEditReply = true; $CanDeleteReply = true; } }
if($_SESSION['UserID']==0) { 
	$CanEditReply = false; $CanDeleteReply = false; }
$ReplyNum = $i + $PageLimit + 1;
?>
<div class="TableInfo1Border" id="reply<?php echo $ReplyNum; ?>">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableInfoRow1">
<span style="font-weight: bold; text-align: left;"><?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']).$qstrhtml."&#35;reply".$ReplyNum; ?>"><?php echo $TopicName; ?></a> ( <?php echo $MyDescription; ?> )</span>
</div>
<?php } ?>
<table class="TableInfo1" id="post<?php echo $MyPostID; ?>">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableInfoRow1">
<td class="TableInfoColumn1" colspan="2"><span style="font-weight: bold; text-align: left;"><?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']).$qstrhtml."&#35;reply".$ReplyNum; ?>"><?php echo $TopicName; ?></a> ( <?php echo $MyDescription; ?> )</span>
</td>
</tr><?php } ?>
<tr class="TableInfoRow2">
<td class="TableInfoColumn2" style="vertical-align: middle; width: 160px;">
&#160;<?php
if($User1ID>0&&$User1Hidden=="no") {
echo "<a href=\"";
echo url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$User1ID,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member']);
echo "\">".$User1Name."</a>"; }
if($User1ID<=0||$User1Hidden=="yes") {
echo "<span>".$User1Name."</span>"; }
?></td>
<td class="TableInfoColumn2" style="vertical-align: middle;">
<div style="float: left; text-align: left;">
<span style="font-weight: bold; vertical-align: middle;">Time Posted: </span><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&post=".$MyPostID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>" style="vertical-align: middle;"><?php echo $MyTimeStamp; ?></a>
</div>
<div style="float: right;">
<?php if(isset($ThemeSet['Report'])&&$ThemeSet['Report']!=null) { ?>
<a href="#Act/Report"><?php echo $ThemeSet['Report']; ?></a>
<?php } if($CanEditReply===true&&isset($ThemeSet['EditReply'])&&$ThemeSet['EditReply']!=null) {
echo $ThemeSet['LineDividerTopic']; echo "<a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=edit&id=".$MyTopicID."&post=".$MyPostID."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">".$ThemeSet['EditReply']; ?></a>
<?php } if($CanDeleteReply===true&&isset($ThemeSet['DeleteReply'])&&$ThemeSet['DeleteReply']!=null) { 
echo $ThemeSet['LineDividerTopic']; echo "<a href=\"".url_maker($exfile['topic'],$Settings['file_ext'],"act=delete&id=".$MyTopicID."&post=".$MyPostID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'])."\">".$ThemeSet['DeleteReply']; ?></a>
<?php } if($CanMakeReply=="yes"&&isset($ThemeSet['QuoteReply'])&&$ThemeSet['QuoteReply']!=null) { 
echo $ThemeSet['LineDividerTopic']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=create&id=".$TopicID."&post=".$MyPostID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $ThemeSet['QuoteReply']; ?></a>
<?php } ?>&#160;</div>
</td>
</tr>
<tr class="TableInfoRow3">
<td class="TableInfoColumn3" style="vertical-align: top; width: 180px;">
<?php  // Avatar Table Thanks For SeanJ's Help at http://seanj.jcink.com/  
 ?>
 <table class="AvatarTable" style="width: 100px; height: 100px; text-align: center;">
	<tr class="AvatarRow" style="width: 100%; height: 100%;">
		<td class="AvatarRow" style="width: 100%; height: 100%; text-align: center; vertical-align: middle;">
		<img src="<?php echo $User1Avatar; ?>" alt="<?php echo $User1Name; ?>'s Avatar" title="<?php echo $User1Name; ?>'s Avatar" style="border: 0px; width: <?php echo $AvatarSize1W; ?>px; height: <?php echo $AvatarSize1H; ?>px;" />
		</td>
	</tr>
 </table><br />
<?php echo $User1Title; ?><br />
Group: <?php echo $User1Group; ?><br />
Level: <?php echo $User1Level; ?><br />
Member: <?php 
if($User1ID>0&&$User1Hidden=="no") { echo $User1ID; }
if($User1ID<=0||$User1Hidden=="yes") { echo 0; }
?><br />
Posts: <?php echo $User1PostCount; ?><br />
Karma: <?php echo $User1Karma; ?><br />
Karma Level: <?php echo $User1Rank; ?><br />
Joined: <?php echo $User1Joined; ?><br />
<?php if($GroupInfo['CanViewIPAddress']=="yes") { ?>
User IP: <a onclick="window.open(this.href);return false;" href="<?php echo sprintf($IPCheckURL,$User1IP); ?>">
<?php echo $User1IP; ?></a><br />
<?php if($ipshow=="two") { ?>
Post IP: <a onclick="window.open(this.href);return false;" href="<?php echo sprintf($IPCheckURL,$MyPostIP); ?>">
<?php echo $MyPostIP; ?></a><br />
<?php } } ?><br />
</td>
<td class="TableInfoColumn3" style="vertical-align: middle;">
<div class="replypost"><?php echo $MyPost; ?></div>
<?php if(isset($User1Signature)&&$User1Signature!="") { ?> <br />--------------------
<div class="signature"><?php echo $User1Signature; ?></div><?php } ?>
</td>
</tr>
<tr class="TableInfoRow4">
<td class="TableInfoColumn4" colspan="2">
<span style="text-align: left; float: left;">&#160;<a href="<?php
if($User1ID>0&&$User1Hidden=="no"&&isset($ThemeSet['Profile'])&&$ThemeSet['Profile']!=null) {
echo url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$User1ID,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member']); }
if(($User1ID<=0||$User1Hidden=="yes")&&isset($ThemeSet['Profile'])&&$ThemeSet['Profile']!=null) {
echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); }
?>"><?php echo $ThemeSet['Profile']; ?></a>
<?php if(isset($ThemeSet['WWW'])&&$ThemeSet['WWW']!=null) {
echo $ThemeSet['LineDividerTopic']; ?><a href="<?php echo $User1Website; ?>"<?php echo $opennew; ?>><?php echo $ThemeSet['WWW']; ?></a><?php } echo $ThemeSet['LineDividerTopic']; ?><a href="<?php
if($User1ID>0&&$User1Hidden=="no"&&isset($ThemeSet['PM'])&&$ThemeSet['PM']!=null) {
echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=create&id=".$User1ID,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); }
if(($User1ID<=0||$User1Hidden=="yes")&&isset($ThemeSet['PM'])&&$ThemeSet['PM']!=null) {
echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); }
?>"><?php echo $ThemeSet['PM']; ?></a></span>
<span style="text-align: right; float: right; font-weight: bold;"><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&post=".$MyPostID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>" title="Link to post #<?php echo $ReplyNum; ?>" style="vertical-align: middle; font-weight: bold;">
#<?php echo $ReplyNum; ?></a>&#160;</span>
</td>
</tr>
</table></div>
<div class="DivReplies">&#160;</div>
<?php ++$i; } sql_free_result($result); } 
if(($utccurtime->getTimestamp()<$_SESSION['LastPostTime']&&$_SESSION['LastPostTime']!=0)&&
($_GET['act']=="create"||$_GET['act']=="edit"||$_GET['act']=="makereply"||$_GET['act']=="editreply")) { 
$_GET['act'] = "view"; $_POST['act'] = null; 
redirect("refresh",$rbasedir.url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'],FALSE),"3"); ?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Make Reply Message: </th>
</tr>
<tr class="TableRow3">
<td class="TableColumn3">
<table style="width: 100%; height: 25%; text-align: center;">
<tr>
	<td><span class="TableMessage"><br />
	You have to wait before making/editing another post.<br />
	Click <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>">here</a> to view your reply.<br />&#160;
	</span><br /></td>
</tr>
</table>
</td></tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<div class="DivMkReply">&#160;</div>
<?php } if($_GET['act']=="create") {
if($GroupInfo['HasAdminCP']!="yes"||$GroupInfo['HasModCP']!="yes") {
if($ForumPostCountView!=0&&$MyPostCountChk<$ForumPostCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($CategoryPostCountView!=0&&$MyPostCountChk<$CategoryPostCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($ForumKarmaCountView!=0&&$MyKarmaCount<$ForumKarmaCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($CategoryKarmaCountView!=0&&$MyKarmaCount<$CategoryKarmaCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); } }
if($PermissionInfo['CanMakeReplys'][$TopicForumID]=="no") { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($PermissionInfo['CanMakeReplysClose'][$TopicForumID]=="no"&&$TopicClosed==1) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$QuoteReply = null; $QuoteDescription = null;
if($_GET['post']==null) {
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i ORDER BY \"TimeStamp\" ASC  LIMIT 1", array($_GET['id']));
$result=sql_query($query,$SQLStat);
$num=sql_num_rows($result);
$QuoteDescription=sql_result($result,0,"Description"); 
$QuoteDescription = str_replace("Re: ","",$QuoteDescription);
$QuoteDescription = "Re: ".$QuoteDescription;
sql_free_result($result); }
if($_GET['post']!=null) {
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"id\"=%i LIMIT 1", array($_GET['post']));
$result=sql_query($query,$SQLStat);
$num=sql_num_rows($result);
if($num>=1) {
$QuoteReplyID=sql_result($result,0,"id");
$QuoteReplyFID=sql_result($result,0,"ForumID");
$QuoteReplyCID=sql_result($result,0,"CategoryID");
$QuoteUserID=sql_result($result,0,"UserID");
$QuoteReply=sql_result($result,0,"Post");
$QuoteReply = preg_replace("/\[ExecPHP\](.*?)\[\/ExecPHP\]/is","",$QuoteReply);
$QuoteDescription=sql_result($result,0,"Description");
$QuoteGuestName=sql_result($result,0,"GuestName");
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($QuoteUserID));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult);
if($renum<1) { $QuoteUserID = -1;
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($QuoteUserID));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult); }
$QuoteUserName=sql_result($reresult,0,"Name");
if($QuoteUserName=="Guest") { $QuoteUserName=$QuoteGuestName;
if($QuoteUserName==null) { $QuoteUserName="Guest"; } }
$QuoteUserName = stripcslashes(htmlspecialchars($QuoteUserName, ENT_QUOTES, $Settings['charset']));
//$QuoteUserName = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $QuoteUserName);
$QuoteUserName = remove_spaces($QuoteUserName);
/*$QuoteReply = stripcslashes(htmlspecialchars($QuoteReply, ENT_QUOTES, $Settings['charset']));
$QuoteReply = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $QuoteReply);
//$QuoteReply = remove_spaces($QuoteReply);*/
$QuoteReply = remove_bad_entities($QuoteReply);
$QuoteDescription = str_replace("Re: ","",$QuoteDescription);
$QuoteDescription = "Re: ".$QuoteDescription;
$QuoteReply = $QuoteUserName.":\n(&quot;".$QuoteReply."&quot;)";
if(!isset($PermissionInfo['CanViewForum'][$QuoteReplyFID])) {
	$PermissionInfo['CanViewForum'][$QuoteReplyFID] = "no"; }
if($PermissionInfo['CanViewForum'][$QuoteReplyFID]=="no") {
	$QuoteReply = null; $QuoteDescription = null; }
if(!isset($CatPermissionInfo['CanViewCategory'][$QuoteReplyCID])) {
	$CatPermissionInfo['CanViewCategory'][$QuoteReplyCID] = "no"; }
if($CatPermissionInfo['CanViewCategory'][$QuoteReplyCID]=="no") {
	$QuoteReply = null; $QuoteDescription = null; } } }
if($GroupInfo['HasAdminCP']!="yes"||$GroupInfo['HasModCP']!="yes") {
if($_GET['post']!=null&&$num>=1) {
$rforumcheck = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."forums\" WHERE \"id\"=%i".$ForumIgnoreList2."  LIMIT 1", array($QuoteReplyFID));
$rfmckresult=sql_query($rforumcheck,$SQLStat);
$rForumPostCountView=sql_result($rfmckresult,0,"PostCountView");
$rForumKarmaCountView=sql_result($rfmckresult,0,"KarmaCountView");
sql_free_result($rfmckresult);
$rcatcheck = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."categories\" WHERE \"id\"=%i".$CatIgnoreList2."  LIMIT 1", array($QuoteReplyCID));
$rcatresult=sql_query($rcatcheck,$SQLStat);
$rCategoryPostCountView=sql_result($rcatresult,0,"PostCountView");
$rCategoryKarmaCountView=sql_result($rcatresult,0,"KarmaCountView");
sql_free_result($rcatresult);
if($MyPostCountChk==null) { $MyPostCountChk = 0; }
if($rForumPostCountView!=0&&$MyPostCountChk<$rForumPostCountView) {
$QuoteReply = null; $QuoteDescription = null; }
if($rCategoryPostCountView!=0&&$MyPostCountChk<$rCategoryPostCountView) {
$QuoteReply = null; $QuoteDescription = null; }
if($rForumKarmaCountView!=0&&$MyKarmaCount<$rForumKarmaCountView) {
$QuoteReply = null; $QuoteDescription = null; }
if($rCategoryKarmaCountView!=0&&$MyKarmaCount<$rCategoryKarmaCountView) {
$QuoteReply = null; $QuoteDescription = null; } } }
if($_GET['post']==null||$num<1) { $QuoteReply = null; /*$QuoteDescription = null;*/ }
$UFID = rand_uuid("rand");
$_SESSION['UserFormID'] = $UFID;
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>#<?php echo $TopicID; ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1" id="MakeReply<?php echo $TopicForumID; ?>">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1" id="ReplyStart<?php echo $TopicForumID; ?>">
<td class="TableColumn1" colspan="2"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>#<?php echo $TopicID; ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr id="MakeReplyRow<?php echo $TopicForumID; ?>" class="TableRow2">
<td class="TableColumn2" colspan="2" style="width: 100%;">Making a Reply in Topic <?php echo $TopicName; ?></td>
</tr>
<tr class="TableRow3" id="MkReply<?php echo $TopicForumID; ?>">
<td class="TableColumn3" style="width: 15%; vertical-align: middle; text-align: center;">
<div style="width: 100%; height: 160px; overflow: auto;">
<table style="width: 100%; text-align: center;"><?php
$melanie_query=sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."smileys\" WHERE \"Display\"='yes'", array(null));
$melanie_result=sql_query($melanie_query,$SQLStat);
$melanie_num=sql_num_rows($melanie_result);
$melanie_p=0; $rose_a=0; $SmileRow=0; $SmileCRow=0;
while ($melanie_p < $melanie_num) { ++$SmileRow;
$FileName=sql_result($melanie_result,$melanie_p,"FileName");
$SmileName=sql_result($melanie_result,$melanie_p,"SmileName");
$SmileText=sql_result($melanie_result,$melanie_p,"SmileText");
$SmileDirectory=sql_result($melanie_result,$melanie_p,"Directory");
$ShowSmile=sql_result($melanie_result,$melanie_p,"Display");
$ReplaceType=sql_result($melanie_result,$melanie_p,"ReplaceCI");
if($SmileRow==1) { ?><tr>
	<?php } if($SmileRow<5) { ++$SmileCRow; ?>
	<td><img src="<?php echo $SmileDirectory."".$FileName; ?>" style="vertical-align: middle; border: 0px; cursor: pointer;" title="<?php echo $SmileName; ?>" alt="<?php echo $SmileName; ?>" onclick="addsmiley('ReplyPost','&#160;<?php echo htmlspecialchars($SmileText, ENT_QUOTES, $Settings['charset']); ?>&#160;')" /></td>
	<?php ++$rose_a; } if($SmileRow==5) { ++$SmileCRow; $rose_a = 0; ?>
	<td><img src="<?php echo $SmileDirectory."".$FileName; ?>" style="vertical-align: middle; border: 0px; cursor: pointer;" title="<?php echo $SmileName; ?>" alt="<?php echo $SmileName; ?>" onclick="addsmiley('ReplyPost','&#160;<?php echo htmlspecialchars($SmileText, ENT_QUOTES, $Settings['charset']); ?>&#160;')" /></td></tr>
	<?php $SmileCRow=0; $SmileRow=0; }
++$melanie_p; }
if($SmileCRow<5&&$SmileCRow!=0) {
$SmileCRowL = 5 - $SmileCRow;
echo "<td colspan=\"".$SmileCRowL."\">&#160;</td></tr>"; }
echo "</table>";
sql_free_result($melanie_result);
?></div></td>
<td class="TableColumn3" style="width: 85%;">
<form style="display: inline;" method="post" id="MkReplyForm" action="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=makereply&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>">
<table style="text-align: left;">
<tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="ReplyDesc">Insert Reply Description:</label></td>
	<td style="width: 50%;"><input maxlength="45" type="text" name="ReplyDesc" class="TextBox" id="ReplyDesc" size="20" value="<?php echo $QuoteDescription; ?>" /></td>
</tr><?php if($_SESSION['UserGroup']==$Settings['GuestGroup']) { ?><tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="GuestName">Insert Guest Name:</label></td>
	<?php if(!isset($_SESSION['GuestName'])) { ?>
	<td style="width: 50%;"><input maxlength="25" type="text" name="GuestName" class="TextBox" id="GuestName" size="20" /></td>
	<?php } if(isset($_SESSION['GuestName'])) { ?>
	<td style="width: 50%;"><input maxlength="25" type="text" name="GuestName" class="TextBox" id="GuestName" size="20" value="<?php echo $_SESSION['GuestName']; ?>" /></td>
<?php } ?></tr><?php } ?>
</table>
<table style="text-align: left;">
<tr style="text-align: left;">
<td style="width: 100%;">
<label class="TextBoxLabel" for="ReplyPost">Insert Your Reply:</label><br />
<textarea rows="10" name="ReplyPost" id="ReplyPost" cols="40" class="TextBox"><?php echo $QuoteReply; ?></textarea><br />
<?php if($_SESSION['UserGroup']==$Settings['GuestGroup']&&$Settings['captcha_guest']=="on") { ?>
<label class="TextBoxLabel" for="signcode"><img src="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=MkCaptcha",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>" alt="CAPTCHA Code" title="CAPTCHA Code" /></label><br />
<input maxlength="25" type="text" class="TextBox" name="signcode" size="20" id="signcode" value="Enter SignCode" /><br />
<?php } ?>
<input type="hidden" name="act" value="makereplies" style="display: none;" />
<input type="hidden" style="display: none;" name="fid" value="<?php echo $UFID; ?>" />
<input type="hidden" style="display: none;" name="ubid" value="<?php echo $Settings['BoardUUID']; ?>" />
<?php if($_SESSION['UserGroup']!=$Settings['GuestGroup']) { ?>
<input type="hidden" name="GuestName" value="null" style="display: none;" />
<?php } ?>
<input type="submit" class="Button" value="Make Reply" name="make_reply" />
<input type="reset" value="Reset Form" class="Button" name="Reset_Form" />
</td></tr></table>
</form></td></tr>
<tr id="MkReplyEnd<?php echo $TopicForumID; ?>" class="TableRow4">
<td class="TableColumn4" colspan="2">&#160;</td>
</tr>
</table></div>
<div class="DivMkReply">&#160;</div>
<?php } if($_GET['act']=="makereply"&&$_POST['act']=="makereplies") {
if($GroupInfo['HasAdminCP']!="yes"||$GroupInfo['HasModCP']!="yes") {
if($ForumPostCountView!=0&&$MyPostCountChk<$ForumPostCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($CategoryPostCountView!=0&&$MyPostCountChk<$CategoryPostCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($ForumKarmaCountView!=0&&$MyKarmaCount<$ForumKarmaCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); }
if($CategoryKarmaCountView!=0&&$MyKarmaCount<$CategoryKarmaCountView) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); } }
if($PermissionInfo['CanMakeReplys'][$TopicForumID]=="no") { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($PermissionInfo['CanMakeReplysClose'][$TopicForumID]=="no"&&$TopicClosed==1) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$MyUsersID = $_SESSION['UserID']; if($MyUsersID=="0"||$MyUsersID==null) { $MyUsersID = -1; }
$REFERERurl = parse_url($_SERVER['HTTP_REFERER']);
$URL['REFERER'] = $REFERERurl['host'];
$URL['HOST'] = $_SERVER["SERVER_NAME"];
$REFERERurl = null;
if(!isset($_POST['ReplyDesc'])) { $_POST['ReplyDesc'] = null; }
if(!isset($_POST['ReplyPost'])) { $_POST['ReplyPost'] = null; }
if(!isset($_POST['GuestName'])) { $_POST['GuestName'] = null; }
if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$Settings['captcha_guest']=="on") {
require($SettDir['inc']."captcha.php"); }
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>#<?php echo $TopicID; ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>#<?php echo $TopicID; ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Make Reply Message: </th>
</tr>
<tr class="TableRow3">
<td class="TableColumn3">
<table style="width: 100%; height: 25%; text-align: center;">
<?php if (pre_strlen($_POST['ReplyDesc'])>"80") { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Your Reply Description is too big.<br />
	</span>&#160;</td>
</tr>
<?php } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$Settings['captcha_guest']=="on") {
if (PhpCaptcha::Validate($_POST['signcode'])) {
//echo 'Valid code entered';
} else { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />Invalid code entered<br />
	</span>&#160;</td>
</tr>
<?php } } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	pre_strlen($_POST['GuestName'])>"30") { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You Guest Name is too big.<br />
	</span>&#160;</td>
</tr>
<?php } if($_POST['fid']!=$_SESSION['UserFormID']) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Sorry the referering url dose not match our host name.<br />
	</span>&#160;</td>
</tr>
<?php } if($_POST['ubid']!=$Settings['BoardUUID']) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Sorry the referering url dose not match our host name.<br />
	</span>&#160;</td>
</tr>
<?php } if ($Settings['TestReferer']=="on") {
	if ($URL['HOST']!=$URL['REFERER']) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Sorry the referering url dose not match our host name.<br />
	</span>&#160;</td>
</tr>
<?php } }
$_POST['ReplyDesc'] = stripcslashes(htmlspecialchars($_POST['ReplyDesc'], ENT_QUOTES, $Settings['charset']));
//$_POST['ReplyDesc'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['ReplyDesc']);
$_POST['ReplyDesc'] = remove_spaces($_POST['ReplyDesc']);
$_POST['GuestName'] = stripcslashes(htmlspecialchars($_POST['GuestName'], ENT_QUOTES, $Settings['charset']));
//$_POST['GuestName'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['GuestName']);
$_POST['GuestName'] = remove_spaces($_POST['GuestName']);
$_POST['ReplyPost'] = stripcslashes(htmlspecialchars($_POST['ReplyPost'], ENT_QUOTES, $Settings['charset']));
//$_POST['ReplyPost'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['ReplyPost']);
//$_POST['ReplyPost'] = remove_spaces($_POST['ReplyPost']);
$_POST['ReplyPost'] = remove_bad_entities($_POST['ReplyPost']);
if($_SESSION['UserGroup']==$Settings['GuestGroup']) {
if(isset($_POST['GuestName'])&&$_POST['GuestName']!=null) {
if($cookieDomain==null) {
setcookie("GuestName", $_POST['GuestName'], time() + (7 * 86400), $cbasedir); }
if($cookieDomain!=null) {
if($cookieSecure===true) {
setcookie("GuestName", $_POST['GuestName'], time() + (7 * 86400), $cbasedir, $cookieDomain, 1); }
if($cookieSecure===false) {
setcookie("GuestName", $_POST['GuestName'], time() + (7 * 86400), $cbasedir, $cookieDomain, 0); } }
$_SESSION['GuestName']=$_POST['GuestName']; } }
/*    <_<  iWordFilter  >_>      
   by Kazuki Przyborowski - Cool Dude 2k */
$melanieqy=sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."wordfilter\"", array(null));
$melaniert=sql_query($melanieqy,$SQLStat);
$melanienm=sql_num_rows($melaniert);
$melanies=0;
while ($melanies < $melanienm) {
$Filter=sql_result($melaniert,$melanies,"FilterWord");
$Replace=sql_result($melaniert,$melanies,"Replacement");
$CaseInsensitive=sql_result($melaniert,$melanies,"CaseInsensitive");
if($CaseInsensitive=="on") { $CaseInsensitive = "yes"; }
if($CaseInsensitive=="off") { $CaseInsensitive = "no"; }
if($CaseInsensitive!="yes"||$CaseInsensitive!="no") { $CaseInsensitive = "no"; }
$WholeWord=sql_result($melaniert,$melanies,"WholeWord");
if($WholeWord=="on") { $WholeWord = "yes"; }
if($WholeWord=="off") { $WholeWord = "no"; }
if($WholeWord!="yes"&&$WholeWord!="no") { $WholeWord = "no"; }
$Filter = preg_quote($Filter, "/");
if($CaseInsensitive!="yes"&&$WholeWord=="yes") {
$_POST['ReplyDesc'] = preg_replace("/\b(".$Filter.")\b/", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/\b(".$Filter.")\b/", $Replace, $_POST['ReplyPost']); }
if($CaseInsensitive=="yes"&&$WholeWord=="yes") {
$_POST['ReplyDesc'] = preg_replace("/\b(".$Filter.")\b/i", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/\b(".$Filter.")\b/i", $Replace, $_POST['ReplyPost']); }
if($CaseInsensitive!="yes"&&$WholeWord!="yes") {
$_POST['ReplyDesc'] = preg_replace("/".$Filter."/", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/".$Filter."/", $Replace, $_POST['ReplyPost']); }
if($CaseInsensitive=="yes"&&$WholeWord!="yes") {
$_POST['ReplyDesc'] = preg_replace("/".$Filter."/i", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/".$Filter."/i", $Replace, $_POST['ReplyPost']); }
++$melanies; } sql_free_result($melaniert);
if ($_POST['ReplyDesc']==null) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Reply Description.<br />
	</span>&#160;</td>
</tr>
<?php } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$_POST['GuestName']==null) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Guest Name.<br />
	</span>&#160;</td>
</tr>
<?php } if($PermissionInfo['CanMakeReplys'][$TopicForumID]=="no") { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You do not have permission to make a reply here.<br />
	</span>&#160;</td>
</tr>
<?php } if($PermissionInfo['CanMakeReplysClose'][$TopicForumID]=="no"&&
	$TopicClosed==1) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You do not have permission to make a reply here.<br />
	</span>&#160;</td>
</tr>
<?php } if ($_POST['ReplyPost']==null) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Reply.<br />
	</span>&#160;</td>
</tr>
<?php } if ($Error=="Yes") {
redirect("refresh",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false),"4"); ?>
<tr>
	<td><span class="TableMessage">
	<br />Click <a href="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>">here</a> to goto index page.<br />&#160;
	</span><br /></td>
</tr>
<?php } if ($Error!="Yes") { $LastActive = $utccurtime->getTimestamp();
$gnrquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."forums\" WHERE \"id\"=%i".$ForumIgnoreList2." LIMIT 1", array($TopicForumID));
$gnrresult=sql_query($gnrquery,$SQLStat); $gnrnum=sql_num_rows($gnrresult);
$NumberPosts=sql_result($gnrresult,0,"NumPosts"); 
$PostCountAdd=sql_result($gnrresult,0,"PostCountAdd"); 
sql_free_result($gnrresult);
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($MyUsersID));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult);
$rei=0;
while ($rei < $renum) {
$User1ID=$MyUsersID;
$User1Name=sql_result($reresult,$rei,"Name");
if($_SESSION['UserGroup']==$Settings['GuestGroup']) { $User1Name = $_POST['GuestName']; }
$User1Email=sql_result($reresult,$rei,"Email");
$User1Title=sql_result($reresult,$rei,"Title");
$User1GroupID=sql_result($reresult,$rei,"GroupID");
$PostCount=sql_result($reresult,$rei,"PostCount");
$NewPostCount = null;
if($PostCountAdd=="on") { $NewPostCount = $PostCount + 1; }
if(!isset($NewPostCount)) { $NewPostCount = $PostCount; }
$gquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i LIMIT 1", array($User1GroupID));
$gresult=sql_query($gquery,$SQLStat);
$User1Group=sql_result($gresult,0,"Name");
sql_free_result($gresult);
$User1IP=$_SERVER['REMOTE_ADDR'];
++$rei; } sql_free_result($reresult);
$query = sql_pre_query("INSERT INTO \"".$Settings['sqltable']."posts\" (\"TopicID\", \"ForumID\", \"CategoryID\", \"UserID\", \"GuestName\", \"TimeStamp\", \"LastUpdate\", \"EditUser\", \"EditUserName\", \"Post\", \"Description\", \"IP\", \"EditIP\") VALUES\n".
"(%i, %i, %i, %i, '%s', %i, %i, 0, '', '%s', '%s', '%s', '0')", array($TopicID,$TopicForumID,$TopicCatID,$User1ID,$User1Name,$LastActive,$LastActive,$_POST['ReplyPost'],$_POST['ReplyDesc'],$User1IP));
sql_query($query,$SQLStat);
$postid = sql_get_next_id($Settings['sqltable'],"posts",$SQLStat);
$_SESSION['LastPostTime'] = $utccurtime->getTimestamp() + $GroupInfo['FloodControl'];
if($User1ID!=0&&$User1ID!=-1) {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"LastActive\"=%i,\"IP\"='%s',\"PostCount\"=%i,\"LastPostTime\"=%i WHERE \"id\"=%i", array($LastActive,$User1IP,$NewPostCount,$_SESSION['LastPostTime'],$User1ID));
sql_query($queryupd,$SQLStat); }
$NewNumPosts = $NumberPosts + 1; $NewNumReplies = $NumberReplies + 1;
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."forums\" SET \"NumPosts\"=%i WHERE \"id\"=%i", array($NewNumPosts,$TopicForumID));
sql_query($queryupd,$SQLStat);
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"NumReply\"=%i,LastUpdate=%i WHERE \"id\"=%i", array($NewNumReplies,$LastActive,$TopicID));
sql_query($queryupd,$SQLStat);
$MyPostNum = $NewNumReplies + 1; $NumPages = null;
if(!isset($Settings['max_posts'])) { $Settings['max_posts'] = 10; }
if($MyPostNum>$Settings['max_posts']) {
$NumPages = ceil($MyPostNum/$Settings['max_posts']); }
if($MyPostNum<=$Settings['max_posts']) {
$NumPages = 1; }
redirect("refresh",$rbasedir.url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=".$NumPages,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'],FALSE).$Settings['qstr']."#reply".$MyPostNum,"3");
?><tr>
	<td><span class="TableMessage"><br />
	Reply to Topic <?php echo $TopicName; ?> was posted.<br />
	Click <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=".$NumPages,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>&amp;&#35;reply<?php echo $MyPostNum; ?>">here</a> to view your reply.<br />&#160;
	</span><br /></td>
</tr>
<?php } ?>
</table>
</td></tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<div class="DivMkReply">&#160;</div>
<?php } if($_GET['act']=="pin"||$_GET['act']=="unpin") {
$gtsquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i LIMIT 1", array($_GET['id']));
$gtsresult=sql_query($gtsquery,$SQLStat);
$gtsnum=sql_num_rows($gtsresult);
$TTopicID=sql_result($gtsresult,0,"id");
$TForumID=sql_result($gtsresult,0,"ForumID");
$TUsersID=sql_result($gtsresult,0,"UserID");
$TPinned=sql_result($gtsresult,0,"Pinned");
$TClosed=sql_result($gtsresult,0,"Closed");
if($TopicClosed==2&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($TopicClosed==3&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if ($TPinned>2) { $TPinned = 1; } 
if ($TPinned<0) { $TPinned = 0; }
$CanPinTopics = false;
if($_SESSION['UserGroup']!=$Settings['GuestGroup']) {
if($PermissionInfo['CanPinTopics'][$TForumID]=="yes"&&
	$_SESSION['UserID']==$TUsersID) { $CanPinTopics = true; }
if($PermissionInfo['CanPinTopics'][$TForumID]=="yes"&&
	$PermissionInfo['CanModForum'][$TForumID]=="yes") { 
	$CanPinTopics = true; }
	if($PermissionInfo['CanPinTopics'][$TForumID]=="no"&&
		$TopicClosed==1) { $CanPinTopics = false; } }
if($_SESSION['UserID']==0) { $CanPinTopics = false; }
if($_GET['level']<1) { $_GET['level'] = 1; }
if($_GET['level']>2) { $_GET['level'] = 1; }
if($PermissionInfo['CanModForum'][$UseThisFonum]=="no") {
if($_GET['level']>1) { $_GET['level'] = 1; } }
if($CanPinTopics===false) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($gtsresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
sql_free_result($gtsresult);
if($CanPinTopics===true) {
	if($_GET['act']=="pin") {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"Pinned\"=%i WHERE \"id\"=%i", array($_GET['level'],$TTopicID)); }
	if($_GET['act']=="unpin") {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"Pinned\"=0 WHERE \"id\"=%i", array($TTopicID)); } 
sql_query($queryupd,$SQLStat); 
redirect("refresh",$rbasedir.url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'],false).$Settings['qstr']."#post".$_GET['post'],"4");
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Pin/Unpin Topic Message: </th>
</tr>
<tr class="TableRow3" style="text-align: center;">
	<td class="TableColumn3" style="text-align: center;"><span class="TableMessage"><br />
	Topic was successfully unpinned/pinned.<br />
	Click <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>">here</a> to go back to topic.<br />&#160;
	</span><br /></td>
</tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<?php } } if($_GET['act']=="open"||$_GET['act']=="close") {
$gtsquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i LIMIT 1", array($_GET['id']));
$gtsresult=sql_query($gtsquery,$SQLStat);
$gtsnum=sql_num_rows($gtsresult);
$TTopicID=sql_result($gtsresult,0,"id");
$TForumID=sql_result($gtsresult,0,"ForumID");
$TUsersID=sql_result($gtsresult,0,"UserID");
$TClosed=sql_result($gtsresult,0,"Closed");
if($TopicClosed==2&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($TopicClosed==3&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if ($TClosed>3) { $TClosed = 3; } 
if ($TClosed<0) { $TClosed = 0; }
$CanCloseTopics = false;
if($_SESSION['UserGroup']!=$Settings['GuestGroup']) {
if($PermissionInfo['CanCloseTopics'][$TForumID]=="yes"&&
	$_SESSION['UserID']==$TUsersID) { $CanCloseTopics = true; }
if($PermissionInfo['CanCloseTopics'][$TForumID]=="yes"&&
	$PermissionInfo['CanModForum'][$TForumID]=="yes") { 
	$CanCloseTopics = true; } }
if($_GET['level']<1) { $_GET['level'] = 1; }
if($_GET['level']>3) { $_GET['level'] = 1; }
if($PermissionInfo['CanModForum'][$TForumID]=="no") {
if($_GET['level']>1) { $_GET['level'] = 1; } }
if($_SESSION['UserID']==0) { $CanCloseTopics = false; }
if($CanCloseTopics===false) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($gtsresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
sql_free_result($gtsresult);
if($CanCloseTopics===true) {
	if($_GET['act']=="close") {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"Closed\"=%i WHERE \"id\"=%i", array($_GET['level'],$TTopicID)); }
	if($_GET['act']=="open") {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"Closed\"=0 WHERE \"id\"=%i", array($TTopicID)); } 
sql_query($queryupd,$SQLStat); 
redirect("refresh",$rbasedir.url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'],false).$Settings['qstr']."#post".$_GET['post'],"4");
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Open/Close Topic Message: </th>
</tr>
<tr class="TableRow3" style="text-align: center;">
	<td class="TableColumn3" style="text-align: center;"><span class="TableMessage"><br />
	Topic was successfully opened/closed.<br />
	Click <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>">here</a> to go back to topic.<br />&#160;
	</span><br /></td>
</tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<?php } } if($_GET['act']=="move") {
if(!isset($_GET['newid'])) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($gtsresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if(!is_numeric($_GET['newid'])) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($gtsresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$gtsquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i LIMIT 1", array($_GET['id']));
$gtsresult=sql_query($gtsquery,$SQLStat);
$gtsnum=sql_num_rows($gtsresult);
$TTopicID=sql_result($gtsresult,0,"id");
$OldForumID=sql_result($gtsresult,0,"ForumID");
$OldCatID=sql_result($gtsresult,0,"CategoryID");
$TClosed=sql_result($gtsresult,0,"Closed");
if($TopicClosed==2&&$PermissionInfo['CanModForum'][$OldForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($TopicClosed==3&&$PermissionInfo['CanModForum'][$OldForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$CanMoveTopics = false;
if($_SESSION['UserGroup']!=$Settings['GuestGroup']) {
if($PermissionInfo['CanCloseTopics'][$OldForumID]=="yes"&&
	$PermissionInfo['CanModForum'][$OldForumID]=="yes") { 
	$CanMoveTopics = true; }
if($PermissionInfo['CanCloseTopics'][$_GET['newid']]=="yes"&&
	$PermissionInfo['CanModForum'][$_GET['newid']]=="yes") { 
	$CanMoveTopics = true; } }
if($_SESSION['UserID']==0) { $CanMoveTopics = false; }
//if($CanMoveTopics===false||$_GET['newid']==$OldForumID) {
if($CanMoveTopics===false) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($gtsresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
sql_free_result($gtsresult);
if($CanMoveTopics===true) {
$TNumberPosts = $NumberReplies + 1;
$mvquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."forums\" WHERE \"id\"=%i".$ForumIgnoreList2." LIMIT 1", array($_GET['newid']));
$mvresult=sql_query($mvquery,$SQLStat);
$mvnum=sql_num_rows($mvresult);
if($mvnum<1) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($gtsresult); $urlstatus = 302;
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); sql_free_result($mvresult);
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$NumberPosts=sql_result($mvresult,0,"NumPosts");
$NumberPosts = $NumberPosts + $TNumberPosts;
$NumberTopics=sql_result($mvresult,0,"NumTopics");
$NumberTopics = $NumberTopics + 1;
$NewCatID=sql_result($mvresult,0,"CategoryID");
sql_free_result($mvresult);
$recountq = sql_pre_query("UPDATE \"".$Settings['sqltable']."forums\" SET \"NumPosts\"=%i,\"NumTopics\"=%i WHERE \"id\"=%i", array($NumberPosts,$NumberTopics,$_GET['newid']));
sql_query($recountq,$SQLStat);
$mvquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."forums\" WHERE \"id\"=%i".$ForumIgnoreList2." LIMIT 1", array($OldForumID));
$mvresult=sql_query($mvquery,$SQLStat);
$mvnum=sql_num_rows($mvresult);
$NumberPosts=sql_result($mvresult,0,"NumPosts");
$NumberPosts = $NumberPosts - $TNumberPosts;
$NumberTopics=sql_result($mvresult,0,"NumTopics");
$NumberTopics = $NumberTopics - 1;
sql_free_result($mvresult);
$recountq = sql_pre_query("UPDATE \"".$Settings['sqltable']."forums\" SET \"NumPosts\"=%i,\"NumTopics\"=%i WHERE \"id\"=%i", array($NumberPosts,$NumberTopics,$OldForumID));
sql_query($recountq,$SQLStat);
if($_GET['link']=="no") {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"ForumID\"=%i,\"CategoryID\"=%i,\"OldForumID\"=%i,\"OldCategoryID\"=%i WHERE \"id\"=%i", array($_GET['newid'],$NewCatID,$_GET['newid'],$NewCatID,$TTopicID)); }
if($_GET['link']=="yes") {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"ForumID\"=%i,\"CategoryID\"=%i,\"OldForumID\"=%i,\"OldCategoryID\"=%i WHERE \"id\"=%i", array($_GET['newid'],$NewCatID,$OldForumID,$OldCatID,$TTopicID)); }
sql_query($queryupd,$SQLStat);
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."posts\" SET \"ForumID\"=%i,\"CategoryID\"=%i WHERE \"TopicID\"=%i", array($_GET['newid'],$NewCatID,$TTopicID)); 
sql_query($queryupd,$SQLStat);
} 
redirect("refresh",$rbasedir.url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'],false),"4");
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Move Topic Message: </th>
</tr>
<tr class="TableRow3" style="text-align: center;">
	<td class="TableColumn3" style="text-align: center;"><span class="TableMessage"><br />
	Topic was successfully moved.<br />
	Click <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TTopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>">here</a> to go back to topic.<br />&#160;
	</span><br /></td>
</tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<?php } if($_GET['act']=="delete") {
$predquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"id\"=%i LIMIT 1", array($_GET['post']));
$predresult=sql_query($predquery,$SQLStat);
$prednum=sql_num_rows($predresult);
$ReplyID=sql_result($predresult,0,"id");
$ReplyTopicID=sql_result($predresult,0,"TopicID");
$ReplyForumID=sql_result($predresult,0,"ForumID");
$ReplyUserID=sql_result($predresult,0,"UserID");
sql_free_result($predresult);
$CanDeleteReply = false;
if($_SESSION['UserID']!=0) {
if($_SESSION['UserGroup']!=$Settings['GuestGroup']) {
if($PermissionInfo['CanDeleteReplys'][$ReplyForumID]=="yes"&&
	$_SESSION['UserID']==$ReplyUserID) { $CanDeleteReply = true; } 
if($PermissionInfo['CanDeleteReplys'][$ReplyForumID]=="yes"&&
	$PermissionInfo['CanModForum'][$ReplyForumID]=="yes") { 
	$CanDeleteReply = true; } } 
	if($PermissionInfo['CanDeleteReplysClose'][$TopicForumID]=="no"&&
		$TopicClosed==1) { $CanDeleteReply = false; } }
if($_SESSION['UserID']==0) { $CanDeleteReply = false; }
if($CanDeleteReply===false) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$delquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i ORDER BY \"TimeStamp\" ASC", array($_GET['id']));
$delresult=sql_query($delquery,$SQLStat);
$delnum=sql_num_rows($delresult);
$DelTopic = false;
$gnrquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."forums\" WHERE \"id\"=%i".$ForumIgnoreList2." LIMIT 1", array($ReplyForumID));
$gnrresult=sql_query($gnrquery,$SQLStat); $gnrnum=sql_num_rows($gnrresult);
$NumberPosts=sql_result($gnrresult,0,"NumPosts"); $NumberTopics=sql_result($gnrresult,0,"NumTopics"); 
sql_free_result($gnrresult);
$FReplyID=sql_result($delresult,0,"id");
if($ReplyID==$FReplyID) { $DelTopic = true;
$gtsquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i LIMIT 1", array($ReplyTopicID));
$gtsresult=sql_query($gtsquery,$SQLStat);
$gtsnum=sql_num_rows($gtsresult);
$TUsersID=sql_result($gtsresult,0,"UserID");
$TForumID=sql_result($gtsresult,0,"ForumID");
$TClosed=sql_result($gtsresult,0,"Closed");
if($TopicClosed==2&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($TopicClosed==3&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$CanDeleteTopics = false;
if($_SESSION['UserGroup']!=$Settings['GuestGroup']) {
if($PermissionInfo['CanDeleteTopics'][$ReplyForumID]=="yes"&&
	$_SESSION['UserID']==$TUsersID) { $CanDeleteTopics = true; }
if($PermissionInfo['CanDeleteTopics'][$ReplyForumID]=="yes"&&
	$PermissionInfo['CanModForum'][$ReplyForumID]=="yes") { 
	$CanDeleteTopics = true; }
	if($PermissionInfo['CanDeleteTopicsClose'][$TopicForumID]=="no"&&
		$TopicClosed==1) { $CanDeleteTopics = false; } }
if($_SESSION['UserID']==0) { $CanDeleteTopics = false; }
if($CanDeleteTopics===false) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($delresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($CanDeleteTopics===true) { $NewNumTopics = $NumberTopics - 1; $NewNumPosts = $NumberPosts - $delnum;
$drquery = sql_pre_query("DELETE FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i", array($ReplyTopicID));
sql_query($drquery,$SQLStat); 
$dtquery = sql_pre_query("DELETE FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i", array($ReplyTopicID));
sql_query($dtquery,$SQLStat);
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."forums\" SET \"NumPosts\"=%i,\"NumTopics\"=%i WHERE \"id\"=%i", array($NewNumPosts,$NewNumTopics,$ReplyForumID));
sql_query($queryupd,$SQLStat); } }
if($ReplyID!=$FReplyID) {
$LReplyID=sql_result($delresult,$delnum-1,"id");
$SLReplyID=sql_result($delresult,$delnum-2,"id");
$NewLastUpdate=sql_result($delresult,$delnum-2,"TimeStamp");
if($ReplyID==$LReplyID) { $NewNumReplies = $NumberReplies - 1; $NewNumPosts = $NumberPosts - 1;
$drquery = sql_pre_query("DELETE FROM \"".$Settings['sqltable']."posts\" WHERE \"id\"=%i", array($ReplyID));
sql_query($drquery,$SQLStat); 
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."forums\" SET \"NumPosts\"=%i WHERE \"id\"=%i", array($NewNumPosts,$ReplyForumID));
sql_query($queryupd,$SQLStat);
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"LastUpdate\"=%i,\"NumReply\"=%i WHERE \"id\"=%i", array($NewLastUpdate,$NewNumReplies,$ReplyTopicID));
sql_query($queryupd,$SQLStat); } }
if($ReplyID!=$FReplyID&&$ReplyID!=$LReplyID) { $NewNumReplies = $NumberReplies - 1; $NewNumPosts = $NumberPosts - 1;
$drquery = sql_pre_query("DELETE FROM \"".$Settings['sqltable']."posts\" WHERE \"id\"=%i", array($ReplyID));
sql_query($drquery,$SQLStat);
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."forums\" SET \"NumPosts\"=%i WHERE \"id\"=%i", array($NewNumPosts,$ReplyForumID));
sql_query($queryupd,$SQLStat);
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"NumReply\"=%i WHERE \"id\"=%i", array($NewNumReplies,$ReplyTopicID));
sql_query($queryupd,$SQLStat); }
redirect("refresh",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],FALSE),"3");
sql_free_result($delresult);
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Delete Reply Message: </th>
</tr>
<tr class="TableRow3" style="text-align: center;">
	<td class="TableColumn3" style="text-align: center;"><span class="TableMessage"><br />
	Reply was deleted successfully.<br />
	Click <a href="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>">here</a> to go back to index.<br />&#160;
	</span><br /></td>
</tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<?php } if($_GET['act']=="edit") {
if($PermissionInfo['CanEditReplys'][$TopicForumID]=="no"||$_SESSION['UserID']==0) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($PermissionInfo['CanEditReplysClose'][$TopicForumID]=="no"&&$TopicClosed==1) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$ShowEditTopic = null;
if($PermissionInfo['CanEditTopics'][$TopicForumID]=="yes") {
$editquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i ORDER BY \"TimeStamp\" ASC", array($TopicID));
$editresult=sql_query($editquery,$SQLStat);
$editnum=sql_num_rows($editresult);
$FReplyID=sql_result($editresult,0,"id");
sql_free_result($editresult);
if($_GET['post']==$FReplyID) { $ShowEditTopic = true; } }
if($PermissionInfo['CanEditTopics'][$TopicForumID]=="no") { $ShowEditTopic = null; }
$ersquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"id\"=%i LIMIT 1", array($_GET['post']));
$ersresult=sql_query($ersquery,$SQLStat);
$ersnum=sql_num_rows($ersresult);
if($ersnum==0) { sql_free_result($ersresult);
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$ReplyPost=sql_result($ersresult,0,"Post");
/*$ReplyPost = stripcslashes(htmlspecialchars($ReplyPost, ENT_QUOTES, $Settings['charset']));
$ReplyPost = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $ReplyPost);
//$ReplyPost = remove_spaces($ReplyPost);*/
$ReplyPost = remove_bad_entities($ReplyPost);
$ReplyDescription=sql_result($ersresult,0,"Description");
/*$ReplyDescription = stripcslashes(htmlspecialchars($ReplyDescription, ENT_QUOTES, $Settings['charset']));
$ReplyDescription = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $ReplyDescription);
//$ReplyDescription = remove_spaces($ReplyDescription);*/
$ReplyGuestName=sql_result($ersresult,0,"GuestName");
//$ReplyGuestName = stripcslashes(htmlspecialchars($ReplyGuestName, ENT_QUOTES, $Settings['charset']));
//$ReplyGuestName = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $ReplyGuestName);
$ReplyGuestName = remove_spaces($ReplyGuestName);
$ReplyUser=sql_result($ersresult,0,"UserID");
if($_SESSION['UserID']!=$ReplyUser&&$PermissionInfo['CanModForum'][$TopicForumID]=="no") {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
sql_free_result($ersresult);
if($ShowEditTopic===true) {
$gtsquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i LIMIT 1", array($TopicID));
$gtsresult=sql_query($gtsquery,$SQLStat);
$gtsnum=sql_num_rows($gtsresult);
$TUsersID=sql_result($gtsresult,0,"UserID");
$TForumID=sql_result($gtsresult,0,"ForumID");
$TClosed=sql_result($gtsresult,0,"Closed");
if($TopicClosed==2&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($TopicClosed==3&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($_SESSION['UserID']!=$TUsersID) { $ShowEditTopic = null; }
if($PermissionInfo['CanModForum'][$TopicForumID]=="yes"&&
	$PermissionInfo['CanEditTopics'][$TopicForumID]=="yes") { 
	$ShowEditTopic = true; } 
if($PermissionInfo['CanEditTopicsClose'][$TopicForumID]=="no"&&$TopicClosed==1) {
	$ShowEditTopic = null; } }
//$TopicName = stripcslashes(htmlspecialchars($TopicName, ENT_QUOTES, $Settings['charset']));
//$TopicName = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $TopicName);
$TopicName = remove_spaces($TopicName);
if($ShowEditTopic===true) {
sql_free_result($gtsresult); }
$UFID = rand_uuid("rand");
$_SESSION['UserFormID'] = $UFID;
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1" id="EditReply<?php echo $_GET['post']; ?>">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1" id="ReplyEdit<?php echo $_GET['post']; ?>">
<td class="TableColumn1" colspan="2"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr id="EditReplyRow<?php echo $_GET['post']; ?>" class="TableRow2">
<td class="TableColumn2" colspan="2" style="width: 100%;">Editing a Reply in Topic <?php echo $TopicName; ?></td>
</tr>
<tr class="TableRow3" id="EditReplies<?php echo $_GET['post']; ?>">
<td class="TableColumn3" style="width: 15%; vertical-align: middle; text-align: center;">
<div style="width: 100%; height: 160px; overflow: auto;"><?php
$melanie_query=sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."smileys\" WHERE \"Display\"='yes'", array(null));
$melanie_result=sql_query($melanie_query,$SQLStat);
$melanie_num=sql_num_rows($melanie_result);
$melanie_p=0; $SmileRow=1;
while ($melanie_p < $melanie_num) {
$FileName=sql_result($melanie_result,$melanie_p,"FileName");
$SmileName=sql_result($melanie_result,$melanie_p,"SmileName");
$SmileText=sql_result($melanie_result,$melanie_p,"SmileText");
$SmileDirectory=sql_result($melanie_result,$melanie_p,"Directory");
$ShowSmile=sql_result($melanie_result,$melanie_p,"Display");
$ReplaceType=sql_result($melanie_result,$melanie_p,"ReplaceCI");
if($SmileRow<5) { ?>
	<img src="<?php echo $SmileDirectory."".$FileName; ?>" style="vertical-align: middle; border: 0px; cursor: pointer;" title="<?php echo $SmileName; ?>" alt="<?php echo $SmileName; ?>" onclick="addsmiley('ReplyPost','&#160;<?php echo htmlspecialchars($SmileText, ENT_QUOTES, $Settings['charset']); ?>&#160;')" />&#160;&#160;
	<?php } if($SmileRow==5) { ?>
	<img src="<?php echo $SmileDirectory."".$FileName; ?>" style="vertical-align: middle; border: 0px; cursor: pointer;" title="<?php echo $SmileName; ?>" alt="<?php echo $SmileName; ?>" onclick="addsmiley('ReplyPost','&#160;<?php echo htmlspecialchars($SmileText, ENT_QUOTES, $Settings['charset']); ?>&#160;')" /><br />
	<?php $SmileRow=1; }
++$melanie_p; ++$SmileRow; }
sql_free_result($melanie_result);
?></div></td>
<td class="TableColumn3" style="width: 85%;">
<form style="display: inline;" method="post" id="EditReplyForm" action="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=editreply&id=".$TopicID."&post=".$_GET['post'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>">
<table style="text-align: left;">
<tr style="text-align: left;">
<?php if($ShowEditTopic===true) { ?>
	<td style="width: 50%;"><label class="TextBoxLabel" for="TopicName">Insert Topic Name:</label></td>
	<td style="width: 50%;"><input maxlength="30" type="text" name="TopicName" class="TextBox" id="TopicName" size="20" value="<?php echo $TopicName; ?>" /></td>
</tr><tr style="text-align: left;"><?php } ?>
	<td style="width: 50%;"><label class="TextBoxLabel" for="ReplyDesc">Insert Reply Description:</label></td>
	<td style="width: 50%;"><input maxlength="45" type="text" name="ReplyDesc" class="TextBox" id="ReplyDesc" size="20" value="<?php echo $ReplyDescription; ?>" /></td>
</tr><?php if($_SESSION['UserGroup']==$Settings['GuestGroup']) { ?><tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="GuestName">Insert Guest Name:</label></td>
	<?php if(!isset($_SESSION['GuestName'])) { ?>
	<td style="width: 50%;"><input maxlength="25" type="text" name="GuestName" class="TextBox" id="GuestName" size="20" /></td>
	<?php } if(isset($_SESSION['GuestName'])) { ?>
	<td style="width: 50%;"><input maxlength="25" type="text" name="GuestName" class="TextBox" id="GuestName" size="20" value="<?php echo $_SESSION['GuestName']; ?>" /></td>
<?php } ?></tr><?php } ?>
</table>
<table style="text-align: left;">
<tr style="text-align: left;">
<td style="width: 100%;">
<label class="TextBoxLabel" for="ReplyPost">Insert Your Reply:</label><br />
<textarea rows="10" name="ReplyPost" id="ReplyPost" cols="40" class="TextBox"><?php echo $ReplyPost; ?></textarea><br />
<input type="hidden" name="act" value="editreplies" style="display: none;" />
<input type="hidden" style="display: none;" name="fid" value="<?php echo $UFID; ?>" />
<input type="hidden" style="display: none;" name="ubid" value="<?php echo $Settings['BoardUUID']; ?>" />
<?php if(isset($_GET['page'])&&is_numeric($_GET['page'])) { ?>
<input type="hidden" style="display: none;" name="page" value="<?php echo $_GET['page']; ?>" />
<?php } if($_SESSION['UserGroup']!=$Settings['GuestGroup']) { ?>
<input type="hidden" name="GuestName" value="null" style="display: none;" />
<?php } ?>
<input type="submit" class="Button" value="Edit Reply" name="edit_reply" />
<input type="reset" value="Reset Form" class="Button" name="Reset_Form" />
</td></tr></table>
</form></td></tr>
<tr id="EditReplyEnd<?php echo $_GET['post']; ?>" class="TableRow4">
<td class="TableColumn4" colspan="2">&#160;</td>
</tr>
</table></div>
<div class="DivMkReply">&#160;</div>
<?php } if($_GET['act']=="editreply"&&$_POST['act']=="editreplies") {
if($PermissionInfo['CanEditReplys'][$TopicForumID]=="no"||$_SESSION['UserID']==0) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($PermissionInfo['CanEditReplysClose'][$TopicForumID]=="no"&&$TopicClosed==1) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$REFERERurl = parse_url($_SERVER['HTTP_REFERER']);
$URL['REFERER'] = $REFERERurl['host'];
$URL['HOST'] = $_SERVER["SERVER_NAME"];
$REFERERurl = null;
if(!isset($_POST['ReplyDesc'])) { $_POST['ReplyDesc'] = null; }
if(!isset($_POST['ReplyPost'])) { $_POST['ReplyPost'] = null; }
if(!isset($_POST['GuestName'])) { $_POST['GuestName'] = null; }
if(!isset($_POST['TopicName'])) { $_POST['TopicName'] = null; }
if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$Settings['captcha_guest']=="on") {
require($SettDir['inc']."captcha.php"); }
$ShowEditTopic = null;
if($PermissionInfo['CanEditTopics'][$TopicForumID]=="yes") {
$editquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i ORDER BY \"TimeStamp\" ASC", array($TopicID));
$editresult=sql_query($editquery,$SQLStat);
$editnum=sql_num_rows($editresult);
$FReplyID=sql_result($editresult,0,"id");
sql_free_result($editresult);
if($_GET['post']==$FReplyID) { $ShowEditTopic = true; } }
if($PermissionInfo['CanEditTopics'][$TopicForumID]=="no") { $ShowEditTopic = null; }
$ersquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"id\"=%i LIMIT 1", array($_GET['post']));
$ersresult=sql_query($ersquery,$SQLStat);
$ersnum=sql_num_rows($ersresult);
if($ersnum==0) { sql_free_result($ersresult);
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
$ReplyUser=sql_result($ersresult,0,"UserID");
if($_SESSION['UserID']!=$ReplyUser&&$PermissionInfo['CanModForum'][$TopicForumID]=="no") {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
sql_free_result($ersresult); 
if($ShowEditTopic===true) {
$gtsquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."topics\" WHERE \"id\"=%i LIMIT 1", array($TopicID));
$gtsresult=sql_query($gtsquery,$SQLStat);
$gtsnum=sql_num_rows($gtsresult);
$TUsersID=sql_result($gtsresult,0,"UserID");
$TForumID=sql_result($gtsresult,0,"ForumID");
$TClosed=sql_result($gtsresult,0,"Closed");
if($_SESSION['UserID']!=$TUsersID) { $ShowEditTopic = null; }
if($PermissionInfo['CanModForum'][$TopicForumID]=="yes"&&
	$PermissionInfo['CanEditTopics'][$TopicForumID]=="yes") { 
	$ShowEditTopic = true; } 
if($PermissionInfo['CanEditTopicsClose'][$TopicForumID]=="no"&&$TopicClosed==1) {
	$ShowEditTopic = null; } }
if($TopicClosed==2&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
if($TopicClosed==3&&$PermissionInfo['CanModForum'][$TForumID]=="no") { 
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false)); sql_free_result($preresult);
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Edit Reply Message: </th>
</tr>
<tr class="TableRow3">
<td class="TableColumn3">
<table style="width: 100%; height: 25%; text-align: center;">
<?php if (pre_strlen($_POST['ReplyDesc'])>"80") { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Your Reply Description is too big.<br />
	</span>&#160;</td>
</tr>
<?php } if($_POST['fid']!=$_SESSION['UserFormID']) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Sorry the referering url dose not match our host name.<br />
	</span>&#160;</td>
</tr>
<?php } if($_POST['ubid']!=$Settings['BoardUUID']) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Sorry the referering url dose not match our host name.<br />
	</span>&#160;</td>
</tr>
<?php } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$Settings['captcha_guest']=="on") {
if (PhpCaptcha::Validate($_POST['signcode'])) {
//echo 'Valid code entered';
} else { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />Invalid code entered<br />
	</span>&#160;</td>
</tr>
<?php } } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	pre_strlen($_POST['GuestName'])>"30") { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You Guest Name is too big.<br />
	</span>&#160;</td>
</tr>
<?php } if($ShowEditTopic===true&&
	pre_strlen($_POST['TopicName'])>"50") { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You Topic Name is too big.<br />
	</span>&#160;</td>
</tr>
<?php } if ($Settings['TestReferer']=="on") {
	if ($URL['HOST']!=$URL['REFERER']) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Sorry the referering url dose not match our host name.<br />
	</span>&#160;</td>
</tr>
<?php } }
$_POST['ReplyDesc'] = stripcslashes(htmlspecialchars($_POST['ReplyDesc'], ENT_QUOTES, $Settings['charset']));
//$_POST['ReplyDesc'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['ReplyDesc']);
$_POST['ReplyDesc'] = remove_spaces($_POST['ReplyDesc']);
$_POST['GuestName'] = stripcslashes(htmlspecialchars($_POST['GuestName'], ENT_QUOTES, $Settings['charset']));
//$_POST['GuestName'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['GuestName']);
$_POST['GuestName'] = remove_spaces($_POST['GuestName']);
$_POST['ReplyPost'] = stripcslashes(htmlspecialchars($_POST['ReplyPost'], ENT_QUOTES, $Settings['charset']));
//$_POST['ReplyPost'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['ReplyPost']);
$_POST['ReplyPost'] = remove_bad_entities($_POST['ReplyPost']);
if($ShowEditTopic===true) {
$_POST['TopicName'] = stripcslashes(htmlspecialchars($_POST['TopicName'], ENT_QUOTES, $Settings['charset']));
//$_POST['TopicName'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['TopicName']);
$_POST['TopicName'] = remove_spaces($_POST['TopicName']); }
/*    <_<  iWordFilter  >_>      
   by Kazuki Przyborowski - Cool Dude 2k */
$melanieqy=sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."wordfilter\"", array(null));
$melaniert=sql_query($melanieqy,$SQLStat);
$melanienm=sql_num_rows($melaniert);
$melanies=0;
while ($melanies < $melanienm) {
$Filter=sql_result($melaniert,$melanies,"FilterWord");
$Replace=sql_result($melaniert,$melanies,"Replacement");
$CaseInsensitive=sql_result($melaniert,$melanies,"CaseInsensitive");
if($CaseInsensitive=="on") { $CaseInsensitive = "yes"; }
if($CaseInsensitive=="off") { $CaseInsensitive = "no"; }
if($CaseInsensitive!="yes"||$CaseInsensitive!="no") { $CaseInsensitive = "no"; }
$WholeWord=sql_result($melaniert,$melanies,"WholeWord");
if($WholeWord=="on") { $WholeWord = "yes"; }
if($WholeWord=="off") { $WholeWord = "no"; }
if($WholeWord!="yes"&&$WholeWord!="no") { $WholeWord = "no"; }
$Filter = preg_quote($Filter, "/");
if($CaseInsensitive!="yes"&&$WholeWord=="yes") {
$_POST['ReplyDesc'] = preg_replace("/\b(".$Filter.")\b/", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/\b(".$Filter.")\b/", $Replace, $_POST['ReplyPost']); }
if($CaseInsensitive=="yes"&&$WholeWord=="yes") {
$_POST['ReplyDesc'] = preg_replace("/\b(".$Filter.")\b/i", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/\b(".$Filter.")\b/i", $Replace, $_POST['ReplyPost']); }
if($CaseInsensitive!="yes"&&$WholeWord!="yes") {
$_POST['ReplyDesc'] = preg_replace("/".$Filter."/", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/".$Filter."/", $Replace, $_POST['ReplyPost']); }
if($CaseInsensitive=="yes"&&$WholeWord!="yes") {
$_POST['ReplyDesc'] = preg_replace("/".$Filter."/i", $Replace, $_POST['ReplyDesc']); 
$_POST['ReplyPost'] = preg_replace("/".$Filter."/i", $Replace, $_POST['ReplyPost']); }
++$melanies; } sql_free_result($melaniert);
$lonewolfqy=sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."restrictedwords\" WHERE \"RestrictedTopicName\"='yes' or \"RestrictedUserName\"='yes'", array(null));
$lonewolfrt=sql_query($lonewolfqy,$SQLStat);
$lonewolfnm=sql_num_rows($lonewolfrt);
$lonewolfs=0; $RMatches = null; $RGMatches = null;
while ($lonewolfs < $lonewolfnm) {
$RWord=sql_result($lonewolfrt,$lonewolfs,"Word");
$RCaseInsensitive=sql_result($lonewolfrt,$lonewolfs,"CaseInsensitive");
if($RCaseInsensitive=="on") { $RCaseInsensitive = "yes"; }
if($RCaseInsensitive=="off") { $RCaseInsensitive = "no"; }
if($RCaseInsensitive!="yes"||$RCaseInsensitive!="no") { $RCaseInsensitive = "no"; }
$RWholeWord=sql_result($lonewolfrt,$lonewolfs,"WholeWord");
if($RWholeWord=="on") { $RWholeWord = "yes"; }
if($RWholeWord=="off") { $RWholeWord = "no"; }
if($RWholeWord!="yes"||$RWholeWord!="no") { $RWholeWord = "no"; }
$RestrictedTopicName=sql_result($lonewolfrt,$lonewolfs,"RestrictedTopicName");
if($RestrictedTopicName=="on") { $RestrictedTopicName = "yes"; }
if($RestrictedTopicName=="off") { $RestrictedTopicName = "no"; }
if($RestrictedTopicName!="yes"||$RestrictedTopicName!="no") { $RestrictedTopicName = "no"; }
$RestrictedUserName=sql_result($lonewolfrt,$lonewolfs,"RestrictedUserName");
if($RestrictedUserName=="on") { $RestrictedUserName = "yes"; }
if($RestrictedUserName=="off") { $RestrictedUserName = "no"; }
if($RestrictedUserName!="yes"||$RestrictedUserName!="no") { $RestrictedUserName = "no"; }
$RWord = preg_quote($RWord, "/");
if($RCaseInsensitive!="yes"&&$RWholeWord=="yes") {
if($RestrictedTopicName=="yes") {
$RMatches = preg_match("/\b(".$RWord.")\b/", $_POST['TopicName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/\b(".$RWord.")\b/", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
if($RCaseInsensitive=="yes"&&$RWholeWord=="yes") {
if($RestrictedTopicName=="yes") {
$RMatches = preg_match("/\b(".$RWord.")\b/i", $_POST['TopicName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/\b(".$RWord.")\b/i", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
if($RCaseInsensitive!="yes"&&$RWholeWord!="yes") {
if($RestrictedTopicName=="yes") {
$RMatches = preg_match("/".$RWord."/", $_POST['TopicName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/".$RWord."/", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
if($RCaseInsensitive=="yes"&&$RWholeWord!="yes") {
if($RestrictedTopicName=="yes") {
$RMatches = preg_match("/".$RWord."/i", $_POST['TopicName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/".$RWord."/i", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
++$lonewolfs; } sql_free_result($lonewolfrt);
if ($_POST['ReplyDesc']==null) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Reply Description.<br />
	</span>&#160;</td>
</tr>
<?php } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$_POST['GuestName']==null) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Guest Name.<br />
	</span>&#160;</td>
</tr>
<?php } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$RGMatches==true) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />This Guest Name is restricted to use.<br />
	</span>&#160;</td>
</tr>
<?php } if($PermissionInfo['CanEditReplys'][$TopicForumID]=="no") { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You do not have permission to edit a reply here.<br />
	</span>&#160;</td>
</tr>
<?php } if($PermissionInfo['CanEditReplysClose'][$TopicForumID]=="no"&&$TopicClosed==1) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You do not have permission to edit a reply here.<br />
	</span>&#160;</td>
</tr>
<?php } if($ShowEditTopic===true&&$_POST['TopicName']==null) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Topic Name.<br />
	</span>&#160;</td>
</tr>
<?php } if ($_POST['ReplyPost']==null) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Reply.<br />
	</span>&#160;</td>
</tr>
<?php } if($RMatches==true) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />This Topic Name is restricted to use.<br />
	</span>&#160;</td>
</tr>
<?php } if ($Error=="Yes") {
redirect("refresh",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']),"3"); ?>
<tr>
	<td><span class="TableMessage">
	<br />Click <a href="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>">here</a> to goto index page.<br />&#160;
	</span><br /></td>
</tr>
<?php } if ($Error!="Yes") { $LastActive = $utccurtime->getTimestamp();
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i LIMIT 1", array($_SESSION['UserID']));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult);
$rei=0;
while ($rei < $renum) {
$User1ID=$_SESSION['UserID'];
$User1Name=sql_result($reresult,$rei,"Name");
if($_SESSION['UserGroup']==$Settings['GuestGroup']) { $User1Name = $_POST['GuestName']; }
++$rei; }
sql_free_result($reresult);
$EditUserIP=$_SERVER['REMOTE_ADDR'];
$_SESSION['LastPostTime'] = $utccurtime->getTimestamp() + $GroupInfo['FloodControl'];
if($_SESSION['UserID']!=0&&$_SESSION['UserID']!=-1) {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."members\" SET \"LastActive\"=%i,\"IP\"='%s',\"LastPostTime\"=%i WHERE \"id\"=%i", array($LastActive,$EditUserIP,$_SESSION['LastPostTime'],$_SESSION['UserID']));
sql_query($queryupd,$SQLStat); }
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."posts\" SET \"LastUpdate\"=%i,\"EditUser\"=%i,\"EditUserName\"='%s',\"Post\"='%s',\"Description\"='%s',\"EditIP\"='%s' WHERE \"id\"=%i", array($LastActive,$User1ID,$User1Name,$_POST['ReplyPost'],$_POST['ReplyDesc'],$EditUserIP,$_GET['post']));
sql_query($queryupd,$SQLStat);
if($ShowEditTopic===true) {
$queryupd = sql_pre_query("UPDATE \"".$Settings['sqltable']."topics\" SET \"TopicName\"='%s',\"Description\"='%s' WHERE \"id\"=%i", array($_POST['TopicName'],$_POST['ReplyDesc'],$TopicID));
sql_query($queryupd,$SQLStat); } } 
redirect(url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic'],FALSE).$Settings['qstr']."#post".$_GET['post'],"3");
$erpage = "&page=1";
if(isset($_POST['page'])&&is_numeric($_POST['page'])) {
	$erpage = "&page=".$_POST['page']; }
?>
<tr>
	<td><span class="TableMessage"><br />
	Reply to Topic <?php echo $TopicName; ?> was edited.<br />
	Click <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID.$erpage,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']).$qstrhtml."&#35;post".$_GET['post']; ?>">here</a> to view topic.<br />&#160;
	</span><br /></td>
</tr>
</table>
</td></tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<?php } $frnext = "off";
if(!isset($_GET['fastreply'])) {
	$_GET['fastreply'] = "off"; }
if($_GET['fastreply']=="on") {
	$frnext = "off"; $extrafe = null; }
if($_GET['fastreply']!="on") {
	$frnext = "on"; $extrafe = "&#35;FastReply"; }
if($pstring!=null||$CanMakeReply=="yes"||$CanMakeTopic=="yes") {
?>
<table class="Table2" style="width: 100%;">
<tr>
 <td style="width: 30%; text-align: left;"><?php echo $pstring; ?></td>
 <td style="width: 70%; text-align: right;">
 <?php if($CanMakeReply=="yes") { ?>
 <a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=create&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>"><?php echo $ThemeSet['AddReply']; ?></a>
 <?php if(isset($ThemeSet['FastReply'])&&$ThemeSet['FastReply']!=null) { ?>
 <?php echo $ThemeSet['ButtonDivider']; ?>
 <a onclick="toggletag('FastReply'); toggletag('MkFastReply'); return false;" href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$_GET['id']."&page=".$_GET['page']."&fastreply=".$frnext,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']).$extrafe; ?>"><?php echo $ThemeSet['FastReply']; ?></a>
 <?php } } if($PermissionInfo['CanMakeTopics'][$TopicForumID]=="yes") {
	if($CanMakeTopic=="yes"&&$CanMakeReply=="yes") { ?>
 <?php echo $ThemeSet['ButtonDivider']; } ?>
 <a href="<?php echo url_maker($exfile['forum'],$Settings['file_ext'],"act=create&id=".$TopicForumID,$Settings['qstr'],$Settings['qsep'],$prexqstr['forum'],$exqstr['forum']); ?>"><?php echo $ThemeSet['NewTopic']; ?></a>
 <?php } ?></td>
</tr>
</table>
<div class="DivTable2">&#160;</div>
<?php } }
if($_GET['act']=="view"&&$CanMakeReply=="yes") {  
if(!isset($_GET['fastreply'])) { $_GET['fastreply'] = false; }
if($_GET['fastreply']===true||
	$_GET['fastreply']=="on") { $fps = " "; }
if($_GET['fastreply']!==true&&
	$_GET['fastreply']!="on") { $fps = " style=\"display: none;\" "; }
$QuoteReply = null; $QuoteDescription = null;
$queryra = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."posts\" WHERE \"TopicID\"=%i ORDER BY \"TimeStamp\" ASC LIMIT 1", array($_GET['id']));
$resultra=sql_query($queryra,$SQLStat);
$numrose=sql_num_rows($resultra);
$QuoteDescription=sql_result($resultra,0,"Description"); 
$QuoteDescription = str_replace("Re: ","",$QuoteDescription);
$QuoteDescription = "Re: ".$QuoteDescription;
sql_free_result($resultra);
$UFID = rand_uuid("rand");
$_SESSION['UserFormID'] = $UFID;
?>
<div class="Table1Border"<?php echo $fps; ?>id="FastReply">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>#<?php echo $TopicID; ?>"><?php echo $TopicName; ?></a></span></div>
<?php } ?>
<table class="Table1" id="MakeReply<?php echo $TopicForumID; ?>">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1" id="ReplyStart<?php echo $TopicForumID; ?>">
<td class="TableColumn1" colspan="2"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=view&id=".$TopicID."&page=".$_GET['page'],$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>#<?php echo $TopicID; ?>"><?php echo $TopicName; ?></a></span>
</td>
</tr><?php } ?>
<tr id="MakeReplyRow<?php echo $TopicForumID; ?>" class="TableRow2">
<td class="TableColumn2" colspan="2" style="width: 100%;">Making a Reply in Topic <?php echo $TopicName; ?></td>
</tr>
<tr class="TableRow3" id="MkReply<?php echo $TopicForumID; ?>">
<td class="TableColumn3" style="width: 15%; vertical-align: middle; text-align: center;">
<div style="width: 100%; height: 160px; overflow: auto;">
<table style="width: 100%; text-align: center;"><?php
$melanie_query=sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."smileys\" WHERE \"Display\"='yes'", array(null));
$melanie_result=sql_query($melanie_query,$SQLStat);
$melanie_num=sql_num_rows($melanie_result);
$melanie_p=0; $SmileRow=0; $SmileCRow=0;
while ($melanie_p < $melanie_num) { ++$SmileRow;
$FileName=sql_result($melanie_result,$melanie_p,"FileName");
$SmileName=sql_result($melanie_result,$melanie_p,"SmileName");
$SmileText=sql_result($melanie_result,$melanie_p,"SmileText");
$SmileDirectory=sql_result($melanie_result,$melanie_p,"Directory");
$ShowSmile=sql_result($melanie_result,$melanie_p,"Display");
$ReplaceType=sql_result($melanie_result,$melanie_p,"ReplaceCI");
if($SmileRow==1) { ?><tr>
	<?php } if($SmileRow<5) { ++$SmileCRow; ?>
	<td><img src="<?php echo $SmileDirectory."".$FileName; ?>" style="vertical-align: middle; border: 0px; cursor: pointer;" title="<?php echo $SmileName; ?>" alt="<?php echo $SmileName; ?>" onclick="addsmiley('ReplyPost','&#160;<?php echo htmlspecialchars($SmileText, ENT_QUOTES, $Settings['charset']); ?>&#160;')" /></td>
	<?php } if($SmileRow==5) { ++$SmileCRow; ?>
	<td><img src="<?php echo $SmileDirectory."".$FileName; ?>" style="vertical-align: middle; border: 0px; cursor: pointer;" title="<?php echo $SmileName; ?>" alt="<?php echo $SmileName; ?>" onclick="addsmiley('ReplyPost','&#160;<?php echo htmlspecialchars($SmileText, ENT_QUOTES, $Settings['charset']); ?>&#160;')" /></td></tr>
	<?php $SmileCRow=0; $SmileRow=0; }
++$melanie_p; }
if($SmileCRow<5&&$SmileCRow!=0) {
$SmileCRowL = 5 - $SmileCRow;
echo "<td colspan=\"".$SmileCRowL."\">&#160;</td></tr>"; }
echo "</table>";
sql_free_result($melanie_result);
?></div></td>
<td class="TableColumn3" style="width: 85%;">
<form style="display: inline;" method="post" id="MkReplyForm" action="<?php echo url_maker($exfile['topic'],$Settings['file_ext'],"act=makereply&id=".$TopicID,$Settings['qstr'],$Settings['qsep'],$prexqstr['topic'],$exqstr['topic']); ?>">
<table style="text-align: left;">
<tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="ReplyDesc">Insert Reply Description:</label></td>
	<td style="width: 50%;"><input maxlength="45" type="text" name="ReplyDesc" class="TextBox" id="ReplyDesc" size="20" value="<?php echo $QuoteDescription; ?>" /></td>
</tr><?php if($_SESSION['UserGroup']==$Settings['GuestGroup']) { ?><tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="GuestName">Insert Guest Name:</label></td>
	<?php if(!isset($_SESSION['GuestName'])) { ?>
	<td style="width: 50%;"><input maxlength="25" type="text" name="GuestName" class="TextBox" id="GuestName" size="20" /></td>
	<?php } if(isset($_SESSION['GuestName'])) { ?>
	<td style="width: 50%;"><input maxlength="25" type="text" name="GuestName" class="TextBox" id="GuestName" size="20" value="<?php echo $_SESSION['GuestName']; ?>" /></td>
<?php } ?></tr><?php } ?>
</table>
<table style="text-align: left;">
<tr style="text-align: left;">
<td style="width: 100%;">
<label class="TextBoxLabel" for="ReplyPost">Insert Your Reply:</label><br />
<textarea rows="10" name="ReplyPost" id="ReplyPost" cols="40" class="TextBox"><?php echo $QuoteReply; ?></textarea><br />
<?php if($_SESSION['UserGroup']==$Settings['GuestGroup']&&$Settings['captcha_guest']=="on") { ?>
<label class="TextBoxLabel" for="signcode"><img src="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=MkCaptcha",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>" alt="CAPTCHA Code" title="CAPTCHA Code" /></label><br />
<input maxlength="25" type="text" class="TextBox" name="signcode" size="20" id="signcode" value="Enter SignCode" /><br />
<?php } ?>
<input type="hidden" name="act" value="makereplies" style="display: none;" />
<input type="hidden" style="display: none;" name="fid" value="<?php echo $UFID; ?>" />
<input type="hidden" style="display: none;" name="ubid" value="<?php echo $Settings['BoardUUID']; ?>" />
<?php if($_SESSION['UserGroup']!=$Settings['GuestGroup']) { ?>
<input type="hidden" name="GuestName" value="null" style="display: none;" />
<?php } ?>
<input type="hidden" name="act" value="makereplies" style="display: none;" />
<?php if($_SESSION['UserGroup']!=$Settings['GuestGroup']) { ?>
<input type="hidden" name="GuestName" value="null" style="display: none;" />
<?php } ?>
<input type="submit" class="Button" value="Make Reply" name="make_reply" />
<input type="reset" value="Reset Form" class="Button" name="Reset_Form" />
</td></tr></table>
</form></td></tr>
<tr id="MkReplyEnd<?php echo $TopicForumID; ?>" class="TableRow4">
<td class="TableColumn4" colspan="2">&#160;</td>
</tr>
</table></div>
<div<?php echo $fps; ?>id="MkFastReply" class="MkFastReply">&#160;</div>
<?php }
$uviewlcuttime = $utccurtime->getTimestamp();
$uviewltime = $uviewlcuttime - ini_get("session.gc_maxlifetime");
$uviewlquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."sessions\" WHERE \"expires\" >= %i AND \"session_id\"<>'%s' AND \"serialized_data\" LIKE '%s' ORDER BY \"expires\" DESC", array($uviewltime, session_id(), "%currenttopicid:".$TopicID.";%"));
$uviewlresult=sql_query($uviewlquery,$SQLStat);
$uviewlnum=sql_num_rows($uviewlresult);
$uviewli=0; $uviewlmn = 0; $uviewlgn = 0; $uviewlan = 0; $uviewlmbn = 0;
$MembersViewList = null; $GuestsOnline = null;
while ($uviewli < $uviewlnum) {
$session_data=sql_result($uviewlresult,$uviewli,"session_data"); 
$serialized_data=sql_result($uviewlresult,$uviewli,"serialized_data");
$session_user_agent=sql_result($uviewlresult,$uviewli,"user_agent"); 
$session_ip_address=sql_result($uviewlresult,$uviewli,"ip_address");
//$UserSessInfo = unserialize_session($session_data);
$UserSessInfo = unserialize($serialized_data);
if(!isset($UserSessInfo['UserGroup'])) { $UserSessInfo['UserGroup'] = $Settings['GuestGroup']; }
$AmIHiddenUser = "no";
$user_agent_check = false;
if(user_agent_check($session_user_agent)) {
	$user_agent_check = user_agent_check($session_user_agent); }
if($UserSessInfo['UserGroup']!=$Settings['GuestGroup']||$user_agent_check!==false) {
$PreAmIHiddenUser = GetUserName($UserSessInfo['UserID'],$Settings['sqltable'],$SQLStat);
$AmIHiddenUser = $PreAmIHiddenUser['Hidden'];
if(($AmIHiddenUser=="no"&&$UserSessInfo['UserID']>0)||$user_agent_check!==false) {
if($uviewlmbn>0) { $MembersViewList .= ", "; }
if($user_agent_check===false) {
$uatitleadd = null;
if($GroupInfo['CanViewUserAgent']=="yes") { $uatitleadd = " title=\"".htmlentities($session_user_agent, ENT_QUOTES, $Settings['charset'])."\""; }
$MembersViewList .= "<a".$uatitleadd." href=\"".url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$UserSessInfo['UserID'],$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member'])."\">".$UserSessInfo['MemberName']."</a>"; 
if($GroupInfo['CanViewIPAddress']=="yes") {
$MembersViewList .= " (<a title=\"".$session_ip_address."\" onclick=\"window.open(this.href);return false;\" href=\"".sprintf($IPCheckURL,$session_ip_address)."\">".$session_ip_address."</a>)"; }
++$uviewlmn; ++$uviewlmbn; }
if($user_agent_check!==false) {
$uatitleadd = null;
if($GroupInfo['CanViewUserAgent']=="yes") { $uatitleadd = " title=\"".htmlentities($session_user_agent, ENT_QUOTES, $Settings['charset'])."\""; }
$MembersViewList .= "<span".$uatitleadd.">".$user_agent_check."</span>"; 
if($GroupInfo['CanViewIPAddress']=="yes") {
$MembersViewList .= " (<a title=\"".$session_ip_address."\" onclick=\"window.open(this.href);return false;\" href=\"".sprintf($IPCheckURL,$session_ip_address)."\">".$session_ip_address."</a>)"; }
++$uviewlmbn; } }
if($UserSessInfo['UserID']<=0||$AmIHiddenUser=="yes") {
if($user_agent_check===false) {
++$uviewlan; } } }
if($UserSessInfo['UserGroup']==$Settings['GuestGroup']) {
/*$uatitleadd = null;
if($GroupInfo['CanViewUserAgent']=="yes") { $uatitleadd = " title=\"".htmlentities($session_user_agent, ENT_QUOTES, $Settings['charset'])."\""; }
$GuestsViewList .= "<a".$uatitleadd." href=\"".url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$MemList['ID'],$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member'])."\">".$MemList['Name']."</a>";
if($GroupInfo['CanViewIPAddress']=="yes") {
$GuestsViewList .= " (<a title=\"".$session_ip_address."\" onclick=\"window.open(this.href);return false;\" href=\"".sprintf($IPCheckURL,$session_ip_address)."\">".$session_ip_address."</a>)"; } */
++$uviewlgn; }
++$uviewli; }
if(!isset($_SESSION['UserGroup'])) { $_SESSION['UserGroup'] = $Settings['GuestGroup']; }
$AmIHiddenUser = "no";
$user_agent_check = false;
if(user_agent_check($_SERVER['HTTP_USER_AGENT'])) {
	$user_agent_check = user_agent_check($_SERVER['HTTP_USER_AGENT']); }
if($_SESSION['UserGroup']!=$Settings['GuestGroup']||$user_agent_check!==false) {
$PreAmIHiddenUser = GetUserName($_SESSION['UserID'],$Settings['sqltable'],$SQLStat);
$AmIHiddenUser = $PreAmIHiddenUser['Hidden'];
if(($AmIHiddenUser=="no"&&$_SESSION['UserID']>0)||$user_agent_check!==false) {
if($uviewlmbn>0) { $MembersViewList = ", ".$MembersViewList; }
if($user_agent_check===false) {
$uatitleadd = null;
if($GroupInfo['CanViewUserAgent']=="yes") { $uatitleadd = " title=\"".htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, $Settings['charset'])."\""; }
if($GroupInfo['CanViewIPAddress']=="yes") {
$MembersViewList = " (<a title=\"".$_SERVER['REMOTE_ADDR']."\" onclick=\"window.open(this.href);return false;\" href=\"".sprintf($IPCheckURL,$_SERVER['REMOTE_ADDR'])."\">".$_SERVER['REMOTE_ADDR']."</a>)".$MembersViewList; }
$MembersViewList = "<a".$uatitleadd." href=\"".url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$_SESSION['UserID'],$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member'])."\">".$_SESSION['MemberName']."</a>".$MembersViewList; 
++$uviewlmn; ++$uviewlmbn; }
if($user_agent_check!==false) {
$uatitleadd = null;
if($GroupInfo['CanViewIPAddress']=="yes") {
$MembersViewList = " (<a title=\"".$_SERVER['REMOTE_ADDR']."\" onclick=\"window.open(this.href);return false;\" href=\"".sprintf($IPCheckURL,$_SERVER['REMOTE_ADDR'])."\">".$_SERVER['REMOTE_ADDR']."</a>)".$MembersViewList; }
if($GroupInfo['CanViewUserAgent']=="yes") { $uatitleadd = " title=\"".htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, $Settings['charset'])."\""; }
$MembersViewList = "<span".$uatitleadd.">".$user_agent_check."</span>".$MembersViewList; 
++$uviewlmbn; } }
if($_SESSION['UserID']<=0||$AmIHiddenUser=="yes") {
if($user_agent_check===false) {
++$uviewlan; } } }
if($_SESSION['UserGroup']==$Settings['GuestGroup']) {
/*$uatitleadd = null;
if($GroupInfo['CanViewUserAgent']=="yes") { $uatitleadd = " title=\"".htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, $Settings['charset'])."\""; }
if($GroupInfo['CanViewIPAddress']=="yes") {
$GuestsViewList = " (<a title=\"".$_SERVER['REMOTE_ADDR']."\" onclick=\"window.open(this.href);return false;\" href=\"".sprintf($IPCheckURL,$_SERVER['REMOTE_ADDR'])."\">".$_SERVER['REMOTE_ADDR']."</a>)".$GuestsViewList; }
$GuestsViewList = "<a".$uatitleadd." href=\"".url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$MemList['ID'],$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member'])."\">".$MemList['Name']."</a>".$GuestsViewList; */
++$uviewlgn; }
++$uviewlnum;
?>
<div class="StatsBorder">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableStatsRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile[$ForumType],$Settings['file_ext'],"act=view&id=".$ForumID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr[$ForumType],$exqstr[$ForumType]); ?>">Topic Statistics</a></span></div>
<?php } ?>
<table id="BoardStats" class="TableStats1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableStatsRow1">
<td class="TableStatsColumn1" colspan="2"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile[$ForumType],$Settings['file_ext'],"act=view&id=".$ForumID."&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr[$ForumType],$exqstr[$ForumType]); ?>">Topic Statistics</a></span>
</td>
</tr><?php } ?>
<tr id="Stats1" class="TableStatsRow2">
<td class="TableStatsColumn2" colspan="2" style="width: 100%; font-weight: bold;"><?php echo $uviewlnum; ?> users viewing topic</td>
</tr>
<tr class="TableStatsRow3" id="Stats2">
<td style="width: 4%;" class="TableStatsColumn3"><div class="statsicon">
<?php echo $ThemeSet['BoardStatsIcon']; ?></div></td>
<td style="width: 96%;" class="TableStatsColumn3"><div class="statsinfo">
&#160;<span style="font-weight: bold;"><?php echo $uviewlgn; ?></span> guests, <span style="font-weight: bold;"><?php echo $uviewlmn; ?></span> members, <span style="font-weight: bold;"><?php echo $uviewlan; ?></span> anonymous members <br />
<?php if($MembersViewList!=null) { ?>&#160;<?php echo $MembersViewList."\n<br />"; } ?>
</div></td>
</tr>
<tr id="Stats7" class="TableStatsRow4">
<td class="TableStatsColumn4" colspan="2">&#160;</td>
</tr>
</table></div>
<div class="DivStats">&#160;</div>

