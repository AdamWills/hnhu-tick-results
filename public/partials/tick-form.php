<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://adamwills.io
 * @since      1.0.0
 *
 * @package    Hnhu_Tick_Results
 * @subpackage Hnhu_Tick_Results/public/partials
 */

$output = '<form class="form-tick-results" method="post" action="">';
$output.= '<h2>'.__('Get Tick Results',$this->plugin_name) . '</h2>';
$output.= '<div class="input-group">';
$output.= '<label for="ticket-number">'.__('Enter your ticket number that was provided by the Health Unit:',$this->plugin_name) .'</label>';
$output.= '<input type="text" id="ticket-number" name="ticket-number">';
$output.= '</div>';
$output.= '<button type="submit" name="submit" class="btn">'.__('Get Results',$this->plugin_name) .'</button>';
$output.= '</form>';
