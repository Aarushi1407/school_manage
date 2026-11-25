<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.dictionary.verify.save', Crypt::encrypt(@$id)) }}" method="post" class="add_form" button-click="btn_close,btn_show_dictionary">
                {{ csrf_field() }}
                <div class="box-body"> 
                    <div class="form-group">
                        <label>Name (English)</label>
                        <input type="text" name="name_e" class="form-control" maxlength="100" value="{{@$rs_records->name_e}}">                        
                    </div>
                    <div class="form-group">
                        <label>Name (Hindi)</label>
                        <input type="text" name="name_l" class="form-control" maxlength="100" value="{{@$rs_records->name_l}}">                        
                    </div>
                                  
                </div>

                <div class="modal-footer card-footer justify-content-between">
                    <button type="submit" class="btn btn-success form-control">Update</button>
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

