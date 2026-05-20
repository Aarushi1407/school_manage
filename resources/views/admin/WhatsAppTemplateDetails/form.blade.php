<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.whatsApp.template.detail.store',Crypt::encrypt(@$id)) }}" method="post" class="add_form" button-click="btn_close" content-refresh="example" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Template Name</label>
                        <input type="text" name="template_name" value="{{ @$rs_record->template_name }}" maxlength="100" class="form-control" required> 
                    </div>
                    
                    <div class="form-group">
                        <label>Language</label>
                        <select name="language" class="form-control" required>
                            <option value="en" {{ @$rs_record->language == 'en' ? 'selected' : '' }}>en</option>
                            <option value="en_US" {{ @$rs_record->language == 'en_US' ? 'selected' : '' }}>en_US</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Media Type</label>
                        <select name="media_type" class="form-control" required>
                            <option value="1" {{ @$rs_record->media_type == 1 ? 'selected' : '' }}>Image</option>
                            <option value="2" {{ @$rs_record->media_type == 2 ? 'selected' : '' }}>PDF</option>
                            <option value="3" {{ @$rs_record->media_type == 3 ? 'selected' : '' }}>Video</option>
                            <option value="4" {{ @$rs_record->media_type == 4 ? 'selected' : '' }}>Document</option>
                        </select>
                    </div>              
                    
                    <div class="form-group">
                        <label>Choose File (PDF, Image, or Video) - (40 MB):</label>
                        <input type="file" name="media_file" id="media_file" class="form-control" accept="application/pdf,image/*,video/mp4" {{ @$id>0 ? '' : 'required' }}>
                        @if(@$id>0)
                            @if(!empty(@$rs_record->file_path))
                                <a href="{{ route('admin.whatsApp.template.detail.view_file', Crypt::encrypt(@$rs_record->id)) }}" target="_blank">
                                    <i class="fa fa-eye"></i> View File
                                </a>
                            @endif
                        @endif
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