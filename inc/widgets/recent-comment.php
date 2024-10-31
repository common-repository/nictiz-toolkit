<?php

add_action( 'widgets_init', array( 'Nictiz_Toolkit_Widget_Comments', 'register_widget' ) );

class Nictiz_Toolkit_Widget_Comments extends Kopa_Widget {

  public $kpb_group = 'other';

  public static function register_widget() {
    register_widget( 'Nictiz_Toolkit_Widget_Comments' );
  }

  public function __construct() {
    $this->widget_cssclass    = ' k-widget-recent-comments';
    $this->widget_description = esc_html__( 'Display newest comments', 'nictiz-toolkit' );
    $this->widget_id          = 'nictitate_toolkit_ii-recent-comment';
    $this->widget_name        = esc_html__( '__Recent Comments', 'nictiz-toolkit' );
    
    $this->settings           = array(      
      'title'  => array(
        'type'  => 'text',
        'std'   => '',
        'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
      ),            
      'count'  => array(
        'type'  => 'number',
        'std'   => 3,
        'label' => esc_html__( 'Number of comments:', 'nictiz-toolkit' )
      )
    );

    parent::__construct();
  }

  public function widget( $args, $instance ) { 
  	ob_start();
    $instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
    extract( $instance );
    extract( $args );
    echo wp_kses_post( $before_widget );
    if ( ! empty($title) ): ?>
    	<h3 class="widget-title"><?php echo esc_attr($title); ?></h3>
    <?php 
    endif; 
    $comments = get_comments(array(
      'status' => 'approve',
      'number' => $count,
      'order'  => 'DESC'
      )
    );
    if ( $comments ) :
    ?>
    <ul class="list-unstyled">
      <?php foreach ( $comments as $comment ) : ?>
      	<li class="item">
      		<a href="<?php echo get_permalink( $comment->comment_post_ID ); ?>">
            <?php echo get_avatar( $comment->comment_author_email, 47, null, $comment->comment_author ); ?>
      			<time datetime="<?php echo  get_comment_date( 'H:i A - F d, Y', $comment->comment_ID ); ?>"><?php echo  get_comment_date( 'H:i A - F d, Y', $comment->comment_ID ); ?>
            </time>
      			<span class="item-author"><?php echo esc_attr( $comment->comment_author ); ?> <span><?php echo esc_html__( 'say', 'nictiz-toolkit' ); ?>:</span></span>
      		</a>
      		<p>“ <?php echo wp_trim_words( strip_tags( $comment->comment_content ), 20 ); ?></p>
      	</li>
      <?php endforeach; ?>
    </ul>
  	<?php 
    endif; 
  	$content = ob_get_clean();
  	echo $content;
  	echo wp_kses_post($after_widget);
  }
}


