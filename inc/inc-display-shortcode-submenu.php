<?php $uid = 'submenu-' . rand ( 0 , 100000 ); ?>

<div id="<?php echo $uid;?>" class="cwp-submenu-wrapper menu-<?php echo $instance['menu'];?>">

	<nav class="cwp-submenu-section" style="float:right; width: 200px;">
    	<h3><?php echo $instance['title']; ?></h3>
    	<ul>
    	<?php foreach ( $menu as $index => $menu_item ):?>
            <li<?php if ( 0 == $index ) echo ' class="active-article"';?> >
                <a href="<?php echo $menu_item->url; ?>" data-link="<?php echo $menu_item->url; ?>" >
                    <?php echo $menu_item->title; ?>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
	</nav>
    
	<div class="cwp-submenu-section" style="margin-right: 210px;">
		
		<?php foreach ( $menu as $index => $menu_item ) {
        
        	if ( isset( $menu_item->object_id ) ) {
			
				$c_post = get_post( $menu_item->object_id );
			
				if ( $c_post ) {
					
					$active = ( 0 == $index )? 'block' : 'none';
					
					echo '<article class="submenu-article" style="display:' . $active . '">';
					
					echo '<h2 class="article-title">' . apply_filters( 'the_title', $c_post->post_title ) . '</h2>';
					
					echo apply_filters( 'the_content', $c_post->post_content );
					
					echo '</article>';
				
				}; // end if
		
			}; // end if
        
		};?> 
	</div>
	
</div>

<script type="text/javascript">

if ( typeof jQuery !== 'undefined' ) {
	
	if ( typeof cwp_submenu === 'undefined' ){
		
		function cwp_submenu( menu_id ){
			
			this.submenu = jQuery('#' + menu_id );
			
			this.content = this.submenu.children('.cwp-submenu-section');
			
			this.articles = this.content.children('article');
			
			var self = this;
			
			self.submenu.on( 'click', '.cwp-submenu-section a', function( event ){
				
				event.preventDefault();
				
				var index = jQuery( this ).parent('li').index();
				
				self.articles.eq( index ).show().siblings().hide();
				
			}); // end on click
			
		}; // end cwp_submenu
		
	}; // end if
	
	window[ 'submenu_<?php echo $uid;?>'] = new cwp_submenu( '<?php echo $uid;?>' ); 
	
}; // end if

</script>