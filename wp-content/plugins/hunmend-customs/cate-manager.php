<?php
### Check Whether User Can Manage Polls
if(!current_user_can('mysto_help')) {
    die('Access Denied');
}
global $wpdb;

if (isset( $_GET['delete'] )) {
    $cate_id = $_GET['delete'];
    $current_cate =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->help_cate WHERE id = %d", $cate_id));
    if ($current_cate != null) {
        $wpdb->delete( $wpdb->help_cate, array( 'id' => $current_cate->id ), array( '%d' ) );
    }
}

$paginate_page = ( isset( $_GET['paginate-page'] ) ? (int)( $_GET['paginate-page'] ) : 1 );
$count = 10;

### Variables Variables Variables
$base_name = plugin_basename('mysto-help/cate-manager.php');
$base_page = 'admin.php?page='.$base_name;
$mode       = ( isset( $_GET['mode'] ) ? sanitize_key( trim( $_GET['mode'] ) ) : '' );
$cate_id    = ( isset( $_GET['id'] ) ? (int) sanitize_key( $_GET['id'] ) : 0 );
$ques_id   = ( isset( $_GET['ques_id'] ) ? (int) sanitize_key( $_GET['ques_id'] ) : 0 );

$user = get_userdata( get_current_user_id() );
$user_roles = $user->roles;


$total_ans =  $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->help_question" );
$user_id = get_current_user_id();
$user = get_userdata( $user_id );
$user_roles = $user->roles;

$row_begin = ($paginate_page-1)*$count;
$query = "SELECT * FROM $wpdb->help_cate ORDER BY id DESC";
if ( !in_array( 'administrator', $user_roles, true ) ) {
    $query = "SELECT * FROM $wpdb->help_cate WHERE creator_id =" . get_current_user_id() . " ORDER BY id DESC";
    $total_ans =  $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->help_question JOIN $wpdb->help_cate ON $wpdb->help_question.cate_id = $wpdb->help_cate.id WHERE $wpdb->help_cate.creator_id = " . get_current_user_id());
}

$cates = $wpdb->get_results( $query);

$total_votes = 0;
$total_voters = 0;
?>
<!-- Last Action -->
<div id="message" class="updated" style="display: none;"></div>

<!-- Manage Category -->
<div class="wrap">
    <h2><?php _e('Manage Category', 'mysto-help'); ?></h2>
    <h3><?php _e('Category', 'mysto-help'); ?></h3>
    <br style="clear" />
    <table class="widefat">
        <thead>
        <tr>
            <th><?php _e('ID', 'mysto-help'); ?></th>
            <th><?php _e('Title', 'mysto-help'); ?></th>
            <th><?php _e('Image', 'mysto-help'); ?></th>
            <th><?php _e('Created Date/Time', 'mysto-help'); ?></th>
            <th><?php _e('Status', 'mysto-help'); ?></th>
            <th colspan="3"><?php _e('Action', 'mysto-help'); ?></th>
        </tr>
        </thead>
        <tbody id="manage_polls">
        <?php
        if($cates) {
            $i = 0;
            $current_poll = (int) get_option('poll_currentpoll');
            $latest_poll = (int) get_option('poll_latestpoll');
            foreach($cates as $cate) {
                $id = (int) $cate->id;
                $title = ($cate->title);
                $created_at = mysql2date(sprintf(__('%s @ %s', 'mysto-help'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $cate->created_at));
                $status = (int) $cate->status;

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
                echo "<td><img src='".$cate->img."' style='max-height: 64px; max-width: 64px;' alt=''></td>\n";
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
                echo "<td><a href=\"admin.php?page=mysto-help%2Fcate-add.php&amp;id=$id\" class=\"edit\">".__('Edit', 'mysto-help')."</a></td>\n";
                echo "<td><a href=\"admin.php?page=mysto-help%2Fcate-manager.php&amp;delete=$id\" onclick=\"return confirm('You are about to delete this category');\" class=\"delete\">".__('Delete', 'mysto-help')."</a></td>\n";
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
<p>&nbsp;</p>

<!-- Category Stats -->
<div class="wrap">
    <h3><?php _e('Category Stats:', 'mysto-help'); ?></h3>
    <br style="clear" />
    <table class="widefat">
        <tr>
            <th><?php _e('Total Category:', 'mysto-help'); ?></th>
            <td><?php echo number_format_i18n($i); ?></td>
        </tr>
        <tr class="alternate">
            <th><?php _e('Total Question:', 'mysto-help'); ?></th>
            <td><?php echo number_format_i18n($total_ans); ?></td>
        </tr>
    </table>
</div>

