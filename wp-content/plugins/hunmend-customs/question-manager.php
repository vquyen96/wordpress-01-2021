<?php
### Check Whether User Can Manage Polls
if(!current_user_can('mysto_help')) {
    die('Access Denied');
}
global $wpdb;

if (isset( $_GET['delete'] )) {
    $ques_id = $_GET['delete'];
    $current_quest =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->help_question WHERE id = %d", $ques_id));
    if ($current_quest != null) {
        $wpdb->delete( $wpdb->help_question, array( 'id' => $current_quest->id ), array( '%d' ) );
    }
}

$user_id = get_current_user_id();
$user = get_userdata( $user_id );
$user_roles = $user->roles;
$query = "SELECT * FROM $wpdb->help_question ORDER BY id DESC";
if ( !in_array( 'administrator', $user_roles, true ) ) {
    $query = "SELECT * FROM $wpdb->help_question WHERE creator_id =" . get_current_user_id() . " ORDER BY id DESC";
    $total_ans =  $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->help_question JOIN $wpdb->help_cate ON $wpdb->help_question.cate_id = $wpdb->help_cate.id WHERE $wpdb->help_cate.creator_id = " . get_current_user_id());
}

$questions = $wpdb->get_results( $query);

$total_votes = 0;
$total_voters = 0;
?>
<!-- Last Action -->
<div id="message" class="updated" style="display: none;"></div>

<!-- Manage Category -->
<div class="wrap">
    <h2><?php _e('Manage Question', 'mysto-help'); ?></h2>
    <h3><?php _e('Question', 'mysto-help'); ?></h3>
    <br style="clear" />
    <table class="widefat">
        <thead>
        <tr>
            <th><?php _e('ID', 'mysto-help'); ?></th>
            <th><?php _e('Title', 'mysto-help'); ?></th>
            <th><?php _e('Created Date/Time', 'mysto-help'); ?></th>
            <th><?php _e('Status', 'mysto-help'); ?></th>
            <th colspan="3"><?php _e('Action', 'mysto-help'); ?></th>
        </tr>
        </thead>
        <tbody id="manage_polls">
        <?php
        if($questions) {
            $i = 0;
            $current_poll = (int) get_option('poll_currentpoll');
            $latest_poll = (int) get_option('poll_latestpoll');
            foreach($questions as $question) {
                $id = (int) $question->id;
                $title = ($question->title);
                $created_at = mysql2date(sprintf(__('%s @ %s', 'mysto-help'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $question->created_at));
                $status = (int) $question->status;

                if($i%2 == 0) {
                    $style = 'class="alternate"';
                }  else {
                    $style = '';
                }
                if($current_poll > 0) {
                    if($current_poll === $id) {
                        $style = 'class="highlight"';
                    }
                } elseif($current_poll === 0) {
                    if($id === $latest_poll) {
                        $style = 'class="highlight"';
                    }
                }
                echo "<tr id=\"poll-$id\" $style>\n";
                echo '<td><strong>'.number_format_i18n($id).'</strong></td>'."\n";
                echo '<td>';
                if($current_poll > 0) {
                    if($current_poll === $id) {
                        echo '<strong>'.__('Displayed:', 'mysto-help').'</strong> ';
                    }
                } elseif($current_poll === 0) {
                    if($id === $latest_poll) {
                        echo '<strong>'.__('Displayed:', 'mysto-help').'</strong> ';
                    }
                }
                echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ."</td>\n";
                echo "<td>$created_at</td>\n";
                echo '<td>';
                if($status === 1) {
                    _e('Open', 'mysto-help');
                } elseif($status === -1) {
                    _e('Future', 'mysto-help');
                } else {
                    _e('Closed', 'mysto-help');
                }
                echo "</td>\n";
                echo "<td><a href=\"admin.php?page=".plugin_basename('mysto-help/question-add.php')."&amp;id=$id\" class=\"edit\">".__('Edit', 'mysto-help')."</a></td>\n";
                echo "<td><a href=\"admin.php?page=".plugin_basename('mysto-help/question-manager.php')."&amp;delete=$id\" onclick=\"return confirm('You are about to delete this question');\" class=\"delete\">".__('Delete', 'mysto-help')."</a></td>\n";
                echo '</tr>';
                $i++;

            }
        } else {
            echo '<tr><td colspan="9" align="center"><strong>'.__('No Category Found', 'mysto-help').'</strong></td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
