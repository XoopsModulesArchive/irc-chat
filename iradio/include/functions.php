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
 *
 * @param mixed $float
 * @return string
 * @return string
 */
/***************************************************/
/*   */
/* Ported to XOOPS By wanisys.net <wani@wanisys.net> */
/* 7 June 2004   */
/* Internet for everybody!  */
/* Enjoy!!!!!!   */
/*   */
/****************************************************/
function display_radio_module($float)
{
    global $xoopsDB, $xoopsConfig, $xoopsUser, $_COOKIE, $_GET, $_POST;

    // set player display width: change this if it doesn't fit in your template

    $radio_width = 138;

    // Include module configuration

    require XOOPS_ROOT_PATH . '/modules/iradio' . '/cache/config_radio.php';

    // Include module language files

    if (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php';
    } elseif (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php';
    }

    // Set default block title

    $title = _MB_IRAD_TITLE;

    // Get selected radio station

    if (!$float) {
        $radio_id = $_POST['select'];
    } else {
        $radio_id = $_GET['select'];
    }

    if ('' == $radio_id) {
        $radio_id = 0;
    }

    // Unpack configuration

    $autostart = (bool)$iRadioConfig['xautostart'];

    $picture = (bool)$iRadioConfig['xpicture'];

    $defpicture = (bool)$iRadioConfig['xdefpicture'];

    if (0 == $autostart) {
        $autostart = 'false';
    } else {
        $autostart = 'true';
    } // EndIf

    // script for opening popup window

    echo "
<script language='javascript'>
function launch(url) {
remote = open(url, '', 'width=190,height=190,left=0,top=0');
}
</script>";

    // Radio station selection

    $table = $xoopsDB->prefix('iradio');

    if (0 == $radio_id) {
        // If no station selected, get list of stations

        $result = $xoopsDB->query("SELECT radio_id, radio_name, radio_stream, radio_url, radio_picture FROM $table");

        $num = $xoopsDB->getRowsNum($result);

        // If only one station get station name

        if (1 == $num) {
            [$radio_id, $radio_name, $radio_stream, $radio_url, $radio_picture] = $xoopsDB->fetchRow($result);
        } else {
            $radio_name = _MB_IRAD_NOC;
        } // EndIf
    } else {
        // Get info for selected station

        $result = $xoopsDB->query("SELECT radio_name, radio_stream, radio_url, radio_picture FROM $table WHERE radio_id = $radio_id");

        [$radio_name, $radio_stream, $radio_url, $radio_picture] = $xoopsDB->fetchRow($result);

        $autostart = true;
    } // EndIf

    // Remove incomplete url

    if ('http://' == $radio_url) {
        $radio_url = '';
    }

    // picture settings

    if ($picture and ('' == $radio_picture) and $defpicture) {
        $radio_picture = $iRadioConfig['xnopicturename'];
    } // EndIf

    // content to display

    $content = '';

    $content .= '<center>';

    // Set link tags if station has url

    if ('' != $radio_url) {
        $open_tag = "<a href=$radio_url target='_blank'>";

        $close_tag = '</a>';
    }

    $title = $open_tag . $radio_name . $close_tag;

    if ($picture and ('' != $radio_picture)) {
        $content .= "<span>$open_tag
<img style='border:1 solid black; width:$radio_width;' 
src='" . XOOPS_URL . '/modules/iradio' . "/images/$radio_picture'>$close_tag</span><br>";
    } // EndIf

    if (true === check_real($radio_stream)) {
        $content .= "
<object id=player 
classid='clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa'
height=60 width='" . $radio_width . " '>
<param name='controls' value='controlpanel,statusfield'>
<param name='console' value='clip1'>
<param name='autostart' value=$autostart>
<param name='src' value='$radio_stream'>
<embed src='$radio_stream' 
type='audio/x-pn-realaudio-plugin' 
console='clip1' 
controls='controlpanel,statusfield' 
height=60 
width=$radio_width 
autostart=$autostart 
pluginspage='http://www.real.com/'>
</embed> 
<noembed><a href='$radio_stream'>play $radio_name</a></noembed>
</object>";
    } else {
        $content .= "
<object id='player' height='50' width='" . $radio_width . "' 
classid='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=6,4,7,1112' 
standby='loading microsoft?windows?media player components...' 
type='application/x-oleobject'>
<param name='filename' value='$radio_stream'>
<param name='showcontrols' value='true'>
<param name='showstatusbar' value='true'>
<param name='showpositioncontrols' value='false'>
<param name='showtracker' value='false'>
<embed type='application/x-mplayer2'
pluginspage = 'http://www.microsoft.com/windows/mediaplayer/'
src='$radio_stream'
name='player'
width='150
height='60'
autostart=$autostart
showcontrols='1' 
showstatusbar='1' 
showdisplay='1'>
</embed>
<noembed><a href='$radio_stream'>play $radio_name</a></noembed>
</object>";
    } // EndIf

    // Don't show 'open in popup' in popup

    if (1 != $num) {
        $content .= "
<form style='margin:0px; padding:2px;' name='form' method='post' action='$PHP_SELF'>";

        $content .= "<select name='select' onchange='form.submit()'>";

        $content .= '<option>-' . _MB_IRAD_CHO . '-</option>';

        $result = $xoopsDB->query("SELECT radio_id, radio_name FROM $table ORDER BY radio_name ASC");

        while (list($radio_id, $radio_name) = $xoopsDB->fetchRow($result)) {
            $content .= "<option value='$radio_id'>$radio_name</option>";
        } // EndWhile

        $content .= '</select></form>';
    } else {
        $content .= '<br>';
    } // EndIf

    $content .= "<center>
<a href=\"javascript:launch('" . XOOPS_URL . '/modules/iradio' . "/blocks/popup_radio.php')\">" . _MB_IRAD_FLO . '</a></center>';

    $content .= '</center>';

    $radio_content = $content;

    return $radio_content;
}

function display_radio_popup($float)
{
    global $xoopsDB, $xoopsConfig, $xoopsUser, $_COOKIE, $_GET, $_POST;

    // set player display width: change this if it doesn't fit in your template

    $radio_width = 138;

    // Include module configuration

    require XOOPS_ROOT_PATH . '/modules/iradio' . '/cache/config_radio.php';

    // Include module language files

    if (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php';
    } elseif (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php';
    }

    // Set default block title

    $title = _MB_IRAD_TITLE;

    // Get selected radio station

    if (!$float) {
        $radio_id = $_POST['select'];
    } else {
        $radio_id = $_GET['select'];
    }

    if ('' == $radio_id) {
        $radio_id = 0;
    }

    // Unpack configuration

    $autostart = (bool)$iRadioConfig['xautostart'];

    $picture = (bool)$iRadioConfig['xpicture'];

    $defpicture = (bool)$iRadioConfig['xdefpicture'];

    if (0 == $autostart) {
        $autostart = 'false';
    } else {
        $autostart = 'true';
    } // EndIf

    // script for opening popup window

    echo "
<script language='javascript'>
function launch(url) {
remote = open(url, '', 'width=190,height=190,left=0,top=0');
}
</script>";

    // Radio station selection

    $table = $xoopsDB->prefix('iradio');

    if (0 == $radio_id) {
        // If no station selected, get list of stations

        $result = $xoopsDB->query("SELECT radio_id, radio_name, radio_stream, radio_url, radio_picture FROM $table");

        $num = $xoopsDB->getRowsNum($result);

        // If only one station get station name

        if (1 == $num) {
            [$radio_id, $radio_name, $radio_stream, $radio_url, $radio_picture] = $xoopsDB->fetchRow($result);
        } else {
            $radio_name = _MB_IRAD_NOC;
        } // EndIf
    } else {
        // Get info for selected station

        $result = $xoopsDB->query("SELECT radio_name, radio_stream, radio_url, radio_picture FROM $table WHERE radio_id = $radio_id");

        [$radio_name, $radio_stream, $radio_url, $radio_picture] = $xoopsDB->fetchRow($result);

        $autostart = true;
    } // EndIf

    // Remove incomplete url

    if ('http://' == $radio_url) {
        $radio_url = '';
    }

    // picture settings

    if ($picture and ('' == $radio_picture) and $defpicture) {
        $radio_picture = $iRadioConfig['xnopicturename'];
    } // EndIf

    // content to display

    $content = '';

    $content .= '<center>';

    // Set link tags if station has url

    if ('' != $radio_url) {
        $open_tag = "<a href=$radio_url target='_blank'>";

        $close_tag = '</a>';
    }

    $title = $open_tag . $radio_name . $close_tag;

    if ($picture and ('' != $radio_picture)) {
        $content .= "<span>$open_tag
<img style='border:1 solid black; width:$radio_width;' 
src='" . XOOPS_URL . '/modules/iradio' . "/images/$radio_picture'>$close_tag</span><br>";
    } // EndIf

    if (true === check_real($radio_stream)) {
        $content .= "
<object id=player 
classid='clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa'
height=60 width='" . $radio_width . " '>
<param name='controls' value='controlpanel,statusfield'>
<param name='console' value='clip1'>
<param name='autostart' value=$autostart>
<param name='src' value='$radio_stream'>
<embed src='$radio_stream' 
type='audio/x-pn-realaudio-plugin' 
console='clip1' 
controls='controlpanel,statusfield' 
height=60 
width=$radio_width 
autostart=$autostart 
pluginspage='http://www.real.com/'>
</embed> 
<noembed><a href='$radio_stream'>play $radio_name</a></noembed>
</object>";
    } else {
        $content .= "
<object id='player' height='50' width='" . $radio_width . "' 
classid='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=6,4,7,1112' 
standby='loading microsoft?windows?media player components...' 
type='application/x-oleobject'>
<param name='filename' value='$radio_stream'>
<param name='showcontrols' value='true'>
<param name='showstatusbar' value='true'>
<param name='showpositioncontrols' value='false'>
<param name='showtracker' value='false'>
<embed type='application/x-mplayer2'
pluginspage = 'http://www.microsoft.com/windows/mediaplayer/'
src='$radio_stream'
name='player'
width='150
height='60'
autostart=$autostart
showcontrols='1' 
showstatusbar='1' 
showdisplay='1'>
</embed>
<noembed><a href='$radio_stream'>play $radio_name</a></noembed>
</object>";
    } // EndIf

    if (1 != $num) {
        $content .= "
<form style='margin:0px; padding:2px;' name='form' method='post' action='$PHP_SELF'>";

        $content .= "<select name='select' onchange='form.submit()'>";

        $content .= '<option>-' . _MB_IRAD_CHO . '-</option>';

        $result = $xoopsDB->query("SELECT radio_id, radio_name FROM $table ORDER BY radio_name ASC");

        while (list($radio_id, $radio_name) = $xoopsDB->fetchRow($result)) {
            $content .= "<option value='$radio_id'>$radio_name</option>";
        } // EndWhile

        $content .= '</select></form>';
    } else {
        $content .= '<br>';
    } // EndIf

    $content .= '';

    $content .= '</center>';

    echo $content;
}

function display_radio_block($float)
{
    global $xoopsDB, $xoopsConfig, $xoopsUser, $_COOKIE, $_GET, $_POST;

    // set player display width: change this if it doesn't fit in your template

    $radio_width = 138;

    // Include module configuration

    require XOOPS_ROOT_PATH . '/modules/iradio' . '/cache/config_radio.php';

    // Include module language files

    if (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php';
    } elseif (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php';
    }

    // Set default block title

    $title = _MB_IRAD_TITLE;

    // Get selected radio station

    if (!$float) {
        $radio_id = $_POST['select'];
    } else {
        $radio_id = $_GET['select'];
    }

    if ('' == $radio_id) {
        $radio_id = 0;
    }

    // Unpack configuration

    $autostart = (bool)$iRadioConfig['xautostart'];

    $picture = (bool)$iRadioConfig['xpicture'];

    $defpicture = (bool)$iRadioConfig['xdefpicture'];

    if (0 == $autostart) {
        $autostart = 'false';
    } else {
        $autostart = 'true';
    } // EndIf

    // script for opening popup window

    echo "
<script language='javascript'>
function launch(url) {
remote = open(url, '', 'width=190,height=190,left=0,top=0');
}
</script>";

    // Radio station selection

    $table = $xoopsDB->prefix('iradio');

    if (0 == $radio_id) {
        // If no station selected, get list of stations

        $result = $xoopsDB->query("SELECT radio_id, radio_name, radio_stream, radio_url, radio_picture FROM $table");

        $num = $xoopsDB->getRowsNum($result);

        // If only one station get station name

        if (1 == $num) {
            [$radio_id, $radio_name, $radio_stream, $radio_url, $radio_picture] = $xoopsDB->fetchRow($result);
        } else {
            $radio_name = _MB_IRAD_NOC;
        } // EndIf
    } else {
        // Get info for selected station

        $result = $xoopsDB->query("SELECT radio_name, radio_stream, radio_url, radio_picture FROM $table WHERE radio_id = $radio_id");

        [$radio_name, $radio_stream, $radio_url, $radio_picture] = $xoopsDB->fetchRow($result);

        $autostart = true;
    } // EndIf

    // Remove incomplete url

    if ('http://' == $radio_url) {
        $radio_url = '';
    }

    // picture settings

    if ($picture and ('' == $radio_picture) and $defpicture) {
        $radio_picture = $iRadioConfig['xnopicturename'];
    } // EndIf

    // content to display

    $content = '';

    $content .= '<center>';

    // Set link tags if station has url

    if ('' != $radio_url) {
        $open_tag = "<a href=$radio_url target='_blank'>";

        $close_tag = '</a>';
    }

    $title = $open_tag . $radio_name . $close_tag;

    if ($picture and ('' != $radio_picture)) {
        $content .= "<span>$open_tag
<img style='border:1 solid black; width:$radio_width;' 
src='" . XOOPS_URL . '/modules/iradio' . "/images/$radio_picture'>$close_tag</span><br>";
    } // EndIf

    if (true === check_real($radio_stream)) {
        $content .= "
<object id=player 
classid='clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa'
height=60 width='" . $radio_width . " '>
<param name='controls' value='controlpanel,statusfield'>
<param name='console' value='clip1'>
<param name='autostart' value=$autostart>
<param name='src' value='$radio_stream'>
<embed src='$radio_stream' 
type='audio/x-pn-realaudio-plugin' 
console='clip1' 
controls='controlpanel,statusfield' 
height=60 
width=$radio_width 
autostart=$autostart 
pluginspage='http://www.real.com/'>
</embed> 
<noembed><a href='$radio_stream'>play $radio_name</a></noembed>
</object>";
    } else {
        $content .= "
<object id='player' height='50' width='" . $radio_width . "' 
classid='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=6,4,7,1112' 
standby='loading microsoft?windows?media player components...' 
type='application/x-oleobject'>
<param name='filename' value='$radio_stream'>
<param name='showcontrols' value='true'>
<param name='showstatusbar' value='true'>
<param name='showpositioncontrols' value='false'>
<param name='showtracker' value='false'>
<embed type='application/x-mplayer2'
pluginspage = 'http://www.microsoft.com/windows/mediaplayer/'
src='$radio_stream'
name='player'
width='150
height='60'
autostart=$autostart
showcontrols='1' 
showstatusbar='1' 
showdisplay='1'>
</embed>
<noembed><a href='$radio_stream'>play $radio_name</a></noembed>
</object>";
    } // EndIf

    // Don't show 'open in popup' in popup

    if (1 != $num) {
        $content .= "
<form style='margin:0px; padding:2px;' name='form' method='post' action='$PHP_SELF'>";

        $content .= "<select name='select' onchange='form.submit()'>";

        $content .= '<option>-' . _MB_IRAD_CHO . '-</option>';

        $result = $xoopsDB->query("SELECT radio_id, radio_name FROM $table ORDER BY radio_name ASC");

        while (list($radio_id, $radio_name) = $xoopsDB->fetchRow($result)) {
            $content .= "<option value='$radio_id'>$radio_name</option>";
        } // EndWhile

        $content .= '</select></form>';
    } else {
        $content .= '<br>';
    } // EndIf

    $content .= "<center>
<a href=\"javascript:launch('" . XOOPS_URL . '/modules/iradio' . "/blocks/popup_radio.php')\">" . _MB_IRAD_FLO . '</a></center>';

    $content .= '</center>';

    // render block

    $block['title'] = $title;

    $block['content'] = $content;

    return $block;
}

function display_tv_module($float)
{
    global $xoopsDB, $xoopsConfig, $xoopsUser, $_COOKIE, $_GET, $_POST;

    // set player display width: change this if it doesn't fit in your template

    $tv_width = 138;

    // Include module configuration

    require XOOPS_ROOT_PATH . '/modules/iradio' . '/cache/config_tv.php';

    // Include module language files

    if (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php';
    } elseif (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php';
    }

    // Set default block title

    $title = _MB_ITV_TITLE;

    // Get selected radio station

    if (!$float) {
        $tv_id = $_POST['select'];
    } else {
        $tv_id = $_GET['select'];
    }

    if ('' == $tv_id) {
        $tv_id = 0;
    }

    // Unpack configuration

    $autostart = (bool)$itvConfig['xautostart'];

    $picture = (bool)$itvConfig['xpicture'];

    $defpicture = (bool)$itvConfig['xdefpicture'];

    $xtvvert = (int)$itvConfig['xtvvert'];

    $xtvhor = (int)$itvConfig['xtvhor'];

    if (0 == $autostart) {
        $autostart = 'false';
    } else {
        $autostart = 'true';
    } // EndIf

    // script for opening popup window

    echo "
<script language='javascript'>
function launch(url) {
remote = open(url, '', 'width=190,height=190,left=0,top=0');
}
</script>";

    // Radio station selection

    $table = $xoopsDB->prefix('internet_tv');

    if (0 == $tv_id) {
        // If no station selected, get list of stations

        $result = $xoopsDB->query("SELECT tv_id, tv_name, tv_stream, tv_url, tv_picture FROM $table");

        $num = $xoopsDB->getRowsNum($result);

        // If only one station get station name

        if (1 == $num) {
            [$tv_id, $tv_name, $tv_stream, $tv_url, $tv_picture] = $xoopsDB->fetchRow($result);
        } else {
            $tv_name = _MB_ITV_NOC;
        } // EndIf
    } else {
        // Get info for selected station

        $result = $xoopsDB->query("SELECT tv_name, tv_stream, tv_url, tv_picture FROM $table WHERE tv_id = $tv_id");

        [$tv_name, $tv_stream, $tv_url, $tv_picture] = $xoopsDB->fetchRow($result);

        $autostart = true;
    } // EndIf

    // Remove incomplete url

    if ('http://' == $tv_url) {
        $tv_url = '';
    }

    // picture settings

    if ($picture and ('' == $tv_picture) and $defpicture) {
        $tv_picture = $itvConfig['xnopicturename'];
    } // EndIf

    // content to display

    $content = '';

    $content .= '<center>';

    // Set link tags if station has url

    if ('' != $tv_url) {
        $open_tag = "<a href=$tv_url target='_blank'>";

        $close_tag = '</a>';
    }

    $title = $open_tag . $tv_name . $close_tag;

    if ($picture and ('' != $tv_picture)) {
        $content .= "<span>$open_tag
<img style='border:1 solid black; width:$tv_width;' 
src='" . XOOPS_URL . '/modules/iradio' . "/images/$tv_picture'>$close_tag</span><br>";
    } // EndIf

    if (true === check_real($tv_stream)) {
        $content .= "
<object id=player 
classid='clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa'
height='" . $xtvvert . " ' width='" . $xtvhor . " '>
<param name='controls' value='ImageWindow,Controlpanel'>
<param name='console' value='clip1'>
<param name='autostart' value=$autostart>
<param name='src' value='$tv_stream'>
<embed src='$tv_stream' 
type='audio/x-pn-realaudio-plugin' 
console='clip1' 
controls='ImageWindow,Controlpanel' 
height='" . $xtvvert . " ' width='" . $xtvhor . " '
autostart=$autostart 
pluginspage='http://www.real.com/'>
</embed> 
<noembed><a href='$tv_stream'>play $tv_name</a></noembed>
</object>";
    } else {
        $content .= "
<object id='player' height='" . $xtvvert . " ' width='" . $xtvhor . " '
classid='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=6,4,7,1112' 
standby='loading microsoft?windows?media player components...' 
type='application/x-oleobject'>
<param name='filename' value='$tv_stream'>
<param name='showcontrols' value='true'>
<param name='showstatusbar' value='true'>
<param name='showpositioncontrols' value='false'>
<param name='showtracker' value='false'>
<embed type='application/x-mplayer2'
pluginspage = 'http://www.microsoft.com/windows/mediaplayer/'
src='$tv_stream'
name='player'
height='" . $xtvvert . " ' width='" . $xtvhor . " '
autostart=$autostart
showcontrols='1' 
showstatusbar='1' 
showdisplay='1'>
</embed>
<noembed><a href='$tv_stream'>play $tv_name</a></noembed>
</object>";
    } // EndIf

    // Don't show 'open in popup' in popup

    if (1 != $num) {
        $content .= "
<form style='margin:0px; padding:2px;' name='form' method='post' action='$PHP_SELF'>";

        $content .= "<select name='select' onchange='form.submit()'>";

        $content .= '<option>-' . _MB_ITV_CHO . '-</option>';

        $result = $xoopsDB->query("SELECT tv_id, tv_name FROM $table ORDER BY tv_name ASC");

        while (list($tv_id, $tv_name) = $xoopsDB->fetchRow($result)) {
            $content .= "<option value='$tv_id'>$tv_name</option>";
        } // EndWhile

        $content .= '</select></form>';
    } else {
        $content .= '<br>';
    } // EndIf

    $content .= "<center>
<a href=\"javascript:launch('" . XOOPS_URL . '/modules/iradio' . "/blocks/popup_tv.php')\">" . _MB_ITV_FLO . '</a></center>';

    $content .= '</center>';

    $tv_content = $content;

    return $tv_content;
}

function display_tv_popup($float)
{
    global $xoopsDB, $xoopsConfig, $xoopsUser, $_COOKIE, $_GET, $_POST;

    // set player display width: change this if it doesn't fit in your template

    $tv_width = 138;

    $tv_height = 138;

    // Include module configuration

    require XOOPS_ROOT_PATH . '/modules/iradio' . '/cache/config_tv.php';

    // Include module language files

    if (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php';
    } elseif (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php';
    }

    // Set default block title

    $title = _MB_ITV_TITLE;

    // Get selected radio station

    if (!$float) {
        $tv_id = $_POST['select'];
    } else {
        $tv_id = $_GET['select'];
    }

    if ('' == $tv_id) {
        $tv_id = 0;
    }

    // Unpack configuration

    $autostart = (bool)$itvConfig['xautostart'];

    $picture = (bool)$itvConfig['xpicture'];

    $defpicture = (bool)$itvConfig['xdefpicture'];

    if (0 == $autostart) {
        $autostart = 'false';
    } else {
        $autostart = 'true';
    } // EndIf

    // script for opening popup window

    echo "
<script language='javascript'>
function launch(url) {
remote = open(url, '', 'width=190,height=190,left=0,top=0');
}
</script>";

    // Radio station selection

    $table = $xoopsDB->prefix('internet_tv');

    if (0 == $tv_id) {
        // If no station selected, get list of stations

        $result = $xoopsDB->query("SELECT tv_id, tv_name, tv_stream, tv_url, tv_picture FROM $table");

        $num = $xoopsDB->getRowsNum($result);

        // If only one station get station name

        if (1 == $num) {
            [$tv_id, $tv_name, $tv_stream, $tv_url, $tv_picture] = $xoopsDB->fetchRow($result);
        } else {
            $tv_name = _MB_ITV_NOC;
        } // EndIf
    } else {
        // Get info for selected station

        $result = $xoopsDB->query("SELECT tv_name, tv_stream, tv_url, tv_picture FROM $table WHERE tv_id = $tv_id");

        [$tv_name, $tv_stream, $tv_url, $tv_picture] = $xoopsDB->fetchRow($result);

        $autostart = true;
    } // EndIf

    // Remove incomplete url

    if ('http://' == $tv_url) {
        $tv_url = '';
    }

    // picture settings

    if ($picture and ('' == $tv_picture) and $defpicture) {
        $tv_picture = $itvConfig['xnopicturename'];
    } // EndIf

    // content to display

    $content = '';

    $content .= '<center>';

    // Set link tags if station has url

    if ('' != $tv_url) {
        $open_tag = "<a href=$tv_url target='_blank'>$tv_name";

        $close_tag = '</a><br>';
    }

    $title = $open_tag . $tv_name . $close_tag;

    if (true === check_real($tv_stream)) {
        $content .= "
<object id=player 
classid='clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa'
height=$tv_height width=$tv_width >
<param name='controls' value='ImageWindow,Controlpanel'>
<param name='console' value='clip1'>
<param name='autostart' value=$autostart>
<param name='src' value='$tv_stream'>
<embed src='$tv_stream' 
type='audio/x-pn-realaudio-plugin' 
console='clip1' 
controls='ImageWindow,Controlpanel' 
height=$tv_height 
width=$tv_width 
autostart=$autostart 
pluginspage='http://www.real.com/'>
</embed> 
<noembed><a href='$tv_stream'>play $tv_name</a></noembed>
</object>";
    } else {
        $content .= "
<object id='player' height=$tv_height width=$tv_width 
classid='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=6,4,7,1112' 
standby='loading microsoft?windows?media player components...' 
type='application/x-oleobject'>
<param name='filename' value='$tv_stream'>
<param name='showcontrols' value='true'>
<param name='showstatusbar' value='true'>
<param name='showpositioncontrols' value='false'>
<param name='showtracker' value='false'>
<embed type='application/x-mplayer2'
pluginspage = 'http://www.microsoft.com/windows/mediaplayer/'
src='$tv_stream'
name='player'
width=$tv_width 
height=$tv_height 
autostart=$autostart
showcontrols='1' 
showstatusbar='1' 
showdisplay='1'>
</embed>
<noembed><a href='$tv_stream'>play $tv_name</a></noembed>
</object>";
    } // EndIf

    if (1 != $num) {
        $content .= "
<form style='margin:0px; padding:2px;' name='form' method='post' action='$PHP_SELF'>";

        $content .= "<select name='select' onchange='form.submit()'>";

        $content .= '<option>-' . _MB_ITV_CHO . '-</option>';

        $result = $xoopsDB->query("SELECT tv_id, tv_name FROM $table ORDER BY tv_name ASC");

        while (list($tv_id, $tv_name) = $xoopsDB->fetchRow($result)) {
            $content .= "<option value='$tv_id'>$tv_name</option>";
        } // EndWhile

        $content .= '</select></form>';
    } else {
        $content .= '<br>';
    } // EndIf

    $content .= '';

    $content .= '</center>';

    echo $content;
}

function display_tv_block($float)
{
    global $xoopsDB, $xoopsConfig, $xoopsUser, $_COOKIE, $_GET, $_POST;

    // set player display width: change this if it doesn't fit in your template

    $tv_width = 138;

    $tv_height = 138;

    // Include module configuration

    require XOOPS_ROOT_PATH . '/modules/iradio' . '/cache/config_tv.php';

    // Include module language files

    if (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/' . $xoopsConfig['language'] . 'blocks.php';
    } elseif (@file_exists(XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/iradio' . '/language/english/blocks.php';
    }

    // Set default block title

    $title = _MB_ITV_TITLE;

    // Get selected radio station

    if (!$float) {
        $tv_id = $_POST['select'];
    } else {
        $tv_id = $_GET['select'];
    }

    if ('' == $tv_id) {
        $tv_id = 0;
    }

    // Unpack configuration

    $autostart = (bool)$itvConfig['xautostart'];

    $picture = (bool)$itvConfig['xpicture'];

    $defpicture = (bool)$itvConfig['xdefpicture'];

    if (0 == $autostart) {
        $autostart = 'false';
    } else {
        $autostart = 'true';
    } // EndIf

    // script for opening popup window

    echo "
<script language='javascript'>
function launch(url) {
remote = open(url, '', 'width=190,height=190,left=0,top=0');
}
</script>";

    // Radio station selection

    $table = $xoopsDB->prefix('internet_tv');

    if (0 == $tv_id) {
        // If no station selected, get list of stations

        $result = $xoopsDB->query("SELECT tv_id, tv_name, tv_stream, tv_url, tv_picture FROM $table");

        $num = $xoopsDB->getRowsNum($result);

        // If only one station get station name

        if (1 == $num) {
            [$tv_id, $tv_name, $tv_stream, $tv_url, $tv_picture] = $xoopsDB->fetchRow($result);
        } else {
            $tv_name = _MB_ITV_NOC;
        } // EndIf
    } else {
        // Get info for selected station

        $result = $xoopsDB->query("SELECT tv_name, tv_stream, tv_url, tv_picture FROM $table WHERE tv_id = $tv_id");

        [$tv_name, $tv_stream, $tv_url, $tv_picture] = $xoopsDB->fetchRow($result);

        $autostart = true;
    } // EndIf

    // Remove incomplete url

    if ('http://' == $tv_url) {
        $tv_url = '';
    }

    // picture settings

    if ($picture and ('' == $tv_picture) and $defpicture) {
        $tv_picture = $itvConfig['xnopicturename'];
    } // EndIf

    // content to display

    $content = '';

    $content .= '<center>';

    // Set link tags if station has url

    if ('' != $tv_url) {
        $open_tag = "<a href=$tv_url target='_blank'>$tv_name";

        $close_tag = '</a><br>';
    }

    $title = $open_tag . $tv_name . $close_tag;

    if (true === check_real($tv_stream)) {
        $content .= "
<object id=player 
classid='clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa'
height=$tv_height width=$tv_width >
<param name='controls' value='ImageWindow,Controlpanel'>
<param name='console' value='clip1'>
<param name='autostart' value=$autostart>
<param name='src' value='$tv_stream'>
<embed src='$tv_stream' 
type='audio/x-pn-realaudio-plugin' 
console='clip1' 
controls='ImageWindow,Controlpanel' 
height=$tv_height 
width=$tv_width 
autostart=$autostart 
pluginspage='http://www.real.com/'>
</embed> 
<noembed><a href='$tv_stream'>play $tv_name</a></noembed>
</object>";
    } else {
        $content .= "
<object id='player' height='" . $tv_height . "' width='" . $tv_width . "' 
classid='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=6,4,7,1112' 
standby='loading microsoft?windows?media player components...' 
type='application/x-oleobject'>
<param name='filename' value='$tv_stream'>
<param name='showcontrols' value='true'>
<param name='showstatusbar' value='true'>
<param name='showpositioncontrols' value='false'>
<param name='showtracker' value='false'>
<embed type='application/x-mplayer2'
pluginspage = 'http://www.microsoft.com/windows/mediaplayer/'
src='$tv_stream'
name='player'
width=$tv_width 
height=$tv_height 
autostart=$autostart
showcontrols='1' 
showstatusbar='1' 
showdisplay='1'>
</embed>
<noembed><a href='$tv_stream'>play $tv_name</a></noembed>
</object>";
    } // EndIf

    // Don't show 'open in popup' in popup

    if (1 != $num) {
        $content .= "
<form style='margin:0px; padding:2px;' name='form' method='post' action='$PHP_SELF'>";

        $content .= "<select name='select' onchange='form.submit()'>";

        $content .= '<option>-' . _MB_ITV_CHO . '-</option>';

        $result = $xoopsDB->query("SELECT tv_id, tv_name FROM $table ORDER BY tv_name ASC");

        while (list($tv_id, $tv_name) = $xoopsDB->fetchRow($result)) {
            $content .= "<option value='$tv_id'>$tv_name</option>";
        } // EndWhile

        $content .= '</select></form>';
    } else {
        $content .= '<br>';
    } // EndIf

    $content .= "<center>
<a href=\"javascript:launch('" . XOOPS_URL . '/modules/iradio' . "/blocks/popup_tv.php')\">" . _MB_ITV_FLO . '</a></center>';

    $content .= '</center>';

    // render block

    $block['title'] = $title;

    $block['content'] = $content;

    return $block;
}

/**
 * Function to check for real player files
 *
 * @param mixed $t_url
 * @return bool
 * @return bool
 */
function check_real($t_url)
{
    $temp_url = basename($t_url);

    $temp_url = trim($temp_url);

    $temp_url = mb_strtolower($temp_url);

    $check_ram = mb_substr($temp_url, -3);

    $check_rm = mb_substr($temp_url, -2);

    if ('rm' == $check_rm) {
        return true;
    } elseif ('ram' == $check_ram) {
        return true;
    } elseif ('ra' == $check_rm) {
        return true;
    } elseif ('pls' == $check_ram) {
        return true;
    } elseif ('rpm' == $check_ram) {
        return true;
    }

    return false;
    // EndIf
} //EndFunction
