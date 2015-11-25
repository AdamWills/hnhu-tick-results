<?php

/**
 * Results of the tick submission
 *
 * @link       https://adamwills.io
 * @since      1.0.0
 *
 * @package    Hnhu_Tick_Results
 * @subpackage Hnhu_Tick_Results/public/partials
 */

// double checking if we've posted the info...
if (isset($_POST['ticket-number'])) {

  // checking to make sure we're dealing with an integer
  $ticket_id = absint($_POST['ticket-number']);
  if ($ticket_id < 1) {
    $output = '<div class="notice">';
    $output.= '<h2>Notice:</h2>';
    $output.= '<p>Not a valid ticket number.</p>';
    $output.= '</div>';
  } else {

    // search tickets by the name/ticket id
    $args = array (
    	'name'             => $ticket_id,
    	'post_type'        => 'tick-result',
    	'posts_per_page'   => '1',
    );

    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        // format the time to be pretty-ish.
        $date = DateTime::createFromFormat('Ymd', get_field('date_sample_submitted'));

        // get the info from the tick result
        $tick_type = get_field('tick_type');
        $tick_status = get_field('status');
        $tick_statuses = get_field( 'statuses', 'tick-types_' . $tick_type );

        // look to find the right tick status and set the output accordingly.
        foreach ($tick_statuses as $s) {
          if ($s['name'] === $tick_status) {
            $status_text = $s['status_message'];
            $recommendation = $s['recommendation'];
          }
        }

        // prepare the output
        $output = '<div class="tick-results">';
        $output.= '<h2>Your Tick Results</h2>';
        $output.= '<label>' . __('Ticket Number', $this->plugin_name ) . ':</label><p>'. get_the_title() .'</p>';
        $output.= '<label>' . __('Date Submitted', $this->plugin_name ) . ':</label><p>' . $date->format('F d, Y') . '</p>';
        $output.= '<label>' . __('Status', $this->plugin_name ) . ':</label> ' . $status_text;
        $output.= '<label>' . __('Recommendations Based on Status', $this->plugin_name ) . ':</label> ' . $recommendation;
        $output.= '</div>';
      endwhile;

    // if the ticket number wasn't found, let the user know.
    else:
      $output = '<div class="notice">';
      $output.= '<h2>' . __('Notice', $this->plugin_name ) . ':</h2>';
      $output.= '<p>' . __('Ticket number not found. Please confirm you have entered the correct ticket number.</p>', $this->plugin_name ) . '</p>';
      $output.= '</div>';
    endif;
  }

}
