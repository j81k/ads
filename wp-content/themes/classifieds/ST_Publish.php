<?php

/* 
 * Template Name: Publish
 * Author       : Jai K
 * Created On   : 2017-05-07 17:04
 */

get_header();
?>
    <section id="main-content" class="parallel" data-width="60">
        <div id="publish-content">
            <div class="page-title break-line">
                <h1>Post Your Free Ad</h1>
            </div>
            <div class="page-content">
                <form method="post" enctype="multipart/form-data">
                    
                    <div class="form-row">
                        <label for="post-title">Title</label>
                        <div>
                            <input type="text" class="input-box" name="post-title" id="post-title" autofocus />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <label for="main-cat">Main Category</label>
                        <div>
                            <select class="select-box" name="main-cat" id="main-cat">
                                <option value="">-- Select an Option --</option>
                                <option value="services">Services</option>
                                <option value="personals">Personals</option>
                                <option value="Jobs">Jobs</option>
                                <option value="Buy">Buy</option>
                                <option value="Sell">Sell</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <label for="sub-cat">Sub Category</label>
                        <div>
                            <select class="select-box" name="sub-cat" id="sub-cat">
                                <option value="">-- Select an Option --</option>
                                <option value="services">Services</option>
                                <option value="personals">Personals</option>
                                <option value="Jobs">Jobs</option>
                                <option value="Buy">Buy</option>
                                <option value="Sell">Sell</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <label for="state">State</label>
                        <div>
                            <select class="select-box state" name="state" id="state" data-trigger="#city">
                                <?php echo get_states(TRUE); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <label for="city">City</label>
                        <div>
                            <select class="select-box city" name="city" id="city">
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <label for="desc">Description</label>
                        <div>
                            <textarea name="desc" id="desc" rows="5" maxlength="600" placeholder="Explain something about your Ad."></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <label for="file-1">File/Image</label>
                        <div>
                            <div id="file-1"><input type="file" name="file[]" /><i id="add-file-icon" class="fa fa-plus-circle control-icon"></i></div>
                        </div>
                    </div>
                    
                    <div id="personal-info">
                        <div class="sub-title break-line">
                            <h4>Personal Info</h4>
                        </div>

                        <div class="form-row">
                            <label for="email">Email</label>
                            <div>
                                <input type="text" class="input-box email" name="email" id="email" />
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="contact-no">Contact No</label>
                            <div>
                                <input type="text" class="input-box number" name="contact-no" id="contact-no" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <label for="password">Password</label>
                            <div>
                                <input type="password" class="input-box" name="password" id="password" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div>
                                <div class="chk-box">
                                    <input type="checkbox" name="i-agree" id="i-agree" />
                                    <label for="i-agree" >  I agree the terms and conditions</label>
                                </div>
                                
                            </div>    
                        </div>
                        
                        <div class="form-row">
                            <div class="controls">
                                <input type="submit" class="btn active" name="submit" value="Publish" />
                                <input type="reset" class="btn" name="reset" value="Clear" />
                            </div>
                        </div>

                        
                        
                    </div>
                    
                </form>
            </div>
        </div>
        
    </section>

<?php
    //get_sidebar();
    
get_footer();
