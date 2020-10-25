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
function show_tv_block()
{
    global $_COOKIE;

    $root = XOOPS_ROOT_PATH . '/modules/iradio';

    require_once $root . '/include/functions.php';

    if ('TVPopUp' == $_COOKIE['FloatCookie1']) {
        $block['title'] = _MB_ITV_TITLE;

        $block['content'] = "<div style='text-align:center;'>" . _MB_ITV_DIS . '</div>';

        return $block;
    }

    return display_tv_block(false);
}
