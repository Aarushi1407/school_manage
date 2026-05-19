
<div class="col-lg-12">
    <input type="hidden" hidden name="parameter" value="{{Crypt::encrypt($template_type . ':' . $from_id . ':' . $to_id)}}">
    <fieldset class="fieldset_border">
        <div class="table-responsive"> 
            <table class="table table-bordered table-striped table-hover" id="example1" width = "100%">
                <thead style="background-color: #6c757d;color: #fff">
                    <tr>
                        <th>Sr. No.</th>
                        <th>School Id</th>
                        <th>School Name</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Mobile No.</th>
                    </tr>
                </thead>
                @php
                    $srno = 1;
                @endphp
                <tbody>
                @foreach ($rs_records as $rs_val)
                    <tr>
                        <td>{{ $srno++ }}</td>
                        <td>{{ $rs_val->id }}</td>
                        <td>{{ $rs_val->school_name }}</td>
                        <td>{{ $rs_val->state_name }}</td>
                        <td>{{ $rs_val->city_name }}</td>
                        <td>{{ $rs_val->mobile_no }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>
<div class="col-lg-12 mt-4">
    <button type="submit" class="btn btn-success form-control"><i class="fa fa-send me-2"></i> Send</button>
</div>