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
include '../../mainfile.php';
if ('iradio' == $xoopsConfig['startpage']) {
    $xoopsOption['show_rblock'] = 1;

    require XOOPS_ROOT_PATH . '/header.php';

    make_cblock();

    echo '<br>';
} else {
    $xoopsOption['show_rblock'] = 0;

    require XOOPS_ROOT_PATH . '/header.php';
}
$myts = MyTextSanitizer::getInstance();
$GLOBALS['xoopsOption']['template_main'] = 'iradio_index.html';
global $_COOKIE;
$root = XOOPS_ROOT_PATH . '/modules/iradio';
include $root . '/include/functions.php';
if ('RadioPopUp' == $_COOKIE['FloatCookie']) {
    $radio_module_content = display_radio_module();
} else {
    $radio_module_content = display_radio_module(false);
}
if ('TVPopUp' == $_COOKIE['FloatCookie']) {
    $tv_module_content = display_tv_module();
} else {
    $tv_module_content = display_tv_module(false);
}
$xoopsTpl->assign('tv_module', $tv_module_content);
$xoopsTpl->assign('radio_module', $radio_module_content);
?>
<?php
require XOOPS_ROOT_PATH . '/footer.php';
?>
