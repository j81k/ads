<?php

/* 
 * Template Name: Profile
 * Author       : Jai K
 * Created On   : 2017-05-07 17:05
 */

get_header();
?>
    <section class="parallel">
        <div id="profile-content" class="no-sidebar">
            <div class="page-title break-line">
                <h1>My Account</h1>
            </div>
            <div class="page-content">
                <form method="post" enctype="multipart/form-data">
                    <div class="tabs">
                        <div class="tab-header">
                            <div data-target="#tab-1"><i class="fa fa-user fL"></i> Profile</div>
                            <div data-target="#tab-2"  class="active"><i class="fa fa-newspaper-o fL"></i> My ADs</div>
                            <div data-target="#tab-3"><i class="fa fa-wrench fL"></i> Settings</div>
                            <div data-target="#tab-4"><i class="fa fa-key fL"></i> Password</div>
                        </div>    
                        
                        <div class="tab list win-height" id="tab-1">
                
                            <div class="col-xs-12">
                                <div class="col-xs-4">
                                    <div id="profile-photo">
                                        <img src="../uploads/profile/photo.jpg" />
                                    </div>
                                </div>
                                <div class="col-xs-8" id="main-details">
                                    <div class="form-row">
                                        <div>
                                            <input type="text" class="input-box" name="name" id="name" placeholder="Name" />
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div>
                                            <input type="text" class="input-box" name="email" id="email" placeholder="Email address" value="jai@sourceplate.com" readonly />
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div>
                                            <input type="text" class="input-box" name="contact-no" id="contact-no" placeholder="Contact No" value=""  />
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="form-row">
                                <label for="gender">Gender</label>
                                <div>
                                    <select class="select-box" name="gender" id="gender" >
                                        <option value="1" selected >Male</option>
                                        <option value="0">Female</option>
                                        <option value="2">Transgend</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="dob">Date of birth</label>
                                <div class="col-xs-12">
                                    <div class="col-xs-4">
                                        <select class="select-box" name="dob-day" id="dob-day" >
                                            <option value="1">01</option>
                                            <option value="2">02</option>
                                            <option value="31">31</option>
                                        </select>
                                    </div>    
                                    <div class="col-xs-4">
                                        <select class="select-box" name="dob-month" id="dob-month" >
                                            <option value="1">Jan</option>
                                            <option value="2">Feb</option>
                                            <option value="3">Mar</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select class="select-box" name="dob-year" id="dob-year" >
                                            <option value="1989">1989</option>
                                            <option value="2000">2000</option>
                                            <option value="2007">2007</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="state">State</label>
                                <div>
                                    <select class="select-box" name="state" id="state" >
                                        <option value="">-- Select the state --</option>
                                        <option value="andra-pradesh">Andra Pradesh</option>
                                        <option value="kerala">Kerala</option>
                                        <option value="tamil-nadu" selected>Tamil Nadu</option>
                                        <option value="karnataka">Karnataka</option>
                                        <option value="gujarat">Gujarat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="city">City</label>
                                <div>
                                    <select class="select-box" name="city" id="city" >
                                        <option value="">-- Select the city --</option>
                                        <option value="chennai">Chennai</option>
                                        <option value="tuticorin">Tuticorin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="desc">Description</label>
                                <div>
                                    <textarea name="desc" id="desc" rows="5" maxlength="600" placeholder="Something about you."></textarea>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <label for="url">Website URL</label>
                                <div>
                                    <input type="text" class="input-box" name="url" id="url" placeholder="http://www.example.com" value=""  />
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <input type="submit" class="btn active" name="profile" value="Update" />
                            </div>
                        </div> <!-- Tab 1 -->
                        
                        <div class="tab list win-height" id="tab-2">
                            <div class="list results">

                                <div class="block">
                                    <div class="img">
                                        <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" />
                                    </div>
                                    <i class="fa fa-chevron-up active info-opener" title="Show/Hide Options"> Ad ID: AS5345120</i>
                                    <div class="content">
                                        <h4><a href="http://127.0.0.1/_self/_works/web-design/category/services/sub-services/hi-im-here/">Hi.. I'm here!</a></h4>

                                        <p>Content! This is all about the Content.. This is all about the Content. out the Contentvout the Contentout the Content</p>
                                        <div class="content-info">
                                            <span><b>Status:</b> Waiting to approve</span>
                                            <span class="fR"><b>Category:</b> Personal | meeting</span>
                                        </div>
                                    </div>
                                    <div class="caption">19 May, 2015</div>
                                    <div class="info">
                                        <a href="./publish.shtml?type=edit&id=12" class="fL"><i class="fa fa-pencil"></i> Edit</a>
                                        <a href="./publish.shtml?type=preview&id=12" class="fL"><i class="fa fa-lightbulb-o"></i> Preview</a>
                                        <a href="./profile.shtml?type=delete&id=12" class="fL"><i class="fa fa-times"></i> Remove</a>

                                        <span><i class="fa fa-eye"></i> Views: 120</span>
                                        <span><i class="fa fa-envelope"></i> Mail: 60</span> 
                                        <span><i class="fa fa-mouse-pointer"></i> Contacts Clicked: 78</span>

                                    </div>
                                </div>
                                                
                            </div> <!-- list -->
                                            
                        </div> <!-- Tab 2 -->
                        
                        <div class="tab list win-height" id="tab-3"> 
                            
                            <div class="form-row">
                                <div class="chk-box  full-width">
                                    <input type="checkbox" name="rm-account" id="rm-account" />
                                    <label for="rm-account" >  Delete my account <span class="sub-text">(Can not be recovered!)</span></label>
                                </div>
    
                            </div>
                            
                            <div class="form-row">
                                <input type="submit" class="btn active" name="settings" value="Update" />
                            </div>
                            
                        </div> <!-- Tab 3 -->
                        
                        <div class="tab list win-height" id="tab-4"> 
                            <div id="profile-pass-wrap">
                                <div class="form-row">
                                    
                                    
                                        <input type="password" class="input-box" name="pass" id="pass" placeholder="Current Password" />
                                    
                                </div>

                                <div class="form-row">
                                    
                                    
                                        <input type="password" class="input-box" name="pass1" id="pass1" placeholder="New Password" />
                                    
                                </div>

                                <div class="form-row">
                                    <input type="password" class="input-box" name="pass2" id="pass2" placeholder="Confirm Password" />
                                    
                                </div>
                                
                                <div class="form-row">
                                    <input type="submit" class="btn active" name="change-pass" value="Update" />
                                </div>
                            </div>
                        </div> <!-- Tab 4 -->
                        
                    </div> <!-- Tabs -->    
                </form>
            </div>
        </div>
        
    </section>
<?php
get_footer();
