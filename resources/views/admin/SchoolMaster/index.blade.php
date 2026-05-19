@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Master School List</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-info btn-sm" onclick="callPopupLarge(this,'{{ route('admin.master.school.list.addform', Crypt::encrypt(0)) }}')"><i class="fa fa-plus"></i> Add School Detail</button>
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
                                        <th>School Name</th>
                                        <th>State Name</th>
                                        <th>City Name</th>
                                        <th>Address 1</th>
                                        <th>Address 2</th>
                                        <th>Pin Code</th>
                                        <th>Mobile No.</th>
                                        <th>Email Id</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
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
                                            <button type="button" class="btn btn-info btn-sm"onclick="callPopupLarge(this,'{{ route('admin.master.school.list.addform',Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>
                                            
                                            <a type="button" href="{{ route('admin.master.school.list.delete',Crypt::encrypt($value->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>

                                            <button type="button" id="btn_contact" data-table-new="popup_data_table" class="btn btn-primary btn-sm"onclick="callPopupLarge(this,'{{ route('admin.master.school.contact.detail',Crypt::encrypt($value->id)) }}')"><i class="fa fa-plus"></i> Contact Detail</button>

                                        </td>
                                        <td>{{ $value->school_name }}</td>
                                        <td>{{ $value->state_name }}</td>
                                        <td>{{ $value->city_name }}</td>
                                        <td>{{ $value->address_1 }}</td>
                                        <td>{{ $value->address_2 }}</td>
                                        <td>{{ $value->pin_code }}</td>
                                        <td>{{ $value->mobile_no }}</td>
                                        <td>{{ $value->email_id }}</td>
                                        <td>{{ $value->status }}</td>
                                        <td>{{ $value->remarks }}</td>
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
