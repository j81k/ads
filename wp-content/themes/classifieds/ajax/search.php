<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$data = $_POST['data'];
?>
<div id="advanced-search" class="none" >
    <div class="col-xs-12">
        <div class="col-xs-6">
            <select class="select-box" name="state" id="state">
                <option value="">-- Select State --</option>
                <option value="andra-pradesh">Andra Pradesh</option>
                <option value="kerala">Kerala</option>
                <option value="tamil-nadu">Tamil Nadu</option>
                <option value="karnataka">Karnataka</option>
                <option value="gujarat">Gujarat</option>
            </select>
        </div>
        <div class="col-xs-6">
            <select class="select-box" name="city" id="city">
                <option value="">-- Select City --</option>
                <option value="chennai">Chennai</option>
                <option value="madurai">Madurai</option>
                <option value="tamil-nadu">Tamil Nadu</option>
                <option value="karnataka">Karnataka</option>
                <option value="gujarat">Gujarat</option>
            </select>
        </div>
    </div>
    
    <div class="col-xs-12">
        <div class="col-xs-6">
            <input type="text" class="input-box datepicker past today" data-target="#advanced-search #by-to-date" name="by-from-date" id="by-from-date" placeholder="From Date" />
        </div>
        <div class="col-xs-6">
            <input type="text" class="input-box datepicker past today" name="by-to-date" id="by-to-date" placeholder="To Date" />
        </div>
        
    </div>
    
    <div class="col-xs-12 break-line-solid">
        <div class="col-xs-3">
            <div class="text-middle">
                <label>Posted by</label> 
            </div>
        </div> 
        <div class="col-xs-3">
            <select class="select-box" name="gender" id="gender">
                <option value="" selected>-- All --</option>
                <option value="1">Male</option>
                <option value="0">Female</option>
                <option value="2">Transgend</option>
            </select>    
        </div>
        <div class="col-xs-2" >
            <div class="rLbl">
                <label>Age</label> 
            </div>
        </div> 
        <div class="col-xs-2">
            <select class="select-box" name="age-min" id="age-min">
                <option value="">-- Min --</option>
                <?php
                    for( $i = 14; $i < 60; $i++ ) :
                        echo '<option value='. $i .'>'. $i .'</option>';
                    endfor;
                ?>
            </select>
        </div>
        <div class="col-xs-2">
            <select class="select-box" name="age-max" id="age-max">
                <option value="">-- Max --</option>
                <?php
                    for( $i = 14; $i < 60; $i++ ) :
                        echo '<option value='. $i .'>'. $i .'</option>';
                    endfor;
                ?>
            </select>
        </div>
    </div>
    
    <!-- Extra -->
    <div id="extra-options" class="break-line">
        <!-- Condition -->
        <div class="col-xs-12">
            <div class="col-xs-2 lbl">
                <div class="text-middle">
                    <label>Condition</label> 
                </div>
            </div> 
            <div class="col-xs-3">
                <select class="select-box" name="condition" id="condition">
                    <option value="" selected>-- All --</option>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                </select>    
            </div>
            <div class="col-xs-1 lbl min-wght" >
                <div class="rLbl">
                    <label>For</label> 
                </div>
            </div> 
            <div class="col-xs-2">
                <select class="select-box" name="looking-for" id="looking-for">
                    <option value="" selected>-- All --</option>
                    <option value="new">Rent</option>
                    <option value="sell">Sell</option>
                    <option value="buy">Buy</option>
                </select>
            </div>
            
        </div> <!-- Row -->
        
        
        <!-- Price -->
        <div class="col-xs-12">
            
                <div class="col-xs-2 lbl">
                    <div class="text-middle">
                        <label>Price (Rs) </label> 
                    </div>
                </div> 
                <div class="col-xs-1">
                    <input type="text" class="input-box number" name="price-from" id="price-from" placeholder="50" />
                </div>

                <div class="">
                    <div class="rLbl">
                        <label> &nbsp;to </label> 
                    </div>
                </div>
                <div class="col-xs-1">
                    <input type="text" class="input-box number" name="price-to" id="price-to" placeholder="1000" />
                </div>
            
            
            
                <div class="col-xs-2 lbl rght-sec" >
                    <div class="rLbl">
                        <label>Discount</label> 
                    </div>
                </div> 
                
                <div class="col-xs-3">
                    <div class="radio-box fR text-left" >
                        <input type="radio" name="discount-type" id="discount-type-per" />
                        <label for="discount-type-per" >  %</label>
                    </div>
                    
                    <div class="radio-box text-left">
                        <input type="radio" name="discount-type" id="discount-type-rs" />
                        <label for="discount-type-rs" >  Rs</label>
                    </div>
                </div> 
                
                
                
                <div class="col-xs-1 min-wdth">
                    <select class="select-box" name="discount-op" id="discount-op">
                        <option value="=" selected>&equals;</option>
                        <option value=">">&gt;</option>
                        <option value="<">&lt;</option>
                        <option value=">=">&gt;&equals;</option>
                        <option value="<=">&lt;&equals;</option>
                    </select>
                </div>
                
                <div class="col-xs-1 min-wdth">
                    <input type="text" class="input-box number discount" name="discount" placeholder="200" />
                    <select class="select-box discount" name="discount" >
                        <option value="">--</option>
                        <?php 
                            for( $i = 1; $i < 100; $i++ ) :
                                ?>
                                    <option value="<?php echo $i; ?>" <?php echo ( $i == 5 ) ? 'selected' : ''; ?> ><?php echo $i; ?></option>
                                <?php
                            endfor;
                        ?>
                    </select>
                </div>
        </div>
        
        
        
    </div> <!-- Extra -->
    
    <div class="col-xs-12">
        
        
        <div class="col-xs-6">
            <div class="col-xs-12">
                <div class="col-xs-4">
                    <div class="text-middle">
                        <label>Within (km) </label> 
                    </div>
                </div> 
                <div class="col-xs-2">
                    <input type="text" class="input-box number" name="within-km" id="within-km" placeholder="50" />
                </div>
                
                <div class="col-xs-4">
                    <div class="rLbl">
                        <label>Views <i class="fa fa-chevron-right"></i></label> 
                    </div>
                </div> 
                <div class="col-xs-2">
                    <input type="text" class="input-box number" name="views" id="views" placeholder="100" />
                </div>
            </div>
            
            <div class="chk-box">
                <input type="checkbox" name="with-photos" id="with-photos" />
                <label for="with-photos" >  With photos</label>
            </div>
            <div class="chk-box">
                <input type="checkbox" name="only-title" id="only-title" />
                <label for="only-title" >  Only title</label>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="controls">
                <input type="submit" class="col-xs-6 fR btn active" name="submit" value="Search" />
            </div>
        </div>
    </div>
    
    
    
</div>
<div class="list" id="search-results">
<?php


for( $i = 0; $i < strlen( $data['value'] ); $i++ ) :
    ?>
        <div class="block">
            <div class="img">
                <img src="http://127.0.0.1/_self/_works/web-design/assets/images/placeholder.jpg" />
            </div>
            <i class="fa fa-chevron-down info-opener" title="Show Contact No and other details"></i>
            <div class="content">
                <h4><a href="http://127.0.0.1/_self/_works/web-design/category/services/sub-services/hi-im-here/">Hi.. I'm here!</a></h4>
                <p>Content! This is all about the Content.. This is albout the Content.. This is al bout the Content.. This is al bout the Content.. This is bout the Content.. This is albout the Content.. This is albout the Content.. This is al about the Content.</p>
                <p>Content! This is all about the Content.. This is albout the Content.. This is al bout the Content.. This is al bout the Content.. This is bout the Content.. This is albout the Content.. This is albout the Content.. This is al about the Content.</p>
                <p>Content! This is all about the Content.. This is albout the Content.. This is al bout the Content.. This is al bout the Content.. This is bout the Content.. This is albout the Content.. This is albout the Content.. This is al   cabout the Content.</p>
                <p>Content! This is all about the Content.. This is albout the Content.. This is al bout the Content.. This is al bout the Content.. This is bout the Content.. This is albout the Content.. This is albout the Content.. This is al   c  about the Content.</p>

            </div>
            <div class="caption">19 May, 2015</div>
            <div class="info">
                <span class="author"><a href=""><i class="fa fa-user"></i> John Abraham</a></span>

                <!-- <span><a href=""><i class="fa fa-twitter-square"></i> Twitter</a></span>
                <span><a href=""><i class="fa fa-facebook-square"></i> Facebook</a></span> -->
                <span><i class="fa fa-eye"></i> Views: 120</span>

                <button class="show-contacts-btn fR"><i class="fa fa-phone-square"></i> Show Contacts</button>
                <div class="show-contacts-details fR none">
                    <span ><a href=""><i class="fa fa-mobile"></i> 9566041710</a></span>
                    <span ><a href=""><i class="fa fa-envelope"></i> j81k@outlook.com</a></span>
                </div>
            </div>
        </div>
    <?php
    
    
endfor;
    
$hidden_val = array(
    'total' => strlen( $data['value'] )
);

?>
    <input type="hidden" name="hidden-search" id="hidden-search" value='<?php echo json_encode( $hidden_val ); ?>'>
    </div>
