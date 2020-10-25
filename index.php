<?php

include '../../mainfile.php';
include $xoopsConfig['root_path'] . 'header.php';
include $xoopsConfig['root_path'] . 'modules/' . $xoopsModule->dirname() . '/cache/config.php';

global $xoopsUser, $xoops_ircConfig;

if ($xoopsUser) {
    $thisUser = $xoopsUser->uname();
} else {
    $thisUser = 'Guest';
}

?>
<?php
####################################################
# Enter the url of your chat bellow
# I would suggest using http://www.centralchat.net to get
# a free chat room. NO SIGN UP JUST DO WHAT IT SAYS BELOW!
# Enter your channel name you want (starting with the pound sign, #)
# in the place bellow with ***^^^ENTER CHANNEL^^^***
####################################################
?>
    <body>
    <font size="4"><font color="#000000">
            <table align=center border=0>
                <tr>
                    <td>
                        <div align="center">
                            <table border="1" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <center>
                                            <b>
                                                <font face="Arial" size="2">press the <img src="http://www.centralchat.net/connect.gif"> button below to connect!
                                                </font>
                                            </b>
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <applet archive="mschat.jar" codebase="http://www.centralchat.net/" code="MSChat" border="0" align="baseline" width="580" height="400">
                                            <param name="autodisconnect" value="true">
                                            <param name="CABBASE" value="mschat.cab">
                                            <param name="autoconnect" value="false">
                                            <param name="room" value="***^^^ENTER CHANNEL^^^***">
                                            <param name="memberlist" value="true">
                                            <param name="motd" value="true">
                                            <param name="stats" value="true">
                                            <param name="id" value="msjavauser">
                                            <param name="banner" value="http://www.centralchat.net/chat_wm.jpg">
                                            <param name="rely" value="false">
                                            You do not have a java enabled web browser
                                        </applet>
                                        <center>Chat provided by <a href="http://www.centralchat.net">CentralChat.net</a></center>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
    </body>
    </html>
<?php
include $xoopsConfig['root_path'] . 'footer.php';
?>
