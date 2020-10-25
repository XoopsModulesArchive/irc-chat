<?php

/**************************************************************************/

/* PHP-NUKE: Internet Radio Block/Module  */
/* =====================================  */
/*   */
/* Copyright (c) 2005 by Ren?Hart (webmaster@just4me.nl) */
/* http://www.just4me.nl  */
/*   */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License. */
/*   */
/* Internet Radio Block/Module V3.0 by Rene Hart (webmaster@just4me.nl) */
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
function IRdisplay()
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $xoopsConfig, $xoopsUser, $xoopsTheme, $_GET, $_POST;

    global $language, $admin, $radioid;

    $radio_page = $_GET['radio_page'];

    $radio_keyword = $_GET['radio_keyword'];

    OpenTable();

    $count = 0;

    $idnum = 1;

    if (mb_strlen($radio_keyword) > 0) {
        $result = $xoopsDB->query('SELECT radio_id, radio_name, radio_language FROM ' . $xoopsDB->prefix('iradio') . " WHERE radio_name LIKE '%$radio_keyword%' ORDER BY radio_id DESC");
    } else {
        $result = $xoopsDB->query('SELECT radio_id, radio_name, radio_language FROM ' . $xoopsDB->prefix('iradio') . ' ORDER BY radio_id DESC');
    }

    $radio_rows = 10;

    $radio_count = $xoopsDB->getRowsNum($result);

    if (empty($radio_page)) {
        $radio_page = 1;
    }

    $radio_start = ($radio_page - 1) * $radio_rows;

    if ($radio_start > 1) {
        mysql_data_seek($result, $radio_start);
    }

    if ($radio_count > 0) {
        $radio_total = ceil(($radio_count) / $radio_rows);
    } else {
        $radio_total = 1;
    }

    echo "<div class='bg3' style='font-weight:bold; 
padding:6px;'>Internet Radio : " . _ADMINMENU . '</div>';

    echo "
<table><tr>
<td colspan='4' class='bg2'>
<b>" . _MA_IRAD_PROG . "</b>[Total Stations : $radio_count Station Page : $radio_page Page of $radio_total Page(s)]
</td>
</tr>";

    $radio_line = 0;

    while (list($radio_id, $radio_name, $radio_language) = $xoopsDB->fetchRow($result)) {
        if ('' == $radio_language) {
            $radio_language = _ALL;
        } //EndIf

        if ('' != $radio_id) {
            if (0 == $count) {
                $count = 1;
            } // EndIf

            $radio_no = $radio_count - $radio_start - $radio_line;

            echo "<tr style='border:1px';><td align='center'><b>$radio_no</b></td>
<td style='width:200px;'>$radio_name</td>
<td align='center'>&nbsp;$radio_language&nbsp;</td>
<td nowrap>
<a href='" . _PHP_SELF . "?op=IRedit&amp;radioid=$radio_id&amp;radio_page=$radio_page&amp;radio_keyword=$radio_keyword'>" . _EDIT . "</a>&nbsp;|&nbsp;
<a href='" . _PHP_SELF . "?op=IRdelete&amp;radioid=$radio_id&amp;radio_page=$radio_page&amp;radio_keyword=$radio_keyword'>" . _DELETE . '</a></td></tr>';
        } // EndIf

        if (++$radio_line == $radio_rows) {
            break;
        }
    } // EndWhile

    if (('' == $radio_id) and (0 == $count)) {
        echo '<i>' . _MA_IRAD_NOST . '</i>';
    } // EndIf

    if (1 == $count) {
        echo '</table><br>';
    } // EndIf

    echo " <Script language = \"JavaScript\">
<!--
function radio_page(radio_page) {
document.page_form.radio_page.value=radio_page;
document.page_form.submit();
}
-->
</script>
<form name=\"page_form\" action=\"admin_radio.php\" method=\"get\" >
<input type=\"hidden\" name=\"radio_page\" >
<input type=\"hidden\" name=\"radio_keyword\" value=\"$radio_keyword\" >
</form>
<table align=center border=0>
<tr><td align=right> 
<form name=\"radio_searchform\" action=\"admin_radio.php\" method=\"get\" >
<input type=\"text\" name=\"radio_keyword\" size=\"15\" value=\"$radio_keyword\" >
<input type=\"button\" value=\"Search\" onClick=\"document.radio_searchform.submit()\" >
</form>
</td></tr>
<tr><td align=center>
";

    for ($i = 1; $i <= $radio_total; $i++) {
        echo '<a href="JavaScript:radio_page(' . ($i) . ")\">[$i]</a>&nbsp;";
    }

    echo '</td></tr></table>';

    echo '<br><br>';

    echo "<a href='" . _PHP_SELF . "?op=IRnew'><b>" . _MA_IRAD_NEW . '</b></a><hr>';

    include '../cache/config_radio.php';

    echo "<table>
<tr><td colspan='2' class='bg2'><b>" . _MA_IRAD_BLSET . "</b></td></tr>
<form action='" . _PHP_SELF . "' method='post'>
<tr><td>" . _MA_IRAD_AUTOST . ':</td><td>';

    if (1 == $iRadioConfig['xautostart']) {
        echo "<input type='radio' name='xautostart' value='1' checked>" . _YES . " &nbsp;
<input type='radio' name='xautostart' value='0'>" . _NO . '';
    } else {
        echo "<input type='radio' name='xautostart' value='1'>" . _YES . " &nbsp;
<input type='radio' name='xautostart' value='0' checked>" . _NO . '';
    } // EndIf

    echo '</td></tr><tr><td>' . _MA_IRAD_PICCHO . ':</td><td>';

    if (1 == $iRadioConfig['xpicture']) {
        echo "<input type='radio' name='xpicture' value='1' checked>" . _YES . " &nbsp;
<input type='radio' name='xpicture' value='0'>" . _NO . '';
    } else {
        echo "<input type='radio' name='xpicture' value='1'>" . _YES . " &nbsp;
<input type='radio' name='xpicture' value='0' checked>" . _NO . '';
    } // EndIf

    echo '</td></tr>
<tr><td>' . _MA_IRAD_PICDEF . ':</td><td>';

    if (1 == $iRadioConfig['xdefpicture']) {
        echo "<input type='radio' name='xdefpicture' value='1' checked>" . _YES . " &nbsp;
<input type='radio' name='xdefpicture' value='0'>" . _NO . '';
    } else {
        echo "<input type='radio' name='xdefpicture' value='1'>" . _YES . " &nbsp;
<input type='radio' name='xdefpicture' value='0' checked>" . _NO . '';
    } // EndIf

    echo '</td></tr>
<tr><td>' . _MA_IRAD_NOPICNAME . ":</td>
<td>
<input type='text' name='xnopicturename' size='50 
maxlength='50' value='" . $iRadioConfig['xnopicturename'] . "'>
</td></tr>
<tr><td>
<input type='hidden' name='op' value='IRsettings'>
<input type='submit' value='" . _SAVE . "'>
</tr></td></table></form>";

    CloseTable();
}

function IRdelete($id, $del, $radio_page, $radio_keyword)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $radioid;

    if (1 == $del) {
        $sql = sprintf('DELETE FROM ' . $xoopsDB->prefix('iradio') . " WHERE radio_id = $id");

        if ($xoopsDB->query($sql)) {
            redirect_header("admin_radio.php?radio_page=$radio_page&amp;radio_keyword=$radio_keyword", 1, _MD_UPDATED);
        } else {
            redirect_header("admin_radio.php?radio_page=$radio_page&amp;radio_keyword=$radio_keyword", 1, _MD_NOTUPDATED);
        }

        exit();
    }

    xoops_confirm(['op' => 'IRdelete', 'id' => $radioid, 'del' => 1, 'radio_page' => $radio_page, 'radio_keyword' => $radio_keyword], 'admin_radio.php', _MD_SUREDELETE);
}

function IRedit()
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $radioid;

    global $radio_page, $radio_keyword;

    echo "<script language='JavaScript' type='text/javascript'> 
function checkform (form) {
if (form.radioname.value == '') {
alert('" . _MA_IRAD_ERR1 . "' );
form.radioname.focus();
return false ;
}
if (form.radiostream.value == 'http://' 
|| form.radiostream.value == '') {
alert( '" . _MA_IRAD_ERR2 . "' );
form.radiostream.focus();
return false ;
}
return true ;
}
</script>";

    echo "<div class='bg3' style='font-weight:bold; padding:6px;'>Internet Radio : " . _ADMINMENU . '</div>';

    $result = $xoopsDB->query('SELECT radio_name, radio_stream, radio_url, radio_picture, radio_language FROM ' . $xoopsDB->prefix('iradio') . " WHERE radio_id = $radioid");

    [$radio_name, $radio_stream, $radio_url, $radio_picture, $radio_language] = $xoopsDB->fetchRow($result);

    OpenTable();

    echo '<b>' . _MA_IRAD_EDIT . '</b>';

    echo '<form action=' . _PHP_SELF . " method='post' onsubmit='return checkform(this);'>
<table>
<tr><td>" . _MA_IRAD_NAME . ":</td>
<td><input type='text' name='radioname' size='20' 
maxlength='20' value='$radio_name'></td></tr>
<tr><td>" . _MA_IRAD_URL . ":</td>
<td><input type='text' name='radiourl' size='50' 
maxlength='50' value='$radio_url'></td></tr>
<tr><td>" . _MA_IRAD_STREAM . ":</td>
<td><input type='text' name='radiostream' size='50' 
maxlength='75' value='$radio_stream'></td></tr>
<tr><td>" . _MA_IRAD_PICT . ":</td>
<td><input type='text' name='radiopicture' size='50' 
maxlength='50' value='$radio_picture'>&nbsp;(" . _MA_IRAD_PICTDIR . ')</td></tr>
<tr><td>' . _MA_IRAD_LANGUAGE . ":</td>
<td><input type='text' name='radiolanguage' size='20' 
maxlength='20' value='$radio_language'></td></tr>
<tr><td>";

    echo '</td></tr><tr><td>'
         . "<input type='hidden' name='radioid' size='50' value='$radioid'>"
         . "<input type='hidden' name='radio_page' value='$radio_page'>"
         . "<input type='hidden' name='radio_keyword' value='$radio_keyword'>"
         . "<input type='hidden' name='op' value='IRchange'>"
         . "<input type='submit' value='"
         . _SAVE
         . "'>"
         . '</tr></td></table></form>';

    CloseTable();
}

function IRchange($radioid, $radioname, $radiostream, $radiourl, $radiopicture, $radiolanguage, $radio_page, $radio_keyword)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('iradio') . " SET radio_name='$radioname', radio_stream='$radiostream', radio_url='$radiourl', radio_picture='$radiopicture', radio_language='$radiolanguage' WHERE radio_id=$radioid");

    redirect_header("admin_radio.php?radio_page=$radio_page&amp;radio_keyword=$radio_keyword", 2, _MD_UPDATED);
}

function IRnew()
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    global $radioid;

    echo "
<script language='JavaScript' type='text/javascript'> 
function checkform (form) {
if (form.radioname.value == '') {
alert('" . _MA_IRAD_ERR1 . "' );
form.radioname.focus();
return false ;
} 
if (form.radiostream.value == 'http://' || form.radiostream.value == '') {
alert( '" . _MA_IRAD_ERR2 . "' );
form.radiostream.focus();
return false ;
}
return true ;
}
</script>";

    echo "<div class='bg3' style='font-weight:bold; 
padding:6px;'>" . _MA_IRAD_TITLE . ' : ' . _ADMINMENU . '</div>';

    OpenTable();

    echo '<b>' . _MA_IRAD_NEW . "</b>
<form action='" . _PHP_SELF . "' method='post' onSubmit='return checkform(this);'>
<table border='0'>
<tr><td>" . _MA_IRAD_NAME . ":</td>
<td><input type='text' name='radioname' size='20' 
maxlength='20'></td></tr>
<tr><td>" . _MA_IRAD_URL . ":</td>
<td><input type='text' name='radiourl' size='50' 
maxlength='50' value='http://'></td></tr>
<tr><td>" . _MA_IRAD_STREAM . ":</td>
<td><input type='text' name='radiostream' size='50' 
maxlength='75' value='http://'></td></tr>
<tr><td>" . _MA_IRAD_PICT . ":</td>
<td><input type='text' name='radiopicture' size='50' 
maxlength='50' >&nbsp;(" . _MA_IRAD_PICTDIR . ')</td></tr>
<tr><td>' . _MA_IRAD_LANGUAGE . ":</td>
<td><input type='text' name='radiolanguage' size='20' 
maxlength='20' value='$radio_language'></td></tr>
<tr><td></td></tr>
<tr><td>
<input type='hidden' name='op' value='IRadd'>
<input type='submit' value='" . _SAVE . "'>
</tr></td></table></form><a href='http://www.radio-locator.com' target='_blank'>Open MIT Radio Locator</a>";

    CloseTable();
}

function IRadd($radioname, $radiostream, $radiourl, $radiopicture, $radiolanguage)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    $xoopsDB->query('INSERT INTO ' . $xoopsDB->prefix('iradio') . " VALUES ('','$radioname', '$radiostream', '$radiourl', '$radiopicture', '$radiolanguage')");

    redirect_header(_PHP_SELF, 2, _MD_UPDATED);
}

function IRsettings()
{
    $config = "<?php \n";

    $config .= "\$iRadioConfig['xautostart'] = " . $_POST['xautostart'] . "; \n";

    $config .= "\$iRadioConfig['xpicture'] = " . $_POST['xpicture'] . "; \n";

    $config .= "\$iRadioConfig['xdefpicture'] = " . $_POST['xdefpicture'] . "; \n";

    $config .= "\$iRadioConfig['xnopicturename'] = \"" . $_POST['xnopicturename'] . "\"; \n";

    $config .= '?>';

    $filename = XOOPS_ROOT_PATH . '/modules/iradio/cache/config_radio.php';

    if ($file = fopen($filename, 'wb')) {
        fwrite($file, $config);

        fclose($file);

        // reload admin_radio.php with a ‘write successful?message

        redirect_header('admin_radio.php', 1, _MD_UPDATED);

        exit();
    }

    redirect_header('admin_radio.php', 1, _MD_NOTUPDATED);

    exit();

    // EndIf
}

switch ($op) {
    case 'IRdisplay':
        IRdisplay();
        break;
    case 'IRdelete':
        IRdelete($id, $del, $radio_page, $radio_keyword);
        break;
    case 'IRedit':
        IRedit();
        break;
    case 'IRchange':
        IRchange($radioid, $radioname, $radiostream, $radiourl, $radiopicture, $radiolanguage, $radio_page, $radio_keyword);
        break;
    case 'IRnew':
        IRnew();
        break;
    case 'IRadd':
        IRadd($radioname, $radiostream, $radiourl, $radiopicture, $radiolanguage);
        break;
    case 'IRsettings':
        IRsettings($xmodulename, $xautostart, $xpicture, $xpicturedir, $xdefpicture, $xnopicturename);
        break;
    default:
        IRdisplay();
        break;
}
xoops_cp_footer();
