<?php

if (AUTH_USER['role'] != "VENDOR") {
    if (AUTH_USER['role'] == "KITCHEN") {
        redirectUrl("/kitchen-portal");
    }
}
