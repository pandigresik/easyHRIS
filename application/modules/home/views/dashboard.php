<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="row top_tiles">          
    <?php 
        if(!empty($summaries)){
            foreach ($summaries as $key => $card) {
                echo $card;
            }
        }
    ?>
    </div>
</div>

