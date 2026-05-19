@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Book Demo Request List</h3>
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
                                        <th>Sr. No.</th>                
                                        <th>Request ID</th>
                                        <th>Action</th>
                                        <th>Mobile No.</th>
                                        <th>Institute Name</th>
                                        <th>Client Name</th>
                                        <th>Designation</th>
                                        <th>Email</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Address 1</th>
                                        <th>Address 2</th>
                                        <th>Pin Code</th>
                                        <th>Message</th>
                                        <th>Request Date</th>
                                        <th>Request Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sr_no = 1;
                                    @endphp
                                    @foreach($rs_records as $value)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>{{ $value->id }}</td>
                                        <td>
                                            {{-- <a type="button" class="btn btn-info btn-sm"onclick="callPopupLarge(this,'{{ route('admin.school.detail.edit',Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</a> --}}

                                        </td>
                                        <td>{{ $value->mobile_no }}</td>
                                        <td>{{ $value->institute_name }}</td>
                                        <td>{{ $value->c_name }}</td>
                                        <td>{{ $value->designation }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->state_name }}</td>
                                        <td>{{ $value->city_name }}</td>
                                        <td>{{ $value->address_1 }}</td>
                                        <td>{{ $value->address_2 }}</td>
                                        <td>{{ $value->pin_code }}</td>
                                        <td>{{ $value->msg_text }}</td>
                                        <td>{{ $value->r_date }}</td>
                                        <td>{{ $value->r_count }}</td>
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
