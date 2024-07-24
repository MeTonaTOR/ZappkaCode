<?php

function render_template($templatename) {
    global $templates;

    return $templates->get($templatename);
}

function output_page($content) {
    echo $content;
}

?>