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
$root = XOOPS_ROOT_PATH . '/modules/iradio';
include $root . '/include/functions.php';
echo "
<script language='JavaScript'>
var exit=true;
function xit(){
var today=new Date()
var expiredate=new Date()
expiredate.setTime(today.getTime()-1000*60*60*24*2)
document.cookie='FloatCookie1=TVPopUp;expires='+expiredate.toGMTString()+';path=/'
} 
</script>
<body leftmargin='0' topmargin='0' onunload='xit();' onload='sizeonload();'>
<script>
function sizeonload() {
var today=new Date()
var expiredate=new Date()
expiredate.setTime(today.getTime()+1000*60*60*24)
document.cookie='FloatCookie1=TVPopUp;expires='+expiredate.toGMTString()+';path=/'
window.resizeTo(10,10);
w = (document.all)?document.body.scrollWidth:document.documentElement.offsetWidth;
h = (document.all)?document.body.scrollHeight:document.documentElement.offsetHeight
window.resizeTo(w + 10, h + 32);
}
</script>";
// use xoops_header to include the theme css file into the headers
// Load the theme
// radio station selected from floating block
display_tv_popup();
