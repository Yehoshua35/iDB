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

    $FileInfo: messages.php - Last Update: 6/28/2023 SVN 997 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="messages.php"||$File3Name=="/messages.php") {
	require('index.php');
	exit(); }
if(!is_numeric($_GET['id'])) { $_GET['id'] = null; }
if(!is_numeric($_GET['post'])) { $_GET['post'] = null; }
if(!is_numeric($_GET['page'])) { $_GET['page'] = 1; }
// Check if we can read/send PM
if($_SESSION['UserGroup']==$Settings['GuestGroup']||$GroupInfo['CanPM']=="no") {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
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
$_SESSION['ViewingTitle'] = "Messages";
$_SESSION['ExtraData'] = "currentact:".$_GET['act']."; currentcategoryid:0; currentforumid:0; currenttopicid:0; currentmessageid:0; currenteventid:0; currentmemberid:0;";
if($_GET['act']=="view"||$_GET['act']=="viewsent"||$_GET['act']=="read") {
?>
<div class="NavLinks"><?php echo $ThemeSet['NavLinkIcon']; ?><a href="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>"><?php echo $Settings['board_name']; ?></a><?php echo $ThemeSet['NavLinkDivider']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">Mailbox</a></div>
<div class="DivNavLinks">&#160;</div>
<table class="Table3">
<tr style="width: 100%; vertical-align: top;">
	<td style="width: 15%; vertical-align: top;">
	<div class="TableSMenuBorder">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableSMenuRow1">
<?php echo $ThemeSet['TitleIcon']; ?>Messenger</div>
<?php } ?>
<table id="ProfileLinks" class="TableSMenu" style="width: 100%; text-align: left; vertical-align: top;">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableSMenuRow1">
<td class="TableSMenuColumn1"><?php echo $ThemeSet['TitleIcon']; ?>Messenger</td>
</tr><?php } ?>
<tr class="TableSMenuRow2">
<td class="TableSMenuColumn2">&#160;</td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">View MailBox</a></td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">View SentBox</a></td>
</tr><tr class="TableSMenuRow3">
<td class="TableSMenuColumn3"><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=create",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">Send Message</a></td>
</tr><tr class="TableSMenuRow4">
<td class="TableSMenuColumn4">&#160;</td>
</tr></table></div>
</td>
	<td style="width: 85%; vertical-align: top;">
<?php
if($_GET['act']=="view") {
//Get SQL LIMIT Number
$nums = $_GET['page'] * $Settings['max_pmlist'];
$PageLimit = $nums - $Settings['max_pmlist'];
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."messenger\" WHERE \"ReciverID\"=%i ORDER BY \"DateSend\" DESC ".$SQLimit, array($_SESSION['UserID'],$PageLimit,$Settings['max_pmlist']));
$rnquery = sql_pre_query("SELECT COUNT(*) FROM \"".$Settings['sqltable']."messenger\" WHERE \"ReciverID\"=%i", array($_SESSION['UserID']));
$result=sql_query($query,$SQLStat);
$rnresult=sql_query($rnquery,$SQLStat);
$NumberMessage = sql_result($rnresult,0);
sql_free_result($rnresult);
if($NumberMessage==null) { 
	$NumberMessage = 0; }
$num = $NumberMessage;
$num=sql_num_rows($result);
//Start MessengerList Page Code
if(!isset($Settings['max_pmlist'])) { $Settings['max_pmlist'] = 10; }
if($_GET['page']==null) { $_GET['page'] = 1; } 
if($_GET['page']<=0) { $_GET['page'] = 1; }
$nums = $_GET['page'] * $Settings['max_pmlist'];
if($nums>$num) { $nums = $num; }
$numz = $nums - $Settings['max_pmlist'];
if($numz<=0) { $numz = 0; }
//$i=$numz;
if($nums<$num) { $nextpage = $_GET['page'] + 1; }
if($nums>=$num) { $nextpage = $_GET['page']; }
if($numz>=$Settings['max_pmlist']) { $backpage = $_GET['page'] - 1; }
if($_GET['page']<=1) { $backpage = 1; }
$pnum = $num; $l = 1; $Pages = array();
while ($pnum>0) {
if($pnum>=$Settings['max_pmlist']) { 
	$pnum = $pnum - $Settings['max_pmlist']; 
	$Pages[$l] = $l; ++$l; }
if($pnum<$Settings['max_pmlist']&&$pnum>0) { 
	$pnum = $pnum - $pnum; 
	$Pages[$l] = $l; ++$l; } }
//End MessengerList Page Code
$num=sql_num_rows($result);
$i=0;
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
$pstring = $pstring."<span class=\"pagelink\">a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=".$Pback,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&lt;</a></span> "; }
if($Pagez[$pagei]!=null&&
   $Pagez[$pagei]!="First"&&
   $Pagez[$pagei]!="Last") {
if($pagei!=3) { 
$pstring = $pstring."<span class=\"pagelink\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=".$Pagez[$pagei],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">".$Pagez[$pagei]."</a></span> "; }
if($pagei==3) { 
$pstring = $pstring."<span class=\"pagecurrent\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=".$Pagez[$pagei],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">".$Pagez[$pagei]."</a></span> "; } }
if($Pagez[$pagei]=="First") {
$pstring = $pstring."<span class=\"pagelinklast\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&laquo;</a></span> "; }
if($Pagez[$pagei]=="Last") {
$ptestnext = $pagenext + 1;
$paget = $pagei - 1;
$Pnext = $_GET['page'] + 1;
$pstring = $pstring."<span class=\"pagelink\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=".$Pnext,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&gt;</a></span> ";
if($ptestnext<$pagenum) {
$pstring = $pstring."<span class=\"pagelinklast\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=".$pagenum,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&raquo;</a></span> "; } }
	++$pagei; } $pstring = $pstring."</div>"; }
//echo $pstring;
//List Page Number Code end
echo $pstring; 
if($pagenum>1) {
?>
<div class="DivPageLinks">&#160;</div>
<?php } ?>
<div class="TableMenuBorder">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableMenuRow1">
<span style="float: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">MailBox&#160;(<?php echo $PMNumber; ?>)</a>
</span>&#160;</div>
<?php } ?>
<table class="TableMenu" style="width: 100%;">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableMenuRow1">
<td class="TableMenuColumn1" colspan="4"><span style="float: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">MailBox&#160;(<?php echo $PMNumber; ?>)</a>
</span>&#160;</td>
</tr><?php } ?>
<tr id="Messenger" class="TableMenuRow2">
<th class="TableMenuColumn2" style="width: 4%;">State</th>
<th class="TableMenuColumn2" style="width: 46%;">Message Name</th>
<th class="TableMenuColumn2" style="width: 25%;">Sender</th>
<th class="TableMenuColumn2" style="width: 25%;">Time</th>
</tr>
<?php
while ($i < $num) {
$PMID=sql_result($result,$i,"id");
$PMDiscussionID=sql_result($result,$i,"DiscussionID");
$SenderID=sql_result($result,$i,"SenderID");
$SenderIP=sql_result($result,$i,"IP");
$PreSenderName = GetUserName($SenderID,$Settings['sqltable'],$SQLStat);
if($PreSenderName['Name']===null) { $SenderID = -1;
$PreSenderName = GetUserName($SenderID,$Settings['sqltable'],$SQLStat); }
$SenderName = $PreSenderName['Name'];
$SenderHidden = $PreSenderName['Hidden'];
$ReciverID=sql_result($result,$i,"ReciverID");
$PreReciverName = GetUserName($ReciverID,$Settings['sqltable'],$SQLStat);
if($PreReciverName['Name']===null) { $ReciverID = -1;
$PreReciverName = GetUserName($ReciverID,$Settings['sqltable'],$SQLStat); }
$ReciverName = $PreReciverName['Name'];
$ReciverHidden = $PreReciverName['Hidden'];
$PMGuest=sql_result($result,$i,"GuestName");
$MessageName=sql_result($result,$i,"MessageTitle");
$MessageDesc=sql_result($result,$i,"Description");
$DateSend=sql_result($result,$i,"DateSend");
$tmpusrcurtime = new DateTime();
$tmpusrcurtime->setTimestamp($DateSend);
$tmpusrcurtime->setTimezone($usertz);
$DateSend=$tmpusrcurtime->format($_SESSION['iDBDateFormat'].", ".$_SESSION['iDBTimeFormat']);
$MessageStat=sql_result($result,$i,"Read");
if($SenderName=="Guest") { $SenderName=$PMGuest;
if($SenderName==null) { $SenderName="Guest"; } }
$PreMessage = $ThemeSet['MessageUnread'];
if ($MessageStat==0) {
	$PreMessage=$ThemeSet['MessageUnread']; }
if ($MessageStat==1) {
	$PreMessage=$ThemeSet['MessageRead']; }
?>
<tr class="TableMenuRow3" id="Message<?php echo $PMID; ?>">
<td class="TableMenuColumn3"><div class="messagestate">
<?php echo $PreMessage; ?></div></td>
<td class="TableMenuColumn3"><div class="messagename">
<?php if($PMDiscussionID<=0) { ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=read&id=".$PMID,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']).$qstrhtml."&#35;message".$PMID; ?>"><?php echo $MessageName; ?></a><?php } if($PMDiscussionID>0) { ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=read&id=".$PMDiscussionID,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']).$qstrhtml."&#35;message".$PMID; ?>"><?php echo $MessageName; ?></a><?php } ?></div>
<div class="messagedesc"><?php echo $MessageDesc; ?></div></td>
<td class="TableMenuColumn3" style="text-align: center;"><?php
if($SenderID>0&&$SenderHidden=="no") {
echo "<a href=\"";
echo url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$SenderID,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member']);
echo "\">".$SenderName."</a>"; }
if($SenderID<=0||$SenderHidden=="yes") {
echo "<span>".$SenderName."</span>"; }
?></td>
<td class="TableMenuColumn3" style="text-align: center;"><?php echo $DateSend; ?></td>
</tr>
<?php ++$i; } sql_free_result($result); ?>
<tr id="MessengerEnd" class="TableMenuRow4">
<td class="TableMenuColumn4" colspan="4">&#160;</td>
</tr>
<?php } 
if($_GET['act']=="viewsent") {
//Get SQL LIMIT Number
$nums = $_GET['page'] * $Settings['max_pmlist'];
$PageLimit = $nums - $Settings['max_pmlist'];
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."messenger\" WHERE \"SenderID\"=%i ORDER BY \"DateSend\" DESC ".$SQLimit, array($_SESSION['UserID'],$PageLimit,$Settings['max_pmlist']));
$rnquery = sql_pre_query("SELECT COUNT(*) FROM \"".$Settings['sqltable']."messenger\" WHERE \"SenderID\"=%i", array($_SESSION['UserID']));
$result=sql_query($query,$SQLStat);
$rnresult=sql_query($rnquery,$SQLStat);
$NumberMessage = sql_result($rnresult,0);
sql_free_result($rnresult);
if($NumberMessage==null) { 
	$NumberMessage = 0; }
$num = $NumberMessage;
$num=sql_num_rows($result);
//Start MessengerList Page Code
if(!isset($Settings['max_pmlist'])) { $Settings['max_pmlist'] = 10; }
if($_GET['page']==null) { $_GET['page'] = 1; } 
if($_GET['page']<=0) { $_GET['page'] = 1; }
$nums = $_GET['page'] * $Settings['max_pmlist'];
if($nums>$num) { $nums = $num; }
$numz = $nums - $Settings['max_pmlist'];
if($numz<=0) { $numz = 0; }
//$i=$numz;
if($nums<$num) { $nextpage = $_GET['page'] + 1; }
if($nums>=$num) { $nextpage = $_GET['page']; }
if($numz>=$Settings['max_pmlist']) { $backpage = $_GET['page'] - 1; }
if($_GET['page']<=1) { $backpage = 1; }
$pnum = $num; $l = 1; $Pages = array();
while ($pnum>0) {
if($pnum>=$Settings['max_pmlist']) { 
	$pnum = $pnum - $Settings['max_pmlist']; 
	$Pages[$l] = $l; ++$l; }
if($pnum<$Settings['max_pmlist']&&$pnum>0) { 
	$pnum = $pnum - $pnum; 
	$Pages[$l] = $l; ++$l; } }
//End MessengerList Page Code
$num=sql_num_rows($result);
$i=0;
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
$pstring = $pstring."<span class=\"pagelink\">a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=".$Pback,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&lt;</a></span> "; }
if($Pagez[$pagei]!=null&&
   $Pagez[$pagei]!="First"&&
   $Pagez[$pagei]!="Last") {
if($pagei!=3) { 
$pstring = $pstring."<span class=\"pagelink\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=".$Pagez[$pagei],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">".$Pagez[$pagei]."</a></span> "; }
if($pagei==3) { 
$pstring = $pstring."<span class=\"pagecurrent\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=".$Pagez[$pagei],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">".$Pagez[$pagei]."</a></span> "; } }
if($Pagez[$pagei]=="First") {
$pstring = $pstring."<span class=\"pagelinklast\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&laquo;</a></span> "; }
if($Pagez[$pagei]=="Last") {
$ptestnext = $pagenext + 1;
$paget = $pagei - 1;
$Pnext = $_GET['page'] + 1;
$pstring = $pstring."<span class=\"pagelink\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=".$Pnext,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&gt;</a></span> ";
if($ptestnext<$pagenum) {
$pstring = $pstring."<span class=\"pagelinklast\"><a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=".$pagenum,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">&raquo;</a></span> "; } }
	++$pagei; } $pstring = $pstring."</div>"; }
//echo $pstring;
//List Page Number Code end
echo $pstring; 
if($pagenum>1) {
?>
<div class="DivPageLinks">&#160;</div>
<?php } ?>
<div class="TableMenuBorder">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableMenuRow1">
<span style="float: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">MailBox&#160;(<?php echo $PMNumber; ?>)</a>
</span>&#160;</div>
<?php } ?>
<table class="TableMenu" style="width: 100%;">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableMenuRow1">
<td class="TableMenuColumn1" colspan="4"><span style="float: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=viewsent&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">MailBox&#160;(<?php echo $PMNumber; ?>)</a>
</span>&#160;</td>
</tr><?php } ?>
<tr id="Messenger" class="TableMenuRow2">
<th class="TableMenuColumn2" style="width: 4%;">State</th>
<th class="TableMenuColumn2" style="width: 46%;">Message Name</th>
<th class="TableMenuColumn2" style="width: 25%;">Sent To</th>
<th class="TableMenuColumn2" style="width: 25%;">Time</th>
</tr>
<?php
while ($i < $num) {
$PMID=sql_result($result,$i,"id");
$PMDiscussionID=sql_result($result,$i,"DiscussionID");
$SenderID=sql_result($result,$i,"SenderID");
$SenderIP=sql_result($result,$i,"IP");
$PreSenderName = GetUserName($SenderID,$Settings['sqltable'],$SQLStat);
if($PreSenderName['Name']===null) { $SenderID = -1;
$PreSenderName = GetUserName($SenderID,$Settings['sqltable'],$SQLStat); }
$SenderName = $PreSenderName['Name'];
$SenderHidden = $PreSenderName['Hidden'];
$ReciverID=sql_result($result,$i,"ReciverID");
$PreReciverName = GetUserName($ReciverID,$Settings['sqltable'],$SQLStat);
if($PreReciverName['Name']===null) { $ReciverID = -1;
$PreReciverName = GetUserName($ReciverID,$Settings['sqltable'],$SQLStat); }
$ReciverName = $PreReciverName['Name'];
$ReciverHidden = $PreReciverName['Hidden'];
$PMGuest=sql_result($result,$i,"GuestName");
$MessageName=sql_result($result,$i,"MessageTitle");
$MessageDesc=sql_result($result,$i,"Description");
$DateSend=sql_result($result,$i,"DateSend");
$tmpusrcurtime = new DateTime();
$tmpusrcurtime->setTimestamp($DateSend);
$tmpusrcurtime->setTimezone($usertz);
$DateSend=$tmpusrcurtime->format($_SESSION['iDBDateFormat'].", ".$_SESSION['iDBTimeFormat']);
$MessageStat=sql_result($result,$i,"Read");
if($SenderName=="Guest") { $SenderName=$PMGuest;
if($SenderName==null) { $SenderName="Guest"; } }
$PreMessage = $ThemeSet['MessageUnread'];
if ($MessageStat==0) {
	$PreMessage=$ThemeSet['MessageUnread']; }
if ($MessageStat==1) {
	$PreMessage=$ThemeSet['MessageRead']; }
?>
<tr class="TableMenuRow3" id="Message<?php echo $PMID; ?>">
<td class="TableMenuColumn3"><div class="messagestate">
<?php echo $PreMessage; ?></div></td>
<td class="TableMenuColumn3"><div class="messagename">
<?php if($PMDiscussionID<=0) { ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=read&id=".$PMID,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']).$qstrhtml."&#35;message".$PMID; ?>"><?php echo $MessageName; ?></a><?php } if($PMDiscussionID>0) { ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=read&id=".$PMDiscussionID,$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']).$qstrhtml."&#35;message".$PMID; ?>"><?php echo $MessageName; ?></a><?php } ?></div>
<div class="messagedesc"><?php echo $MessageDesc; ?></div></td>
<td class="TableMenuColumn3" style="text-align: center;"><?php
if($ReciverID>0&&$ReciverHidden=="no") {
echo "<a href=\"";
echo url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$ReciverID,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member']);
echo "\">".$ReciverName."</a>"; }
if($ReciverID<=0||$ReciverHidden=="yes") {
echo "<span>".$ReciverName."</span>"; }
?></td>
<td class="TableMenuColumn3" style="text-align: center;"><?php echo $DateSend; ?></td>
</tr>
<?php ++$i; } ?>
<tr id="MessengerEnd" class="TableMenuRow4">
<td class="TableMenuColumn4" colspan="4">&#160;</td>
</tr>
<?php sql_free_result($result); }
if($_GET['act']=="read") {
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."messenger\" WHERE (\"id\"=%i OR \"DiscussionID\"=%i) AND (\"SenderID\"=%i OR \"ReciverID\"=%i)", array($_GET['id'], $_GET['id'], $_SESSION['UserID'], $_SESSION['UserID']));
$result=sql_query($query,$SQLStat);
$num=sql_num_rows($result);
$is=0;
if($num==0) { redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
while ($is < $num) {
$PMID=sql_result($result,$is,"id");
$SenderID=sql_result($result,$is,"SenderID");
$SenderIP=sql_result($result,$is,"IP");
$PreSenderName = GetUserName($SenderID,$Settings['sqltable'],$SQLStat);
if($PreSenderName['Name']===null) { $SenderID = -1;
$PreSenderName = GetUserName($SenderID,$Settings['sqltable'],$SQLStat); }
$SenderName = $PreSenderName['Name'];
$SenderHidden = $PreSenderName['Hidden'];
$ReciverID=sql_result($result,$is,"ReciverID");
$PreReciverName = GetUserName($ReciverID,$Settings['sqltable'],$SQLStat);
if($PreReciverName['Name']===null) { $ReciverID = -1;
$PreReciverName = GetUserName($ReciverID,$Settings['sqltable'],$SQLStat); }
$ReciverName = $PreReciverName['Name'];
$ReciverHidden = $PreReciverName['Hidden'];
$PMGuest=sql_result($result,$is,"GuestName");
$MessageName=sql_result($result,$is,"MessageTitle");
$DateSend=sql_result($result,$is,"DateSend");
$tmpusrcurtime = new DateTime();
$tmpusrcurtime->setTimestamp($DateSend);
$tmpusrcurtime->setTimezone($usertz);
$DateSend=$tmpusrcurtime->format($_SESSION['iDBDateFormat'].", ".$_SESSION['iDBTimeFormat']);
$MessageText=sql_result($result,$is,"MessageText");
$MessageDesc=sql_result($result,$is,"Description");
$ipshow = "two";
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i", array($SenderID));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult);
$rei=0;
$memrequery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."mempermissions\" WHERE \"id\"=%i LIMIT 1", array($SenderID));
$memreresult=sql_query($memrequery,$SQLStat);
$memrenum=sql_num_rows($memreresult);
if($_SESSION['UserID']!=$ReciverID&&
	$_SESSION['UserID']!=$SenderID) {
redirect("location",$rbasedir.url_maker($exfile['index'],$Settings['file_ext'],"act=view",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index'],false));
ob_clean(); header("Content-Type: text/plain; charset=".$Settings['charset']); $urlstatus = 302;
gzip_page($Settings['use_gzip'],$GZipEncode['Type']); session_write_close(); die(); }
while ($rei < $renum) {
$User1ID=$SenderID;
$User1Name=sql_result($reresult,$rei,"Name");
$SenderName = $User1Name;
$User1IP=sql_result($reresult,$rei,"IP");
if($User1IP==$SenderIP) { $ipshow = "one"; }
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
$User1LevelID=sql_result($reresult,$rei,"LevelID");
$lquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."levels\" WHERE \"id\"=%i LIMIT 1", array($User1LevelID));
$lresult=sql_query($lquery,$SQLStat);
$User1Level=sql_result($lresult,0,"Name");
$User1RankID=sql_result($reresult,$rei,"RankID");
$rquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."ranks\" WHERE \"id\"=%i LIMIT 1", array($User1RankID));
$rresult=sql_query($rquery,$SQLStat);
$User1RankID=sql_result($rresult,0,"Name");
sql_free_result($rresult);
$User1GroupID=sql_result($reresult,$rei,"GroupID");
$User1Hidden=sql_result($reresult,$rei,"HiddenMember");
$SenderHidden = $User1Hidden;
$gquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i", array($User1GroupID));
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
sql_free_result($gresult); sql_free_result($lresult);
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
++$rei; } sql_free_result($reresult);
if($_SESSION['UserID']==$ReciverID) {
$queryup = sql_pre_query("UPDATE \"".$Settings['sqltable']."messenger\" SET \"Read\"=%i WHERE \"id\"=%i", array(1,$_GET['id']));
sql_query($queryup,$SQLStat); }
if($User1Name=="Guest") { $User1Name=$PMGuest;
if($User1Name==null) { $User1Name="Guest"; } }
if(isset($GroupNamePrefix)&&$GroupNamePrefix!=null) {
	$User1Name = $GroupNamePrefix.$User1Name; }
if(isset($GroupNameSuffix)&&$GroupNameSuffix!=null) {
	$User1Name = $User1Name.$GroupNameSuffix; }
if($User1CanUseBBTags=="yes") { $MessageText = bbcode_parser($MessageText); }
if($User1CanExecPHP=="no") {
$MessageText = preg_replace("/\[ExecPHP\](.*?)\[\/ExecPHP\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute php code.",$MessageText); }
if($User1CanExecPHP=="yes") { $MessageText = php_execute($MessageText); }
if($User1CanDoHTML=="no") {
$MessageText = preg_replace("/\[DoHTML\](.*?)\[\/DoHTML\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute html.",$MessageText); }
if($User1CanDoHTML=="yes") { $MessageText = do_html_bbcode($MessageText); }
$MessageText = text2icons($MessageText,$Settings['sqltable'],$SQLStat);
$MessageText = preg_replace("/\<br\>/", "<br />", nl2br($MessageText));
$MessageText = url2link($MessageText);
if($User1CanUseBBTags=="yes") { $User1Signature = bbcode_parser($User1Signature); }
if($User1CanExecPHP=="no") {
$User1Signature = preg_replace("/\[ExecPHP\](.*?)\[\/ExecPHP\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute php code.",$User1Signature); }
if($User1CanExecPHP=="yes") { $User1Signature = php_execute($User1Signature); }
if($User1CanDoHTML=="no") {
$User1Signature = preg_replace("/\[DoHTML\](.*?)\[\/DoHTML\]/is","<span style=\"color: red; font-weight: bold;\">ERROR:</span> cannot execute html.",$User1Signature); }
if($User1CanDoHTML=="yes") { $User1Signature = do_html_bbcode($User1Signature); }
$User1Signature = text2icons($User1Signature,$Settings['sqltable'],$SQLStat);
$User1Signature = preg_replace("/\<br\>/", "<br />", nl2br($User1Signature));
$User1Signature = url2link($User1Signature);
?>
<div class="TableInfoMini1Border" id="message<?php echo $PMID; ?>">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableInfoMiniRow1">
<span style="font-weight: bold; text-align: left;"><?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=read&id=".$_GET['id'],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>"><?php echo $MessageName; ?></a> ( <?php echo $MessageDesc; ?> )</span>
</div>
<?php } ?>
<table class="TableInfoMini1" style="width: 100%;" id="pmessage<?php echo $is+1; ?>">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableInfoMiniRow1">
<td class="TableInfoMiniColumn1" colspan="2"><span style="font-weight: bold; text-align: left;"><?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=read&id=".$_GET['id'],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>"><?php echo $MessageName; ?></a> ( <?php echo $MessageDesc; ?> )</span>
</td>
</tr><?php } ?>
<tr class="TableInfoMiniRow2">
<td class="TableInfoMiniColumn2" style="vertical-align: middle; width: 160px;">
&#160;<?php
if($User1ID>0&&$User1Hidden=="no") {
echo "<a href=\"";
echo url_maker($exfile['member'],$Settings['file_ext'],"act=view&id=".$User1ID,$Settings['qstr'],$Settings['qsep'],$prexqstr['member'],$exqstr['member']);
echo "\">".$User1Name."</a>"; }
if($User1ID<=0||$User1Hidden=="yes") {
echo "<span>".$User1Name."</span>"; }
?></td>
<td class="TableInfoMiniColumn2" style="vertical-align: middle;">
<div style="float: left; text-align: left;">
<span style="font-weight: bold;">Time Sent: </span><?php echo $DateSend; ?>
</div>
<div style="text-align: right;">
<?php if(isset($ThemeSet['Report'])&&$ThemeSet['Report']!=null) { ?>
<a href="#Act/Report"><?php echo $ThemeSet['Report']; ?></a>
<?php } if($GroupInfo['CanPM']=="yes"&&isset($ThemeSet['QuoteReply'])&&$ThemeSet['QuoteReply']!=null) {
if($_SESSION['UserID']!=$User1ID) { $SendToID = $User1ID; }
if($_SESSION['UserID']==$User1ID) { $SendToID = $ReciverID; }
echo $ThemeSet['LineDividerTopic']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=create&id=".$SendToID."&post=".$_GET['id'],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>"><?php echo $ThemeSet['QuoteReply']; ?></a>
<?php } ?>&#160;</div>
</td>
</tr>
<tr class="TableInfoMiniRow3">
<td class="TableInfoMiniColumn3" style="vertical-align: top; width: 180px;">
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
Karma Level: <?php echo $User1RankID; ?><br />
Joined: <?php echo $User1Joined; ?><br />
<?php if($GroupInfo['CanViewIPAddress']=="yes") { ?>
User IP: <a onclick="window.open(this.href);return false;" href="<?php echo sprintf($IPCheckURL,$User1IP); ?>">
<?php echo $User1IP; ?></a><br />
<?php if($ipshow=="two") { ?>
Message IP: <a onclick="window.open(this.href);return false;" href="<?php echo sprintf($IPCheckURL,$SenderIP); ?>">
<?php echo $SenderIP; ?></a><br />
<?php } } ?><br />
</td>
<td class="TableInfoMiniColumn3" style="vertical-align: middle;">
<div class="pmpost"><?php echo $MessageText; ?></div>
<?php if(isset($User1Signature)&&$User1Signature!="") { ?> <br />--------------------
<div class="signature"><?php echo $User1Signature; ?></div><?php } ?>
</td>
</tr>
<tr class="TableInfoMiniRow4">
<td class="TableInfoMiniColumn4" colspan="2">
<span style="text-align: left;">&#160;<a href="<?php
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
</td></tr>
</table></div>
<div class="DivReplies">&#160;</div>
<?php ++$is; } ?>
</td></tr>
</table>
<?php sql_free_result($result); }
if($_GET['act']!="read") { ?>
</table></div>
</td></tr>
</table>
<?php } }
if($_GET['act']=="create") { 
$SendMessageTo = null;
if($_GET['id']!=null&&$_GET['id']!=-1) {
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"id\"=%i", array($_GET['id']));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult);
$rei=0;
while ($rei < $renum) {
$SendMessageTo = sql_result($reresult,$rei,"Name");
$SendMessageTo = htmlspecialchars($SendMessageTo, ENT_QUOTES, $Settings['charset']);
$SendToGroupID = sql_result($reresult,$rei,"GroupID");
++$rei; } sql_free_result($reresult); }
if(!isset($renum)) { $renum = 0; }
if($renum==0) { $SendMessageTo = null; }
$QuoteReply = null; $QuoteDescription = null; $QuoteTitle = null;
if($_GET['post']!=null and is_numeric($_GET['post'])) {
if(isset($SendMessageTo)) {
$QuoteUserName = $SendMessageTo; }
if(!isset($SendMessageTo)) {
$QuoteUserName = "Unknown"; }
$query = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."messenger\" WHERE \"id\"=%i AND (\"SenderID\"=%i OR \"ReciverID\"=%i)", array($_GET['post'], $_SESSION['UserID'], $_SESSION['UserID']));
$result=sql_query($query,$SQLStat);
$num=sql_num_rows($result);
if($num>0) {
$QuoteTitle=sql_result($result,0,"MessageTitle");
$MessageText=sql_result($result,0,"MessageText");
$QuoteReply = preg_replace("/\<br\>/", "<br />", nl2br($MessageText));
$QuoteDescription=sql_result($result,0,"Description");
$result=sql_query($query,$SQLStat);
$num=sql_num_rows($result);
$QuoteReply = remove_bad_entities($QuoteReply);
$QuoteDescription = str_replace("Re: ","",$QuoteDescription);
$QuoteDescription = "Re: ".$QuoteDescription;
$QuoteTitle = str_replace("Re: ","",$QuoteTitle);
$QuoteTitle = "Re: ".$QuoteTitle;
$QuoteReply = null; } }
if(!isset($num)) { $num = 0; }
if($num==0) { $_GET['post'] = null; }
$UFID = rand_uuid("rand");
$_SESSION['UserFormID'] = $UFID;
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=create",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">Seanding a Message</a></span></div>
<?php } ?>
<table class="Table1" id="MakeMessage">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1" id="MessageStart">
<td class="TableColumn1" colspan="2"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=create",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">Seanding a Message</a></span>
</td>
</tr><?php } ?>
<tr id="MakeMessageRow" class="TableRow2">
<td class="TableColumn2" colspan="2" style="width: 100%;">Making a Message</td>
</tr>
<tr class="TableRow3" id="MkMessage">
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
<form style="display: inline;" method="post" id="MkReplyForm" action="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=sendmessage",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">
<table style="text-align: left;">
<tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="SendMessageTo">Insert UserName:</label></td>
	<td style="width: 50%;"><input maxlength="25" type="text" name="SendMessageTo" class="TextBox" id="SendMessageTo" size="20" value="<?php echo $SendMessageTo; ?>" /></td>
</tr><tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="MessageName">Insert Message Name:</label></td>
	<td style="width: 50%;"><input maxlength="30" type="text" name="MessageName" class="TextBox" id="MessageName" size="20" value="<?php echo $QuoteTitle; ?>" /></td>
</tr><tr style="text-align: left;">
	<td style="width: 50%;"><label class="TextBoxLabel" for="MessageDesc">Insert Message Description:</label></td>
	<td style="width: 50%;"><input maxlength="45" type="text" name="MessageDesc" class="TextBox" id="MessageDesc" size="20" value="<?php echo $QuoteDescription; ?>" /></td>
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
<label class="TextBoxLabel" for="Message">Insert Your Message:</label><br />
<textarea rows="10" name="Message" id="Message" cols="40" class="TextBox"><?php echo $QuoteReply; ?></textarea><br />
<?php if($_SESSION['UserGroup']==$Settings['GuestGroup']&&$Settings['captcha_guest']=="on") { ?>
<label class="TextBoxLabel" for="signcode"><img src="<?php echo url_maker($exfile['index'],$Settings['file_ext'],"act=MkCaptcha",$Settings['qstr'],$Settings['qsep'],$prexqstr['index'],$exqstr['index']); ?>" alt="CAPTCHA Code" title="CAPTCHA Code" /></label><br />
<input maxlength="25" type="text" class="TextBox" name="signcode" size="20" id="signcode" value="Enter SignCode" /><br />
<?php } ?>
<input type="hidden" name="act" value="sendmessages" style="display: none;" />
<?php if($_SESSION['UserGroup']!=$Settings['GuestGroup']) { ?>
<input type="hidden" name="GuestName" value="null" style="display: none;" />
<?php } ?>
<input type="submit" class="Button" value="Send Message" name="send_message" />
<input type="hidden" style="display: none;" name="fid" value="<?php echo $UFID; ?>" />
<input type="hidden" style="display: none;" name="ubid" value="<?php echo $Settings['BoardUUID']; ?>" />
<?php if($_GET['post']!=null and is_numeric($_GET['post'])) { ?>
<input type="hidden" style="display: none;" name="post" value="<?php echo $_GET['post']; ?>" />
<?php } if($_GET['post']==null or !is_numeric($_GET['post'])) { ?>
<input type="hidden" style="display: none;" name="post" value="0" />
<?php } ?>
<input type="reset" value="Reset Form" class="Button" name="Reset_Form" />
</td></tr></table>
</form></td></tr>
<tr id="MkReplyEnd" class="TableRow4">
<td class="TableColumn4" colspan="2">&#160;</td>
</tr>
</table></div>
<?php } if($_GET['act']=="sendmessage"&&$_POST['act']=="sendmessages") {
$REFERERurl = parse_url($_SERVER['HTTP_REFERER']);
$URL['REFERER'] = $REFERERurl['host'];
$URL['HOST'] = $_SERVER["SERVER_NAME"];
$REFERERurl = null;
if(!isset($_POST['SendMessageTo'])) { $_POST['SendMessageTo'] = null; }
if(!isset($_POST['MessageName'])) { $_POST['MessageName'] = null; }
if(!isset($_POST['MessageDesc'])) { $_POST['MessageDesc'] = null; }
if(!isset($_POST['Message'])) { $_POST['Message'] = null; }
if(!isset($_POST['GuestName'])) { $_POST['GuestName'] = null; }
if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	$Settings['captcha_guest']=="on") {
require($SettDir['inc']."captcha.php"); }
?>
<div class="Table1Border">
<?php if($ThemeSet['TableStyle']=="div") { ?>
<div class="TableRow1">
<span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=sendmessage",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">Making a Message</a></span></div>
<?php } ?>
<table class="Table1">
<?php if($ThemeSet['TableStyle']=="table") { ?>
<tr class="TableRow1">
<td class="TableColumn1"><span style="text-align: left;">
<?php echo $ThemeSet['TitleIcon']; ?><a href="<?php echo url_maker($exfile['messenger'],$Settings['file_ext'],"act=sendmessage",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger']); ?>">Making a Message</a></span>
</td>
</tr><?php } ?>
<tr class="TableRow2">
<th class="TableColumn2" style="width: 100%; text-align: left;">&#160;Make Message: </th>
</tr>
<tr class="TableRow3">
<td class="TableColumn3">
<table style="width: 100%; height: 25%; text-align: center;">
<?php if (pre_strlen($_POST['SendMessageTo'])>="25") { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Send to user name too big.<br />
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
<?php } } if ($_POST['SendMessageTo']==null) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a user name to send message to.<br />
	</span>&#160;</td>
</tr>
<?php } if (pre_strlen($_POST['MessageName'])>="30") { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Message Name is too big.<br />
	</span>&#160;</td>
</tr>
<?php } if (pre_strlen($_POST['MessageDesc'])>="45") { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />Message Description is too big.<br />
	</span>&#160;</td>
</tr>
<?php } if($_SESSION['UserGroup']==$Settings['GuestGroup']&&
	pre_strlen($_POST['GuestName'])>="25") { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />You Guest Name is too big.<br />
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
if(is_numeric($_POST['post'])) { $_POST['post'] = intval($_POST['post'], 10); }
if(!isset($_POST['post']) or !is_numeric($_POST['post']) or $_POST['post']==null) { $_POST['post'] = 0; }
if($_POST['post']>0) {
$querychckm = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."messenger\" WHERE \"id\"=%i AND (\"SenderID\"=%i OR \"ReciverID\"=%i)", array($_POST['post'], $_SESSION['UserID'], $_SESSION['UserID']));
$resultchckm=sql_query($querychckm,$SQLStat);
$numchckm=sql_num_rows($resultchckm);
if($numchckm==0) { $_POST['post'] = 0; }
sql_free_result($resultchckm); }
$_POST['MessageName'] = stripcslashes(htmlspecialchars($_POST['MessageName'], ENT_QUOTES, $Settings['charset']));
//$_POST['MessageName'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['MessageName']);
$_POST['MessageName'] = remove_spaces($_POST['MessageName']);
$_POST['MessageDesc'] = stripcslashes(htmlspecialchars($_POST['MessageDesc'], ENT_QUOTES, $Settings['charset']));
//$_POST['MessageDesc'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['MessageDesc']);
$_POST['MessageDesc'] = remove_spaces($_POST['MessageDesc']);
$_POST['SendMessageTo'] = stripcslashes(htmlspecialchars($_POST['SendMessageTo'], ENT_QUOTES, $Settings['charset']));
//$_POST['SendMessageTo'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['SendMessageTo']);
$_POST['SendMessageTo'] = remove_spaces($_POST['SendMessageTo']);
$_POST['GuestName'] = stripcslashes(htmlspecialchars($_POST['GuestName'], ENT_QUOTES, $Settings['charset']));
//$_POST['GuestName'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['GuestName']);
$_POST['GuestName'] = remove_spaces($_POST['GuestName']);
$_POST['Message'] = stripcslashes(htmlspecialchars($_POST['Message'], ENT_QUOTES, $Settings['charset']));
//$_POST['Message'] = preg_replace("/&amp;#(x[a-f0-9]+|[0-9]+);/i", "&#$1;", $_POST['Message']);
//$_POST['Message'] = remove_spaces($_POST['Message']);
$_POST['Message'] = remove_bad_entities($_POST['Message']);
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
$_POST['Message'] = preg_replace("/\b(".$Filter.")\b/", $Replace, $_POST['Message']);
$_POST['MessageDesc'] = preg_replace("/\b(".$Filter.")\b/", $Replace, $_POST['MessageDesc']); }
if($CaseInsensitive=="yes"&&$WholeWord=="yes") {
$_POST['Message'] = preg_replace("/\b(".$Filter.")\b/i", $Replace, $_POST['Message']);
$_POST['MessageDesc'] = preg_replace("/\b(".$Filter.")\b/i", $Replace, $_POST['MessageDesc']); }
if($CaseInsensitive!="yes"&&$WholeWord!="yes") {
$_POST['Message'] = preg_replace("/".$Filter."/", $Replace, $_POST['Message']);
$_POST['MessageDesc'] = preg_replace("/".$Filter."/", $Replace, $_POST['MessageDesc']); }
if($CaseInsensitive=="yes"&&$WholeWord!="yes") {
$_POST['Message'] = preg_replace("/".$Filter."/i", $Replace, $_POST['Message']);
$_POST['MessageDesc'] = preg_replace("/".$Filter."/i", $Replace, $_POST['MessageDesc']); }
++$melanies; } sql_free_result($melaniert);
$lonewolfqy=sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."restrictedwords\" WHERE \"RestrictedMessageName\"='yes' or \"RestrictedUserName\"='yes'", array(null));
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
$RestrictedMessageName=sql_result($lonewolfrt,$lonewolfs,"RestrictedMessageName");
if($RestrictedMessageName=="on") { $RestrictedMessageName = "yes"; }
if($RestrictedMessageName=="off") { $RestrictedMessageName = "no"; }
if($RestrictedMessageName!="yes"||$RestrictedMessageName!="no") { $RestrictedMessageName = "no"; }
$RestrictedUserName=sql_result($lonewolfrt,$lonewolfs,"RestrictedUserName");
if($RestrictedUserName=="on") { $RestrictedUserName = "yes"; }
if($RestrictedUserName=="off") { $RestrictedUserName = "no"; }
if($RestrictedUserName!="yes"||$RestrictedUserName!="no") { $RestrictedUserName = "no"; }
$RWord = preg_quote($RWord, "/");
if($RCaseInsensitive!="yes"&&$RWholeWord=="yes") {
if($RestrictedMessageName=="yes") {
$RMatches = preg_match("/\b(".$RWord.")\b/", $_POST['MessageName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/\b(".$RWord.")\b/", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
if($RCaseInsensitive=="yes"&&$RWholeWord=="yes") {
if($RestrictedMessageName=="yes") {
$RMatches = preg_match("/\b(".$RWord.")\b/i", $_POST['MessageName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/\b(".$RWord.")\b/i", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
if($RCaseInsensitive!="yes"&&$RWholeWord!="yes") {
if($RestrictedMessageName=="yes") {
$RMatches = preg_match("/".$RWord."/", $_POST['MessageName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/".$RWord."/", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
if($RCaseInsensitive=="yes"&&$RWholeWord!="yes") {
if($RestrictedMessageName=="yes") {
$RMatches = preg_match("/".$RWord."/i", $_POST['MessageName']);
	if($RMatches==true) { break 1; } }
if($RestrictedUserName=="yes") {
$RGMatches = preg_match("/".$RWord."/i", $_POST['GuestName']);
	if($RGMatches==true) { break 1; } } }
++$lonewolfs; } sql_free_result($lonewolfrt);
$requery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."members\" WHERE \"Name\"='%s'", array($_POST['SendMessageTo']));
$reresult=sql_query($requery,$SQLStat);
$renum=sql_num_rows($reresult);
$rei=0;
while ($rei < $renum) {
$SendMessageToID = sql_result($reresult,$rei,"id");
$SendToGroupID = sql_result($reresult,$rei,"GroupID");
$gquery = sql_pre_query("SELECT * FROM \"".$Settings['sqltable']."groups\" WHERE \"id\"=%i", array($SendToGroupID));
$gresult=sql_query($gquery,$SQLStat);
$SendUserCanPM=sql_result($gresult,0,"CanPM");
$SendUserCanPM = strtolower($SendUserCanPM);
if($SendUserCanPM!="yes"&&$SendUserCanPM!="no") {
	$SendUserCanPM = "no"; }
sql_free_result($gresult);
++$rei; } sql_free_result($reresult);
if($renum==0) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />Cound not find users name.<br />
	</span>&#160;</td>
</tr>
<?php } if ($_POST['MessageName']==null) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Message Name.<br />
	</span>&#160;</td>
</tr>
<?php } if ($_POST['MessageDesc']==null) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Message Description.<br />
	</span>&#160;</td>
</tr>
<?php } if ($SendUserCanPM=="no") { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />User Name enter can not get messages.<br />
	</span>&#160;</td>
</tr>
<?php } if ($_POST['Message']==null) { $Error="Yes";  ?>
<tr>
	<td><span class="TableMessage">
	<br />You need to enter a Message.<br />
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
<?php } if($RMatches==true) { $Error="Yes"; ?>
<tr>
	<td><span class="TableMessage">
	<br />This Message Name is restricted to use.<br />
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
if($_SESSION['UserGroup']==$Settings['GuestGroup']) { $User1Name = $_POST['GuestName']; }
if($_SESSION['UserGroup']!=$Settings['GuestGroup']) { $User1Name = $_SESSION['MemberName']; }
$User1IP=$_SERVER['REMOTE_ADDR'];
$query = sql_pre_query("INSERT INTO \"".$Settings['sqltable']."messenger\" (\"DiscussionID\", \"SenderID\", \"ReciverID\", \"GuestName\", \"MessageTitle\", \"MessageText\", \"Description\", \"DateSend\", \"Read\", \"IP\") VALUES 
(%i, %i, %i, '%s', '%s', '%s', '%s', %i, %i, '%s')", array($_POST['post'],$_SESSION['UserID'],$SendMessageToID,$_SESSION['MemberName'],$_POST['MessageName'],$_POST['Message'],$_POST['MessageDesc'],$LastActive,0,$User1IP));
sql_query($query,$SQLStat);
$messageid = sql_get_next_id($Settings['sqltable'],"messenger",$SQLStat);
$msglinkback = "Click <a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=view&page=1",$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">here</a> to go back to mailbox.";
if($_POST['post']>0) { $msglinkback = "Click <a href=\"".url_maker($exfile['messenger'],$Settings['file_ext'],"act=read&id=".$_POST['post'],$Settings['qstr'],$Settings['qsep'],$prexqstr['messenger'],$exqstr['messenger'])."\">here</a> to go back to message."; }
?><tr>
	<td><span class="TableMessage"><br />
	Message sent to user <?php echo $_POST['SendMessageTo']; ?>.<br />
	<?php echo $msglinkback; ?><br />&#160;
	</span><br /></td>
</tr>
<?php } ?>
</table>
</td></tr>
<tr class="TableRow4">
<td class="TableColumn4">&#160;</td>
</tr>
</table></div>
<?php } ?>
<div class="DivMessages">&#160;</div>
