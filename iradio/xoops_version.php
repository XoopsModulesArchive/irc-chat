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
$modversion['name'] = 'Internet Radio&TV';
$modversion['dirname'] = 'iradio';
$modversion['hasMain'] = 0;
$modversion['description'] = _MI_IRAD_DESC;
$modversion['version'] = '1.5';
$modversion['author'] = 'Ren?Hart <webmaster@just4me.nl>and sBob Janes<bob@bobjanes.com> and wani<wani@wanisys.net> ';
$modversion['credits'] = 'Bob Janes <bob@bobjanes.com> and XOOPS-ized by wanisys.net';
$modversion['license'] = 'GPL';
$modversion['official'] = 'No';
$modversion['image'] = 'images/iradio_logo.gif';
// Blocks
$modversion['blocks'][1]['file'] = 'iradio_block.php';
$modversion['blocks'][1]['show_func'] = 'show_radio_block';
$modversion['blocks'][1]['name'] = _MI_IRAD_TITLE;
$modversion['blocks'][1]['description'] = _MI_IRAD_DESC;
$modversion['blocks'][2]['file'] = 'itv_block.php';
$modversion['blocks'][2]['show_func'] = 'show_tv_block';
$modversion['blocks'][2]['name'] = _MI_ITV_TITLE;
$modversion['blocks'][2]['description'] = _MI_ITV_DESC;
// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';
// SQL stuff
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'iradio';
$modversion['tables'][2] = 'internet_tv';
// Templates
$modversion['templates'][1]['file'] = 'iradio_index.html';
$modversion['templates'][1]['description'] = '';
