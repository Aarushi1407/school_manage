<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Contact Details</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card card-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-info btn-sm"  onclick="callPopupLevel2(this,'{{ route('admin.master.school.contact.addform', Crypt::encrypt( (0 . ':' . $mst_school_id) )) }}')"><i class="fa fa-plus"></i> Add Contact Person</button>
                        </div>
                        <div class="col-lg-12">
                            <fieldset class="fieldset_border">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover" id="popup_data_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Sr.No.</th>                
                                                <th>Action</th>
                                                <th>Contact Person Name</th>
                                                <th>Designation</th>
                                                <th>Mobile No.</th>
                                                <th>Email ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sr_no = 1;
                                            @endphp
                                            @foreach($rs_records as $value)
                                            <tr>
                                                <td>{{ $sr_no++ }}</td>
                                                <td class="text-nowrap">
                                                    <button type="button" class="btn btn-info btn-xs rounded-circle shadow-sm" onclick="callPopupLevel2(this,'{{ route('admin.master.school.contact.addform', Crypt::encrypt( ($value->id . ':' . $mst_school_id) )) }}')"><i class="fa fa-edit"></i></button>

                                                    <button type="button" class="btn btn-danger btn-xs rounded-circle shadow-sm" title="Delete" success-popup="true" button-click="btn_contact" onclick="if(confirm('Are you sure to delete?')){callAjax(this,'{{ route('admin.master.school.contact.delete', Crypt::encrypt($value->id)) }}')}"><i class="fa fa-trash"></i></button>

                                                </td>
                                                <td class="text-nowrap"><strong><i class="fa fa-user-circle me-1 text-info"></i> {{ $value->contact_person_name }}</strong></td>
                                                <td class="text-nowrap">{{ $value->designation }}</td>
                                                <td class="text-nowrap"><strong><i class="fa fa-phone me-1 text-success"></i> {{ $value->mobile_no }}</strong></td>
                                                <td class="text-nowrap"><strong><i class="fa fa-envelope me-1 text-danger"></i> {{ $value->email_id }}</strong></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>                
                </div>
            </div>
            
        </div>
    </div>
</div>

