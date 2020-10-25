<?php

// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <https://www.xoops.org>                             //
// ------------------------------------------------------------------------- //
// Based on:								     //
// myPHPNUKE Web Portal System - http://myphpnuke.com/	  		     //
// PHP-NUKE Web Portal System - http://phpnuke.org/	  		     //
// Thatware - http://thatware.org/					     //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
if (!eregi('index.php', $PHP_SELF)) {
    die('Access Denied');
}
require XOOPS_ROOT_PATH . '/include/xoopscodes.php';
if (!isset($submit_page)) {
    $submit_page = $PHP_SELF;
}
?>
    <table>
    <tr>
    <td>
<form action='<?php echo $submit_page; ?>' method='post' name='coolsus'>
<?php
echo '<p><b>' . _AM_TITLE . '</b><br>';
echo "<input type='text' name='title' id='title' value='";
if (isset($title)) {
    echo $title;
}
echo "' size='70' maxlength='80'>";
echo '</p><p>';

echo '<b>' . _AM_TOPIC . '</b>&nbsp;';
$xt = new XoopsTopic($xoopsDB->prefix('topics'));
if (isset($topicid)) {
    $xt->makeTopicSelBox(0, $topicid, 'topicid');
} else {
    $xt->makeTopicSelBox(0, 0, 'topicid');
}

echo '<br><b>' . _AM_TOPICDISPLAY . "</b>&nbsp;&nbsp;<input type='radio' name='topicdisplay' value='1'";
if (!isset($topicdisplay) || 1 == $topicdisplay) {
    echo ' checked';
}
echo '>' . _AM_YES . "&nbsp;<input type='radio' name='topicdisplay' value='0'";
if (0 == $topicdisplay) {
    echo ' checked';
}
echo '>' . _AM_NO . '&nbsp;&nbsp;&nbsp;';
echo '<b>' . _AM_TOPICALIGN . "</b>&nbsp;<select name='topicalign'>\n";
if ('L' == $topicalign) {
    $sel = " selected='selected'";
} else {
    $sel = '';
}
echo "<option value='R'>" . _AM_RIGHT . "</option>\n";
echo "<option value='L'" . $sel . '>' . _AM_LEFT . "</option>\n";
echo "</select>\n";
echo '<br>';

if (isset($ihome)) {
    puthome($ihome);
} else {
    puthome();
}

echo '</p><p><b>' . _AM_INTROTEXT . "</b><br><br>\n";
xoopsCodeTarea('hometext');
xoopsSmilies('hometext');
echo '<br></p><p><b>' . _AM_EXTEXT . "</b><br><br>\n";
//xoopsCodeTarea("bodytext");
echo "<textarea name='bodytext' wrap='virtual' cols='50' rows='10'>" . $bodytext . "</textarea><br>\n";
xoopsSmilies('bodytext');
echo '</p>';
if (!empty($xoopsConfig['allow_html'])) {
    echo '<p>' . _AM_ALLOWEDHTML . '<br>';

    echo get_allowed_html();

    echo '</p>';
}
echo "<p><input type='checkbox' name='nosmiley' value='1'";
if (isset($nosmiley) && 1 == $nosmiley) {
    echo ' checked';
}
echo '> ' . _AM_DISAMILEY . '<br>';
echo "<input type='checkbox' name='nohtml' value='1'";
if (isset($nohtml) && 1 == $nohtml) {
    echo ' checked';
}
echo '> ' . _AM_DISHTML . '<br>';

echo "<br><input type='checkbox' name='autodate' value='1'";
if (isset($autodate) && 1 == $autodate) {
    echo ' checked';
}
echo '> ';
$time = time();
if (isset($isedit) && 1 == $isedit && $published > $time) {
    echo _AM_CHANGEDATETIME . '<br>';

    printf(_AM_NOWSETTIME, formatTimestamp($published));

    echo '<br>';

    printf(_AM_CURRENTTIME, formatTimestamp($time));

    echo '<br>';

    echo "<input type='hidden' name='isedit' value='1'>";
} else {
    echo _AM_SETDATETIME . '<br>';

    printf(_AM_CURRENTTIME, formatTimestamp($time));

    echo '<br>';
}
$xmonth = 1;
echo _AM_MONTHC . " <select name='automonth'>\n";
while ($xmonth <= 12) {
    if ($xmonth == $automonth) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    echo "<option value='" . $xmonth . "' " . $sel . '>' . $xmonth . "</option>\n";

    $xmonth++;
}
echo "</select>&nbsp;\n";
$xday = 1;
echo _AM_DAYC . " <select name='autoday'>\n";
while ($xday <= 31) {
    if ($xday == $autoday) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    echo "<option value='" . $xday . "' " . $sel . '>' . $xday . "</option>\n";

    $xday++;
}
echo "</select>&nbsp;\n";

echo _AM_YEARC . " <input type='text' name='autoyear' value='";
if (isset($autoyear)) {
    echo $autoyear;
}
echo "' size='5' maxlength='4'>\n";
echo '&nbsp;' . _AM_TIMEC . " <select name='autohour'>\n";
$xhour = 0;
$cero = '0';
while ($xhour <= 23) {
    $dummy = $xhour;

    if ($xhour < 10) {
        $xhour = "$cero$xhour";
    }

    if ($xhour == $autohour) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    echo "<option value='" . $xhour . "' " . $sel . '>' . $xhour . "</option>\n";

    $xhour = $dummy;

    $xhour++;
}
echo "</select>\n";
echo " : <select name='automin'>\n";
$xmin = 0;
while ($xmin <= 59) {
    if ((0 == $xmin) or (5 == $xmin)) {
        $xmin = "0$xmin";
    }

    if ($xmin == $automin) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    echo "<option value='" . $xmin . "' " . $sel . '>' . $xmin . "</option>\n";

    $xmin += 5;
}
echo "</select>\n";
echo " : 00<br><br>\n";

if (isset($published) && 0 == $published && isset($type) && 'user' == $type) {
    echo "<br><input type='checkbox' name='approve' value='1'";

    if (isset($approve) && 1 == $approve) {
        echo ' checked';
    }

    echo '>&nbsp;<b>' . _AM_APPROVE . '</b><br>';
} else {
    if (isset($isedit) && 1 == $isedit) {
        echo "<br><input type='checkbox' name='movetotop' value='1'";

        if (isset($movetotop) && 1 == $movetotop) {
            echo ' checked';
        }

        echo '>&nbsp;<b>' . _AM_MOVETOTOP . '</b><br>';

        echo "<input type='hidden' name='isedit' value='1'>";
    }

    echo "<input type='hidden' name='approve' value='1'>";
}
echo "<select name='op'>\n";
echo "<option value='preview' selected='selected'>" . _AM_PREVIEW . "</option>\n";
echo "<option value='save'>" . _AM_SAVE . "</option>\n";
echo '</select>';
if (isset($storyid)) {
    echo "<input type='hidden' name='storyid' value='" . $storyid . "'>\n";
}
echo "<input type='hidden' name='type' value='" . $type . "'>\n";
echo "<input type='hidden' name='fct' value='articles'>\n";
echo "<input type='submit' value='" . _AM_GO . "'>\n";
echo '</p></form>';
echo '</td></tr></table>';

unset($submit_page);

function puthome($ihome = '')
{
    echo '<br><b>' . _AM_PUBINHOME . '</b>&nbsp;&nbsp;';

    if ((0 == $ihome) or ('' == $ihome)) {
        $sel1 = 'checked';

        $sel2 = '';
    }

    if (1 == $ihome) {
        $sel1 = '';

        $sel2 = 'checked';
    }

    echo "<input type='radio' name='ihome' value='0' $sel1>" . _AM_YES . '&nbsp;';

    echo "<input type='radio' name='ihome' value='1' $sel2>" . _AM_NO . '<br>';
}

?>
