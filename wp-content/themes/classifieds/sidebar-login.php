<?php

/* 
 * Author       : Jai K
 * Document     : Sidebar (Login)
 * Created On   : 2017-05-07 17:55
 */
?>

        <div id="login-content">
            <div class="page-title break-line">
                <h1>Login</h1>
            </div>
            <div class="page-content">
                <form method="post" enctype="multipart/form-data">
                    <div  id="login-form">
                        <div class="form-row">
                            <input type="text" class="input-box" name="email" id="login-email" placeholder="Email address" autofocus />
                        </div>

                        <div class="form-row">
                            <input type="password" class="input-box" name="pass" id="login-pass" placeholder="Password" />
                        </div>

                        <div class="form-row">
                            <div class="fN">
                                <div class="chk-box">
                                    <input type="checkbox" name="login-remember" id="login-remember" />
                                    <label for="login-remember" >  Remember me</label>
                                </div>
                            </div>    
                        </div>

                        
                    </div>
                    
                    <!-- Register Form -->
                    <div  id="reg-form" class="none">
                        <div class="form-row">
                            <input type="text" class="input-box" name="name" id="reg-name" placeholder="Name" autofocus />
                        </div>
                        
                        <div class="form-row">
                            <input type="text" class="input-box" name="email" id="reg-email" placeholder="Email address" autofocus />
                        </div>

                        <div class="form-row">
                            <input type="password" class="input-box" name="pass1" id="reg-pass1" placeholder="Password" />
                        </div>

                        <div class="form-row">
                            <input type="password" class="input-box" name="pass2" id="reg-pass2" placeholder="Confirm password" />
                        </div>
                        
                        
                    </div>
                    
                    <div class="form-row">
                        <div class="controls">
                            <input type="submit" class="btn active" name="login" value="Login" />
                            <input type="reset" class="btn" name="reset" value="Clear" />
                            <input type="submit" class="btn" name="reg"  value="Register" />
                        </div>
                    </div>
                    
                 </form>
            </div>
        </div>
        
    