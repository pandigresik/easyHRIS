<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 table-responsive">
            <?php echo $table; ?>
        </div>
        
        <div class="modal right fade" id="searchModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="width:60%">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel2">Filter</h4>
                    </div>            
                    <div class="modal-body">
                    <?php echo isset($filterModal) ? $filterModal : ''; ?>
                    </div>
                </div>
            </div>
        </div>            
</div>    



