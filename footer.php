<?php 
/**
* Footer
 */
global $ct_options;
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-1' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-1' );?>
                <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-2' );?>
                <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-3' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-3' );?>
                <?php endif; ?>
            </div>
            <div class="col-md-2 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-4' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-4' );?>
                <?php endif; ?>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <ul>
                        <?php $social_links = array( 'facebook', 'twitter', 'google', 'instagram', 'pinterest', 'vimeo', 'youtube-play', 'linkedin' ); ?>
                        <?php foreach( $social_links as $social_link ) : ?>
                            <?php if ( ! empty( $ct_options[ $social_link ] ) ) : ?>
                                <li><a href="<?php echo esc_url( $ct_options[ $social_link ] ) ?>"><i class="icon-<?php echo esc_attr( $social_link ) ?>"></i></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php if ( ! empty( $ct_options['copyright'] ) ) { ?>
                    <p>&copy; <?php echo esc_html( $ct_options['copyright'] ); ?></p>
                    <?php } ?>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->

<div id="toTop"></div><!-- Back to top button -->
<div id="overlay"><i class="icon-spin3 animate-spin"></i></div>
<?php wp_footer(); ?>
</body>
</html>