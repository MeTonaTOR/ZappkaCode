<?php

function render_template($templatename) {
    global $templates;

    return $templates->get($templatename);
}

function output_page($content) {
    echo $content;
}

function inline_message($url, $message) {
    global $_SESSION;

    $_SESSION['inline'] = array(
        'message' => ($message)
    );

    header("Location: ".$url);
    die();
}

?>