<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('sys_ID')) {
        $ci->session->set_flashdata('error', "Harap login terlebih dahulu");
        redirect('Auth');
    } else {
        true;
    }
}
