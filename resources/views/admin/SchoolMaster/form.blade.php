<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.school.list.store',Crypt::encrypt(@$id)) }}" method="post" class="add_form" button-click="btn_close" content-refresh="example">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>School Name</label>
                            <input type="text" name="school_name" value="{{ @$rs_record->school_name }}" maxlength="100" class="form-control" placeholder="Enter School Name"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>State</label>
                            <input type="text" name="state_name" value="{{ @$rs_record->state_name }}" maxlength="50" class="form-control" placeholder="Enter State"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>City</label>
                            <input type="text" name="city_name" value="{{ @$rs_record->city_name }}" maxlength="50" class="form-control" placeholder="Enter City"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Address 1</label>
                            <input type="text" name="address_1" value="{{ @$rs_record->address_1 }}" maxlength="100" class="form-control" placeholder="Enter address 1"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Address 2</label>
                            <input type="text" name="address_2" value="{{ @$rs_record->address_2 }}" maxlength="100" class="form-control" placeholder="Enter address 2"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Pincode</label>
                            <input type="text" name="pin_code" value="{{ @$rs_record->pin_code }}" maxlength="6" class="form-control" placeholder="Enter pincode"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Mobile No.</label>
                            <input type="text" name="mobile_no" value="{{ @$rs_record->mobile_no }}" maxlength="10" class="form-control" placeholder="Enter Mobile No."> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Email</label>
                            <input type="text" name="email" value="{{ @$rs_record->email_id }}" maxlength="100" class="form-control" placeholder="Enter email"> 
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

