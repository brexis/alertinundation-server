<?php

function protectCharacter($var) {
    return addslashes(htmlentities($var, ENT_QUOTES, "UTF-8"));
}

function deprotectCharacter($var) {
    return (html_entity_decode(stripslashes($var), ENT_QUOTES, "UTF-8"));
}

