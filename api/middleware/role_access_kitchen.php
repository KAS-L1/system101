<?php

if (AUTH_USER['role'] != "KITCHEN") {
    if (AUTH_USER['role'] == "VENDOR") {
        redirectUrl("/vendor-portal");
    } 
}
