<?php

/**************************************************************************/

/* PHP-NUKE: Internet Radio&TV Block/Module  */
/* =====================================  */
/*   */
/* Copyright (c) 2005 by Ren?Hart (webmaster@just4me.nl) */
/* http://www.just4me.nl  */
/*   */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License. */
/*   */
/* Internet tv Block/Module V3.0 by Rene Hart (webmaster@just4me.nl) */
/* http://www.just4me.nl  */
/* For PHP-Nuke  */
/*   */
/*   */
/**************************************************************************/
//******************************************//
// DO NOT CHANGE ANYTHING ON THIS SCRIPT !! //
// LEAVE COPYRIGHT IN PLACE //
//******************************************//
/**
 * This version ported to E-Xoops and extensively modified
 * by Bob Janes <bob@bobjanes.com>
 * 18 October 2005
 */
/***************************************************/
/*   */
/* Ported to XOOPS By wanisys.net <wani@wanisys.net> */
/* 7 June 2004   */
/* Internet for everybody!  */
/* Enjoy!!!!!!   */
/*   */
/****************************************************/
include 'admin_header.php';
xoops_cp_header();
global $xoopsTheme, $xoopsModule;
if ('1' != ini_get('register_globals')) {
    if (!empty($_GET)) {
        extract($_GET);
    } elseif (!empty($_GET)) {
        extract($_GET);
    }

    if (!empty($_POST)) {
        extract($_POST);
    } elseif (!empty($_POST)) {
        extract($_POST);
    }
}
function ITVdisplay()
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $xoopsConfig, $xoopsUser, $xoopsTheme, $_GET, $_POST;

    global $language, $admin, $tvid;

    $tv_page = $_GET['tv_page'];

    $tv_keyword = $_GET['tv_keyword'];

    OpenTable();

    $count = 0;

    $idnum = 1;

    if (mb_strlen($tv_keyword) > 0) {
        $result = $xoopsDB->query('SELECT tv_id, tv_name, tv_language FROM ' . $xoopsDB->prefix('internet_tv') . " WHERE tv_name LIKE '%$tv_keyword%' ORDER BY tv_id DESC");
    } else {
        $result = $xoopsDB->query('SELECT tv_id, tv_name, tv_language FROM ' . $xoopsDB->prefix('internet_tv') . ' ORDER BY tv_id DESC');
    }

    $tv_rows = 10;

    $tv_count = $xoopsDB->getRowsNum($result);

    if (empty($tv_page)) {
        $tv_page = 1;
    }

    $tv_start = ($tv_page - 1) * $tv_rows;

    if ($tv_start > 1) {
        mysql_data_seek($result, $tv_start);
    }

    if ($tv_count > 0) {
        $tv_total = ceil(($tv_count) / $tv_rows);
    } else {
        $tv_total = 1;
    }

    echo "<div class='bg3' style='font-weight:bold; 
padding:6px;'>Internet TV : " . _ADMINMENU . '</div>';

    echo "
<table><tr>
<td colspan='4' class='bg2'>
<b>" . _MA_ITV_PROG . "</b>[Total Stations : $tv_count Station Page : $tv_page Page of $tv_total Page(s)]
</td>
</tr>";

    $tv_line = 0;

    while (list($tv_id, $tv_name, $tv_language) = $xoopsDB->fetchRow($result)) {
        if ('' == $tv_language) {
            $tv_language = _ALL;
        } //EndIf

        if ('' != $tv_id) {
            if (0 == $count) {
                $count = 1;
            } // EndIf

            $tv_no = $tv_count - $tv_start - $tv_line;

            echo "<tr style='border:1px';><td align='center'><b>$tv_no</b></td>
<td style='width:200px;'>$tv_name</td>
<td align='center'>&nbsp;$tv_language&nbsp;</td>
<td nowrap>
<a href='" . _PHP_SELF2 . "?op=ITVedit&amp;tvid=$tv_id&amp;tv_page=$tv_page&amp;tv_keyword=$tv_keyword'>" . _EDIT . "</a>&nbsp;|&nbsp;
<a href='" . _PHP_SELF2 . "?op=ITVdelete&amp;tvid=$tv_id&amp;tv_page=$tv_page&amp;tv_keyword=$tv_keyword'>" . _DELETE . '</a></td></tr>';
        } // EndIf

        if (++$tv_line == $tv_rows) {
            break;
        }
    } // EndWhile

    if (('' == $tv_id) and (0 == $count)) {
        echo '<i>' . _MA_ITV_NOST . '</i>';
    } // EndIf

    if (1 == $count) {
        echo '</table><br>';
    } // EndIf

    echo " <Script language = \"JavaScript\">
<!--
function tv_page(tv_page) {
document.page_form.tv_page.value=tv_page;
document.page_form.submit();
}
-->
</script>
<form name=\"page_form\" action=\"admin_tv.php\" method=\"get\" >
<input type=\"hidden\" name=\"tv_page\" >
<input type=\"hidden\" name=\"tv_keyword\" value=\"$tv_keyword\" >
</form>
<table align=center border=0>
<tr><td align=right> 
<form name=\"tv_searchform\" action=\"admin_tv.php\" method=\"get\" >
<input type=\"text\" name=\"tv_keyword\" size=\"15\" value=\"$tv_keyword\" >
<input type=\"button\" value=\"Search\" onClick=\"document.tv_searchform.submit()\" >
</form>
</td></tr>
<tr><td align=center>
";

    for ($i = 1; $i <= $tv_total; $i++) {
        echo '<a href="JavaScript:tv_page(' . ($i) . ")\">[$i]</a>&nbsp;";
    }

    echo '</td></tr></table>';

    echo '<br><br>';

    echo "<a href='" . _PHP_SELF2 . "?op=ITVnew'><b>" . _MA_ITV_NEW . '</b></a><hr>';

    include '../cache/config_tv.php';

    echo "<table>
<tr><td colspan='2' class='bg2'><b>" . _MA_ITV_BLSET . "</b></td></tr>
<form action='" . _PHP_SELF2 . "' method='post'>
<tr><td>" . _MA_ITV_AUTOST . ':</td><td>';

    if (1 == $itvConfig['xautostart']) {
        echo "<input type='radio' name='xautostart' value='1' checked>" . _YES . " &nbsp;
<input type='radio' name='xautostart' value='0'>" . _NO . '';
    } else {
        echo "<input type='radio' name='xautostart' value='1'>" . _YES . " &nbsp;
<input type='radio' name='xautostart' value='0' checked>" . _NO . '';
    } // EndIf

    echo '</td></tr><tr><td>' . _MA_ITV_PICCHO . ':</td><td>';

    if (1 == $itvConfig['xpicture']) {
        echo "<input type='radio' name='xpicture' value='1' checked>" . _YES . " &nbsp;
<input type='radio' name='xpicture' value='0'>" . _NO . '';
    } else {
        echo "<input type='radio' name='xpicture' value='1'>" . _YES . " &nbsp;
<input type='radio' name='xpicture' value='0' checked>" . _NO . '';
    } // EndIf

    echo '</td></tr>
<tr><td>' . _MA_ITV_PICDEF . ':</td><td>';

    if (1 == $itvConfig['xdefpicture']) {
        echo "<input type='radio' name='xdefpicture' value='1' checked>" . _YES . " &nbsp;
<input type='radio' name='xdefpicture' value='0'>" . _NO . '';
    } else {
        echo "<input type='radio' name='xdefpicture' value='1'>" . _YES . " &nbsp;
<input type='radio' name='xdefpicture' value='0' checked>" . _NO . '';
    } // EndIf

    echo '</td></tr>
<tr><td>' . _MA_ITV_NOPICNAME . ":</td>
<td>
<input type='text' name='xnopicturename' size='50 
maxlength='50' value='" . $itvConfig['xnopicturename'] . "'>";

    echo '</td></tr>
<tr><td>' . _MA_ITV_TVVERT . ":</td>
<td>
<input type='text' name='xtvvert' size='5' 
maxlength='5' value='" . $itvConfig['xtvvert'] . "'>";

    echo '</td></tr>
<tr><td>' . _MA_ITV_TVHOR . ":</td>
<td>
<input type='text' name='xtvhor' size='5' 
maxlength='5' value='" . $itvConfig['xtvhor'] . "'>";

    echo "</td></tr>
<tr><td>
<input type='hidden' name='op' value='ITVsettings'>
<input type='submit' value='" . _SAVE . "'>
</tr></td></table></form>";

    CloseTable();
}

function ITVdelete($id, $del, $tv_page, $tv_keyword)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $tvid;

    if (1 == $del) {
        $sql = sprintf('DELETE FROM ' . $xoopsDB->prefix('internet_tv') . " WHERE tv_id = $id");

        if ($xoopsDB->query($sql)) {
            redirect_header("admin_tv.php?tv_page=$tv_page&amp;tv_keyword=$tv_keyword", 1, _MD_UPDATED);
        } else {
            redirect_header("admin_tv.php?tv_page=$tv_page&amp;tv_keyword=$tv_keyword", 1, _MD_NOTUPDATED);
        }

        exit();
    }

    xoops_confirm(['op' => 'ITVdelete', 'id' => $tvid, 'del' => 1, 'tv_page' => $tv_page, 'tv_keyword' => $tv_keyword], 'admin_tv.php', _MD_SUREDELETE);
}

function ITVedit()
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $tvid;

    global $tv_page, $tv_keyword;

    echo "<script language='JavaScript' type='text/javascript'> 
function checkform (form) {
if (form.tvname.value == '') {
alert('" . _MA_ITV_ERR1 . "' );
form.tvname.focus();
return false ;
}
if (form.tvstream.value == 'http://' 
|| form.tvstream.value == '') {
alert( '" . _MA_ITV_ERR2 . "' );
form.tvstream.focus();
return false ;
}
return true ;
}
</script>";

    echo "<div class='bg3' style='font-weight:bold; padding:6px;'>Internet tv : " . _ADMINMENU . '</div>';

    $result = $xoopsDB->query('SELECT tv_name, tv_stream, tv_url, tv_picture, tv_language FROM ' . $xoopsDB->prefix('internet_tv') . " WHERE tv_id = $tvid");

    [$tv_name, $tv_stream, $tv_url, $tv_picture, $tv_language] = $xoopsDB->fetchRow($result);

    OpenTable();

    echo '<b>' . _MA_ITV_EDIT . '</b>';

    echo '<form action=' . _PHP_SELF2 . " method='post' onsubmit='return checkform(this);'>
<table>
<tr><td>" . _MA_ITV_NAME . ":</td>
<td><input type='text' name='tvname' size='20' 
maxlength='20' value='$tv_name'></td></tr>
<tr><td>" . _MA_ITV_URL . ":</td>
<td><input type='text' name='tvurl' size='50' 
maxlength='50' value='$tv_url'></td></tr>
<tr><td>" . _MA_ITV_STREAM . ":</td>
<td><input type='text' name='tvstream' size='50' 
maxlength='75' value='$tv_stream'></td></tr>
<tr><td>" . _MA_ITV_PICT . ":</td>
<td><input type='text' name='tvpicture' size='50' 
maxlength='50' value='$tv_picture'>&nbsp;(" . _MA_ITV_PICTDITV . ')</td></tr>
<tr><td>' . _MA_ITV_LANGUAGE . ":</td>
<td><input type='text' name='tvlanguage' size='20' 
maxlength='20' value='$tv_language'></td></tr>
<tr><td>";

    echo '</td></tr><tr><td>'
         . "<input type='hidden' name='tvid' size='50' value='$tvid'>"
         . "<input type='hidden' name='tv_page' value='$tv_page'>"
         . "<input type='hidden' name='tv_keyword' value='$tv_keyword'>"
         . "<input type='hidden' name='op' value='ITVchange'>"
         . "<input type='submit' value='"
         . _SAVE
         . "'>"
         . '</tr></td></table></form>';

    CloseTable();
}

function ITVchange($tvid, $tvname, $tvstream, $tvurl, $tvpicture, $tvlanguage, $tv_page, $tv_keyword)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('internet_tv') . " SET tv_name='$tvname', tv_stream='$tvstream', tv_url='$tvurl', tv_picture='$tvpicture', tv_language='$tvlanguage' WHERE tv_id=$tvid");

    redirect_header("admin_tv.php?tv_page=$tv_page&amp;tv_keyword=$tv_keyword", 2, _MD_UPDATED);
}

function ITVnew()
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $tvid;

    echo "
<script language='JavaScript' type='text/javascript'> 
function checkform (form) {
if (form.tvname.value == '') {
alert('" . _MA_ITV_ERR1 . "' );
form.tvname.focus();
return false ;
} 
if (form.tvstream.value == 'http://' || form.tvstream.value == '') {
alert( '" . _MA_ITV_ERR2 . "' );
form.tvstream.focus();
return false ;
}
return true ;
}
</script>";

    echo "<div class='bg3' style='font-weight:bold; 
padding:6px;'>" . _MA_ITV_TITLE . ' : ' . _ADMINMENU . '</div>';

    OpenTable();

    echo '<b>' . _MA_ITV_NEW . "</b>
<form action='" . _PHP_SELF2 . "' method='post' onSubmit='return checkform(this);'>
<table border='0'>
<tr><td>" . _MA_ITV_NAME . ":</td>
<td><input type='text' name='tvname' size='20' 
maxlength='20'></td></tr>
<tr><td>" . _MA_ITV_URL . ":</td>
<td><input type='text' name='tvurl' size='50' 
maxlength='50' value='http://'></td></tr>
<tr><td>" . _MA_ITV_STREAM . ":</td>
<td><input type='text' name='tvstream' size='50' 
maxlength='75' value='http://'></td></tr>
<tr><td>" . _MA_ITV_PICT . ":</td>
<td><input type='text' name='tvpicture' size='50' 
maxlength='50' >&nbsp;(" . _MA_ITV_PICTDITV . ')</td></tr>
<tr><td>' . _MA_ITV_LANGUAGE . ":</td>
<td><input type='text' name='tvlanguage' size='20' 
maxlength='20' value='$tv_language'></td></tr>
<tr><td></td></tr>
<tr><td>
<input type='hidden' name='op' value='ITVadd'>
<input type='submit' value='" . _SAVE . "'>
</tr></td></table></form><a href='http://www.radio-locator.com' target='_blank'>Open MIT radio Locator</a>";

    CloseTable();
}

function ITVadd($tvname, $tvstream, $tvurl, $tvpicture, $tvlanguage)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    $xoopsDB->query('INSERT INTO ' . $xoopsDB->prefix('internet_tv') . " VALUES ('','$tvname', '$tvstream', '$tvurl', '$tvpicture', '$tvlanguage')");

    redirect_header(_PHP_SELF2, 2, _MD_UPDATED);
}

function ITVsettings()
{
    $config = "<?php \n";

    $config .= "\$itvConfig['xautostart'] = " . $_POST['xautostart'] . "; \n";

    $config .= "\$itvConfig['xpicture'] = " . $_POST['xpicture'] . "; \n";

    $config .= "\$itvConfig['xdefpicture'] = " . $_POST['xdefpicture'] . "; \n";

    $config .= "\$itvConfig['xnopicturename'] = \"" . $_POST['xnopicturename'] . "\"; \n";

    $config .= "\$itvConfig['xtvvert'] = \"" . $_POST['xtvvert'] . "\"; \n";

    $config .= "\$itvConfig['xtvhor'] = \"" . $_POST['xtvhor'] . "\"; \n";

    $config .= '?>';

    $filename = XOOPS_ROOT_PATH . '/modules/iradio/cache/config_tv.php';

    if ($file = fopen($filename, 'wb')) {
        fwrite($file, $config);

        fclose($file);

        // reload admin_tv.php with a ‘write successful?message

        redirect_header('admin_tv.php', 1, _MD_UPDATED);

        exit();
    }

    redirect_header('admin_tv.php', 1, _MD_NOTUPDATED);

    exit();

    // EndIf
}

switch ($op) {
    case 'ITVdisplay':
        ITVdisplay();
        break;
    case 'ITVdelete':
        ITVdelete($id, $del, $tv_page, $tv_keyword);
        break;
    case 'ITVedit':
        ITVedit();
        break;
    case 'ITVchange':
        ITVchange($tvid, $tvname, $tvstream, $tvurl, $tvpicture, $tvlanguage, $tv_page, $tv_keyword);
        break;
    case 'ITVnew':
        ITVnew();
        break;
    case 'ITVadd':
        ITVadd($tvname, $tvstream, $tvurl, $tvpicture, $tvlanguage);
        break;
    case 'ITVsettings':
        ITVsettings($xautostart, $xpicture, $xpicturedir, $xdefpicture, $xnopicturename, $xtvvert, $xtvhor);
        break;
    default:
        ITVdisplay();
        break;
}
xoops_cp_footer();
