<?php
if (AUTH_USER['role'] != "ADMIN") {
    if (AUTH_USER['role'] == "VENDOR") {
        redirectUrl("/vendor-portal");
    } elseif (AUTH_USER['role'] == "KITCHEN") {
        redirectUrl("/kitchen-portal");
    }
}
