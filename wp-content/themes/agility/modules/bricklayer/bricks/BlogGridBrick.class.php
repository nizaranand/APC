<?php
/**
 * BrickLayer Brick: Blog Grid
 *
 * Displays blog posts in a grid layout
 *
 */

class BlogGridBrick extends Brick{

	function __construct( $brick_id = -1 ){

		parent::__construct( 'BlogGrid' , __( 'Blog - Grid Layout', 'agility' ) , $brick_id );

		$this->addSetting( new BrickSetting( 'details', __( 'This brick will print the blog in a grid layout.  It can only be used '.
			'in a full-width (sixteen column) layout area, and must be a full-width brick.' , 'agility' ), 
			'info', '', $this->id , $this->brick_id ) );

		$bq_config = array(
			'ops'	=> agility_blog_ops(),
			'desc'	=> __( 'Select a particular blog from the BlogConstructor, or use the default blog', 'agility' )
		);

		$this->addSetting( new BrickSetting( 'blog_query_id', __( 'Blog' , 'agility' ),
			'select', 0, $this->id, $this->brick_id, $bq_config ) );

	}

	public function draw( $container_cols, $columns = '' ){

		$this->before( '' );

		if( $container_cols != 16 ){
			echo '<div class="hint">'.__( 'The Blog Grid brick can only be used in a full-width (sixteen column) content area!' , 'agility' ).'</div><br/>';
		}


		$blog_query_id 		= $this->getSetting( 'blog_query_id' );

		$queryStruct;
		if( $blog_query_id ){
			$queryStruct 		= new BlogQueryStruct( $blog_query_id );
			$blog_query 		= $queryStruct->query();
		}
		else{
			$paged_var = is_front_page() ? 'page' : 'paged';
			$blog_query = new WP_Query( array( 
				'post_type'	=>	'post',
				'paged' 	=> 	get_query_var( $paged_var )
			));
		}

		
		if ( $blog_query->have_posts() ) : 
			global $wp_query;
			$temp_query = $wp_query;
			$wp_query = $blog_query;
			?>
						<!-- Blog Grid Layout -->		
						<div class="mosaic col-3 cf clearfix blog-layout-grid">

							<?php /* Start the Loop */ $post_index = 0; ?>
							<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>

								<?php
									get_template_part( 'content', 'grid' );
									$post_index++;
								?>

							<?php endwhile; ?>

							<div class="sixteen columns">
								<?php agility_content_nav( 'nav-below' , true ); ?>
							</div>

						</div>		
						<!-- end .mosaic -->
			<?php 
			$wp_query = $temp_query;
		endif;	

		if( $blog_query_id ){					
			$queryStruct->queryCompleted();
		}
		else{
			wp_reset_query(); 
		}

		$this->after();
	}


}
