<?php

/*
 * Template Name: Archive
 */
get_header();

// Assign page post to avoid to override by other.
$page_post = $post;

?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12 archieveList">
        <h1><?php echo $post->post_title; ?></h1>
        
          <div class="col-xs-6">
        <?php 
            /*
             * Get all posts.
             */
             $args = array(
                 'post_type'    => array( 'post', 'blog', 'tutorials' ),
                 'post_status'  => 'publish',
                 'posts_per_page'=> -1,
                 'orderby'      => 'post_modified',
                 'order'        => 'ASC'
             );
             
             $posts = get_posts( $args );
             $posts_count = count( $posts );
             
             if( $posts_count > 0 ) :
                 
                 $posts_arr = array();
                 
                 foreach( $posts as $k => $post ) :
                     
                     $index = date("Ym", strtotime( $post->post_date ));
                     $posts_arr[$index][] = $post;
                     /*if( $prev != $index ) :
                         // New one.
                         $prev = $index;
                         
                         
                     endif;
                     */
                     
                 endforeach;
                 
                 ksort( $posts_arr );
                 $posts_arr_count = count( $posts_arr );
                 $posts_arr_half_count = ceil( count( $posts_arr ) / 2 );
                 $count = 0;
                 foreach( $posts_arr as $k => $posts ) :
                     if( $count == $posts_arr_half_count  ) :
                     ?>
                            </div>
                            <div class="col-xs-6">
                       <?php
                        endif;
                       ?>         
                            <div>
                             <h3><?php echo date("F Y", strtotime( $posts[0]->post_date ) ); ?></h3>
                              <ul>
                                  <?php
                                        foreach( $posts as $p => $post ) :
                                            $comment_count = get_comment_count( $post->ID );
                                            ?>
                                               <li>
                                                <div class="titleList"><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a> <span><i class="fa fa-chevron-down"></i></span></div>
                                                <div class="detailView">
                                                  <table>
                                                    <tbody>
                                                      <tr>
                                                        <td>Posted On</td>
                                                        <td><?php echo date( "d M'y", strtotime( $post->post_date ) ); ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td>Comments</td>
                                                        <td><?php echo $comment_count['approved']; ?></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </li> 
                                            <?php
                                        endforeach;
                                  ?>
                              </ul>
                            </div>
                     <?php
                     ++$count;
                     
                 endforeach;
                
                 else:
                    echo 'No Archives found!';
                endif;
            ?>
        </div>    
      </div>
    </div>
    <?php
        /*
         * Display Sidebar
         */
        get_sidebar();
    ?>
  </div>
</div>

<?php 
get_footer();

