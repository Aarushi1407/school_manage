<div class="modal-dialog modal-small">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Test Message</h4>
            <button type="button" id="btn_close_2" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.whatsApp.template.detail.test.message.send') }}" method="post" class="add_form" button-click="btn_contact,btn_close_2" content-refresh="example">
                {{ csrf_field() }}
                <input type="hidden" name="para" value="{{$para}}">
                <div class="box-body">
                    <div class="form-group">
                        <label>Mobile No.</label>
                        <input type="text" name="mobile_no" maxlength="10" class="form-control" placeholder="Enter Mobile No."> 
                    </div>
                </div>
                <div class="modal-footer card-footer justify-content-between">
                    <button type="submit" class="btn btn-success form-control">Test Messages Send</button>
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

