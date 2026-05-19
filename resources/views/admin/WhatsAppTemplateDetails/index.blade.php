@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>WhatsApp Template Details</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-info btn-sm" onclick="callPopupLarge(this,'{{ route('admin.whatsApp.template.detail.addform', Crypt::encrypt(0)) }}')"><i class="fa fa-plus"></i> Add Template</button>
                </ol>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <fieldset class="fieldset_border">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="example">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Sr.No.</th>                
                                        <th>Action</th>
                                        <th>Template Name</th>
                                        <th>Language</th>
                                        <th>Media Type</th>
                                        <th>Attachment</th>
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
                                            <button type="button" class="btn btn-info btn-sm" onclick="callPopupLarge(this,'{{ route('admin.whatsApp.template.detail.addform',Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>
                                            
                                            <a type="button" href="{{ route('admin.whatsApp.template.detail.delete',Crypt::encrypt($value->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>

                                            <button type="button" class="btn btn-primary btn-sm" onclick="callPopupLarge(this,'{{ route('admin.whatsApp.template.detail.test.message',Crypt::encrypt($value->id)) }}')"><i class="fa fa-send-o"></i> Test Message</button>
                                        </td>
                                        <td>{{ $value->template_name }}</td>
                                        
                                        <td>{{ $value->language }}</td>
                                        
                                        <td>
                                            @if($value->media_type == 1) 
                                                <span class="badge badge-info">Image</span>
                                            @elseif($value->media_type == 2) 
                                                <span class="badge badge-danger">PDF</span>
                                            @elseif($value->media_type == 3) 
                                                <span class="badge badge-warning">Video</span>
                                            @elseif($value->media_type == 4) 
                                                <span class="badge badge-secondary">Document</span>
                                            @else 
                                                <span class="badge badge-dark">Unknown</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            @if(!empty($value->file_path))
                                                <a href="{{ route('admin.whatsApp.template.detail.view_file', Crypt::encrypt($value->id)) }}" target="_blank" class="btn btn-success btn-sm">
                                                    <i class="fa fa-eye"></i> View File
                                                </a>
                                            @else
                                                <span class="text-muted">No File Attached</span>
                                            @endif
                                        </td>
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
</section>
@endsection
@push('scripts')
<script>
    $(function () {
        $("#example").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["excel", "colvis"]
        }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush