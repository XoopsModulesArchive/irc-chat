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
include '../../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsmodule.php';
require XOOPS_ROOT_PATH . '/include/cp_functions.php';
$url_arr = explode('/', str_replace(str_replace('https://', 'http://', XOOPS_URL . '/modules/'), '', 'http://' . $HTTP_SERVER_VARS['HTTP_HOST'] . $xoopsRequestUri));
$moduleHandler = xoops_getHandler('module');
$xoopsModule = $moduleHandler->getByDirname($url_arr[0]);
unset($url_arr);
if (!is_object($xoopsModule) || !$xoopsModule->getVar('isactive')) {
    redirect_header(XOOPS_URL . '/', 1, _MODULENOEXIST);

    exit();
}
$modulepermHandler = xoops_getHandler('groupperm');
if ($xoopsUser) {
    if (!$modulepermHandler->checkRight('module_admin', $xoopsModule->getVar('mid'), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);

        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);

    exit();
}
// set config values for this module
if (1 == $xoopsModule->getVar('hasconfig') || 1 == $xoopsModule->getVar('hascomments')) {
    $configHandler = xoops_getHandler('config');

    $xoopsModuleConfig = &$configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
}
// include the default language file for the admin interface
if (file_exists('../language/' . $xoopsConfig['language'] . '/admin.php')) {
    include '../language/' . $xoopsConfig['language'] . '/admin.php';
}
