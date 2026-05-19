<div class="modal-dialog modal-small">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close_2" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.school.contact.store', $para) }}" method="post" class="add_form" button-click="btn_contact,btn_close_2" content-refresh="example">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Contact Person Name</label>
                            <input type="text" name="contact_person_name" value="{{@$rs_records[0]->contact_person_name}}" maxlength="50" class="form-control" placeholder="Enter Contact Person Name"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Designation</label>
                            <input type="text" name="designation" value="{{@$rs_records[0]->designation}}" maxlength="50" class="form-control" placeholder="Enter State"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Mobile No.</label>
                            <input type="text" name="mobile_no" value="{{@$rs_records[0]->mobile_no}}" maxlength="10" class="form-control" placeholder="Enter Mobile No."> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Email</label>
                            <input type="text" name="email" value="{{@$rs_records[0]->email_id}}" maxlength="100" class="form-control" placeholder="Enter email"> 
                        </div>
                    </div> 
                </div>
                <div class="modal-footer card-footer justify-content-between">
                    <button type="submit" class="btn btn-success form-control">{{ @$id>0? 'Update' : 'Submit' }}</button>
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

