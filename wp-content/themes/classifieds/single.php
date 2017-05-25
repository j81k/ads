<?php

/**
* Author		: Jai K
* Purpose		: single
* Created On 	: 2017-05-10 19:30
*/

$author = get_userdata($post->post_author);
$author_meta = get_user_meta($author->ID);
//echo '<pre>D:'; print_r( $author ); die;

get_header();
?>
    <section id="main-content" class="parallel" data-width="60">
        <div id="single-content">
            <div class="page-title break-line">
                <h1><?php echo get_the_title(); ?></h1>
                <div class="sub-text"><?php echo ucfirst( $author->display_name ); ?> | <?php echo date("d M, Y", strtotime($post->post_date)); ?></div>
            </div>
            <div class="page-content">
                
                <div class="block slider-wrapper" >
                    <div class="slider">
                        <img src="http://127.0.0.1/_self/_works/web-design/assets/images/icon.png" alt="Image 01" />
                        <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" alt="Image 01" />
                        <img src="http://127.0.0.1/_self/_works/web-design/assets/images/icon.png" alt="Image 03" />
                        <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" alt="Image 01" />
                        <div class="controls">
                            <i class="fa fa-fast-backward"></i>
                            <i class="fa fa-chevron-left"></i>
                            <i class="fa fa-pause"></i>
                            <i class="fa fa-chevron-right"></i>
                            <i class="fa fa-fast-forward"></i>
                            <span class="count">&nbsp;</span>
                        </div>
                    </div>
                    
                </div>
                
                <div id="details">
                    <div>
                        <span>Location</span><span>: Chennai, India</span>
                    </div>
                    <div>
                        <span>Age</span><span>: 27</span>
                    </div>
                    <div>
                        <span>Gender</span><span>: Male</span>
                    </div>
                    <div>
                        <span>Tags</span><span>: Services, Massage</span>
                    </div>
                    
                    <div>
                        <?php echo wpautop(apply_filters('the_content', $post->post_content)); ?>
                    </div>
                    
                    <div id="contact-info">
                        <button class="show-contacts-btn"><i class="fa fa-phone-square"></i> Show Contact Details</button>
                        <div class="show-contacts-details none">
                            <div>
                                <span>Contact No</span><span>: +91 95660 41710</span>
                            </div>
                            <div>
                                <span>Email ID</span><span>: j81k@outlook.com</span>
                            </div>
                        </div>     
                    </div>
                    
                    <div id="social-info">
                        <div>
                            <span><a href=""><i class="fa fa-twitter-square"></i> Twitter</a></span>
                        </div>
                        <div>
                            <span><a href=""><i class="fa fa-facebook-square"></i> Facebook</a></span>
                        </div>
                        <div>
                            <span><i class="fa fa-eye"></i> Views: 120</span>
                        </div>
                    </div>
                    
                    <div id="forms">
                        <div class="tabs">
                            <div class="tab-header">
                                <div data-target="#tab-1" class="active">Contact</div>
                                <div data-target="#tab-2">Comments</div>
                            </div>    
                            <div class="tab" id="tab-1">
                                
                                <form name="contact-form" method="post" enctype="multipart/form-data">
                    
                                    <div class="form-row">
                                        <label for="name">Name</label>
                                        <div>
                                            <input type="text" class="input-box" name="name" id="name" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <label for="email">Email</label>
                                        <div>
                                            <input type="text" class="input-box" name="email" id="email" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <label for="contact-no">Contact No</label>
                                        <div>
                                            <input type="text" class="input-box" name="contact-no" id="contact-no" placeholder="(Optional)" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <label for="msg">Message</label>
                                        <div>
                                            <textarea name="msg" id="msg" rows="5" maxlength="600" placeholder="Your message ..."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="controls">
                                            <input type="submit" class="btn active" name="contact" value="Submit" />
                                            <input type="reset" class="btn" name="reset" value="Clear" />
                                        </div>
                                    </div>

                                </form>    
                                
                                
                            </div>
                            
                            <!-- Comments -->
                            <div class="tab" id="tab-2">
                                <div id="comments">
                                    <nav>
                                        <ul>
                                            <li>
                                                <div>
                                                    <i class="fa fa-chevron-down info-opener"></i>
                                                    <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" alt="John" />
                                                    <div class="content">
                                                        <p>This is all about something and can not understand!!! This is all about somethin This is all about somethinThis is all about somethinThis is all about somethinThis is all about somethinThis is all about somethinThis is all about somethin This is all about somethinThis is all about somethin This is all about somethin</p>
                                                        <div class="more-info">
                                                            <small><a href=""><i class="fa fa-user"></i> John Abraham</a></small>
                                                            <small>20 Jun, 2015</small>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <ul class="none">
                                                    <li>
                                                        <div>
                                                            <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" alt="John" />
                                                            <div class="content">
                                                                <p>This is all about something and can not understand!!!</p>
                                                                <div class="more-info">
                                                                    <small><a href="#comment-form">Reply</a></small>
                                                                    <small><a href=""><i class="fa fa-user"></i> John Abraham</a></small>
                                                                    <small>21 Jun, 2015</small>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                    </li>    
                                                    <li>
                                                        <div>
                                                            <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" alt="John" />
                                                            <div class="content">
                                                                <p>This is all about something and can not understand!!!</p>
                                                                <div class="more-info">
                                                                    <small><a href=""><i class="fa fa-user"></i> John Abraham</a></small>
                                                                    <small>21 Jun, 2015</small>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div>
                                                                    <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" alt="John" />
                                                                    <div class="content">
                                                                        <p>This is all about something and can not understand!!! This is all about something and can not understand!!! This is all about something and can not understand!!!This is all about something and can not understand!!!</p>
                                                                        <div class="more-info">
                                                                            <small><a href=""><i class="fa fa-user"></i> John Abraham</a></small>
                                                                            <small>02 Nov, 2015</small>
                                                                        </div>
                                                                    </div>    
                                                                </div>
                                                                <ul>

                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                        </ul>
                                    </nav>    
                                    
                                </div>
                                <form name="comment-form" id="comment-form" method="post" enctype="multipart/form-data">
                    
                                    <div class="form-row">
                                        <label for="name">Name</label>
                                        <div>
                                            <input type="text" class="input-box" name="name" id="name" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <label for="email">Email</label>
                                        <div>
                                            <input type="text" class="input-box" name="email" id="email" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <label for="comment">Comment</label>
                                        <div>
                                            <textarea name="comment" id="comment" rows="5" maxlength="600" placeholder="Say something ..."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="controls">
                                            <input type="submit" class="btn active" name="comment" value="Comment" />
                                            <input type="reset" class="btn" name="reset" value="Clear" />
                                        </div>
                                    </div>

                                </form>    
                                
                                
                            </div>
                        </div>
                    </div>    <!-- forms -->
                                
                                
                                
                            
                            
                        
                    
                    
                    
                </div>
            </div>
        </div>
        
    </section>

<?php

get_footer();