<?php

/**
* Author        : Jai K
* Purpose       : Side bar file
* Created On    : 2017-05-06 23:55
*/
?>
<aside id="sidebar" class="parallel win-height"  data-width="40">
                        
    <article id="ads">
        <!-- Ads -->
        <?php get_sidebar('login'); ?>

    </article>
    <article>
        <div id="sample-posts" class="tabs">
            <div class="tab-header">
                <div data-target="#tab-1" data-type="recent" class="active">Recent</div>
                <div data-target="#tab-2" data-type="hot">Hot</div>
                <div data-target="#tab-3" data-type="recommend">Recommends</div>
            </div>    
            
            <!-- .tab-1 -->
            <div class="tab list win-height" data-max-height="50" id="tab-1"> </div>
            <!-- .tab-2 -->
            <div class="tab list win-height" data-max-height="50" id="tab-2"> </div>
            <!-- .tab-3 -->
            <div class="tab list win-height" data-max-height="50" id="tab-3"> </div>

        </div>

    </article>

</aside>