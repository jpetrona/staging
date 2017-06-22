<?php
/**
 * Output
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function get_global_account_id() {
    $options = get_option( 'microsub_options' );
	return $options['microsub_account_id'];
}

function append_button($content, $microsub_account_id, $microsub_button_caption, $with_eyes, $filter) {
    $append = '';

    if (! empty($microsub_account_id)) {

        $include = empty($filter);

        if (! $include) {
            $items = explode(',', strtolower($filter));
            $l_content= strtolower($content);
            foreach($items as $item) {
                if (strpos($l_content, trim($item)) !== false) {
                    $include = true;
                    break;
                }
            }
        }

        if ($include) {
            if (empty($microsub_button_caption)) {
                $microsub_button_caption = 'Support Us';
            }

            $append =  "<microsub-button prompt=\"" . $microsub_button_caption . "\"";

            if ($with_eyes) {
                $append =  $append . " :theme=\"{eyes: true}\"";
            }
            $append =  $append . "></microsub-button>";
        } else {
            $append = '<!-- Microsub: not included -->';
        }
    } else {
        $append = '<!-- Microsub: no account id -->';
    }

    return $content . $append;
}

/**
 * Output the button global.
 */
function microsub_output_content_global($content) {

	$options = get_option( 'microsub_options' );
	$microsub_account_id    = $options['microsub_account_id'];
	$microsub_button_caption    = $options['microsub_button_caption'];
	$microsub_button_eyes    = isset($options['microsub_button_eyes']);
	$microsub_button_filter    = $options['microsub_button_filter'];

    return append_button($content, $microsub_account_id, $microsub_button_caption, $microsub_button_eyes, $microsub_button_filter);
}

/**
 * Output the button post.
 */
function microsub_output_content_post($content) {

    if ( ! is_singular() || get_global_account_id()) {
		return $content;
	}

	$microsub_account_id = get_post_meta( get_the_id(), '_microsub_account_id', true );
	$microsub_button_caption = get_post_meta( get_the_id(), '_microsub_button_caption', true );
	$microsub_button_eyes = get_post_meta( get_the_id(), '_microsub_button_eyes', true );
	$microsub_button_filter = get_post_meta( get_the_id(), '_microsub_button_filter', true );

    return append_button($content, $microsub_account_id, $microsub_button_caption, $microsub_button_eyes, $microsub_button_filter);
}

add_filter( 'the_content', 'microsub_output_content_global' );
add_filter( 'the_content', 'microsub_output_content_post' );

function microsub_append_script($microsub_account_id) {
    if ( ! empty( $microsub_account_id ) ) {
		?>

		<script>
        (function(w,d,t,u){
            w.msub = function() {
              (w.msubData = w.msubData || []).push(arguments);
            };
            var s = d.createElement(t);
            s.type = 'text/javascript';
            s.async = true;
            s.src = u;
            var m = d.getElementsByTagName(t)[0]; m.parentNode.insertBefore(s, m);
        })(window, document, 'script', 'https://microsub.io/widgets.js');

        msub('create', '<?php echo $microsub_account_id; ?>');
        </script> <?php
	} else {
	    echo '<!-- Microsub: no account id -->';
	}
}

/**
 * Output the global script.
 */
function microsub_output_script_global() {

	$options = get_option( 'microsub_options' );
	$microsub_account_id = $options['microsub_account_id'];

	microsub_append_script($microsub_account_id);
}

/**
 * Output the post script.
 */
function microsub_output_script_post() {

	if ( ! is_singular() || get_global_account_id() ) {
        return;
    }

    $microsub_account_id = get_post_meta( get_the_id(), '_microsub_account_id', true );;

	microsub_append_script($microsub_account_id);
}

add_action( 'wp_footer', 'microsub_output_script_global' );
add_action( 'wp_footer', 'microsub_output_script_post' );
