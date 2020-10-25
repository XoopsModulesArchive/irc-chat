<?php

include 'admin_header.php';
//require_once XOOPS_ROOT_PATH."/class/xoopstopic.php";
//require_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/class.newsstory.php";
//require_once XOOPS_ROOT_PATH."/class/xoopshtmlform.php";
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
require XOOPS_ROOT_PATH . '/modules/irc-chat/cache/config.php';
?>
<?php
function newsConfig()
{
    global $xoopsConfig, $xoopsModule, $xoops_ircConfig;

    xoops_cp_header();

    echo "<div align='center'>";

    echo '  <center>';

    echo "  <table border='0' cellpadding='0' cellspacing='0' width='60%'>";

    echo '    <tr>';

    echo "      <td width='467'>Sorry but this is my first mod and well I am not very";

    echo '        good. Please go to the index.php file in the &quot;modules/irc-chat/';

    echo '       directory and edit it. It tell s you what to do and I will tell you too.';

    echo '       Where ever ^**ENTER CHAT URL**^ occurs below line 22 change it to the';

    echo "        url of your chat. This should occur in two places. I recommend going to <a href='http://chat.cjb.net'>http://chat.cjb.net</a>";

    echo '        to get a free chat room.</td>';

    echo '    </tr>';

    echo '  </table>';

    echo '  </center>';

    echo '</div>';
}

function newsConfigS()
{
    global $xoopsConfig, $_POST;

    $filename = '../cache/config.php';

    $file = fopen($filename, 'wb');

    $content = '';

    $content .= "<?php\n";

    $content .= "\n";

    $content .= "###############################################################################\n";

    $content .= "# IRC Module\n";

    $content .= "#\n";

    $content .= "# \$xoops_ircConfig['url']:	Url of Chat\n";

    $content .= "###############################################################################\n";

    $content .= "\n";

    $content .= "\$xoops_ircConfig['url'] = '" . $_POST['url'] . "';\n";

    $content .= "\n";

    $content .= '?>';

    fwrite($file, $content);

    fclose($file);

    redirect_header('index.php', 1, _AM_DBUPDATED);

    exit();
}

if (isset($op)) {
    switch ($op) {
        case 'newsConfig':
            newsConfig();
            break;
        case 'newsConfigS':
            if (xoopsfwrite()) {
                newsConfigS();
            }
            break;
        default:
            newsindex();
            break;
    }
} else {
    newsindex();
}
include 'admin_footer.php';
?>
