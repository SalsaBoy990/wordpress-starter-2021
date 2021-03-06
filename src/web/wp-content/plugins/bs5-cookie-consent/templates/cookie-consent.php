<?php
/**
 * Cookie consent template.
 *
 * This template can be overriden by copying this file to your-theme/bs5-cookie-consent/cookie-consent.php
 *
 * @author 		Bastian Kreiter
 * @package 	bS5 Preloader
 * @version     1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

?>

<div id="gdpr-box" class="cookies-accept bg-success py-3 end-0 bottom-0 start-0 zi-1050">
    <div class="container">
        <div class="row">
            <div class="col-md-10 text-center text-md-start">
                <div class="d-flex align-items-center h-100">
                    <p class="mb-md-0"><?php esc_html_e('A weboldalon sütiket (cookie-kat) használunk, hogy biztonságos böngészés mellett jobb felhasználói élményt nyújthassunk.', 'bootscore'); ?>&nbsp;<a href="<?php echo get_home_url(); ?><?php esc_html_e('/privacy-policy', 'bootscore'); ?>" class="privacylink"><?php esc_html_e('Bővebb leírás', 'bootscore'); ?></a></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="d-flex align-items-center justify-content-center justify-content-md-end h-100">
                    <button class="gdpr-button-accept btn btn-primary w-100"><?php esc_html_e('Elfogadom', 'bootscore'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
