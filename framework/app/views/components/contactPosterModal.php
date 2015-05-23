<div id="contactPosterModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalHeader">Contact the pet owner</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="contactPosterModalNameField" class="control-label">Recipient:</label>
                                    <input id="contactPosterModalNameField" class="form-control" type="text" placeholder="Recipient" disabled>                                    
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="row top-20">
                                <div class="col-sm-6">
                                    <label for="contactPosterModalMessageField" class="control-label">Message:</label>
                                    <textarea id="contactPosterModalMessageField" rows="8" placeholder="Message" data-placement="top"  class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="contactPosterModalMessageNotification"></div>
                <button id="contactPosterModalCloseButton" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="contactPosterModalSubmitButton" type="button" class="btn btn-primary">Send Message</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
