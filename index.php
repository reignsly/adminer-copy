<?php
// curtain.php
ob_start(); // start output buffering early to avoid headers already sent
// use Adminer's session name so Adminer doesn't try to change session settings later
if (session_status() === PHP_SESSION_NONE) {
    if (!headers_sent()) {
        @session_name('adminer_sid');
    }
    session_start();
}

$curtain_password = '$$$Gca@'.date("YmD");

if (!isset($_SESSION['curtain_ok'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['curtain'] === $curtain_password) {
            $_SESSION['curtain_ok'] = true;
            header("Location: index.php");
            exit;
        } else {
            echo "Wrong password.";
        }
    }
    ?>
    <form method="post">
        Curtain Password: <input type="password" name="curtain">
        <input type="submit" value="Enter">
    </form>
    <?php
    exit;
}

// include Adminer into buffer so we can inject logout UI and avoid premature output
include "adminer.php"; // path to Adminer

$content = ob_get_clean();

// Idle timeout (seconds)
$idle_timeout_seconds = 10 * 60; // 10 minutes

$script = "\n<style>#curtain-logout-btn{position:fixed;left:10px;top:10px;padding:6px 10px;background:#c00;color:#fff;border-radius:4px;text-decoration:none;z-index:99999}#curtain-logout-warning{position:fixed;right:10px;top:48px;background:#fffae6;color:#222;padding:6px 10px;border-radius:4px;z-index:99999;display:none}</style>\n";
$script .= "<a id=\"curtain-logout-btn\" href=\"logout.php\">Logout</a>\n";
$script .= "<div id=\"curtain-logout-warning\">You will be logged out due to inactivity.</div>\n";
$script .= "<script>var idle=0;var idleLimit=".((int)$idle_timeout_seconds).";var warnBefore=30;var warned=false;function resetIdle(){idle=0;if(warned){warned=false;document.getElementById('curtain-logout-warning').style.display='none';}}setInterval(function(){idle++;if(idle>=idleLimit-warnBefore&&!warned){warned=true;document.getElementById('curtain-logout-warning').style.display='block';}if(idle>=idleLimit){window.location='logout.php';}},1000);['mousemove','keydown','wheel','mousedown','touchstart'].forEach(function(e){document.addEventListener(e,resetIdle,{passive:true});});</script>\n";

if (strpos($content, "</body>") !== false) {
    $content = str_replace("</body>", $script."</body>", $content);
} else {
    $content .= $script;
}

echo $content;