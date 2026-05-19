@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Marketing Message Send</h3>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">
            <form action="{{ route('admin.marketing.message.send.show') }}" method="post" class="add_form" success-content-id="result_div_id" no-reset="true" data-table-new-without-pagination="example1"> 
            {{ csrf_field() }} 
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Template Name</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="template_type" class="form-control select2" select2="true" required>
                            <option value="{{ Crypt::encrypt(0) }}" disabled selected>Select Template</option>
                                @foreach ($rs_records as $rs_val)
                                    <option value="{{ Crypt::encrypt($rs_val->id) }}">{{ $rs_val->id }} - {{ $rs_val->template_name }}</option>
                                @endforeach
                            </select>
                        </div>                               
                    </div>
                    <div class="col-lg-3 form-group">
                        <span class="fa fa-asterisk"></span>
                        <label>From Id</label>
                        <input type="text" name="from_id" class="form-control" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)' maxlength="10" required> 
                    </div>
                    <div class="col-lg-3 form-group">
                        <span class="fa fa-asterisk"></span>
                        <label>To Id</label>
                        <input type="text" name="to_id" class="form-control"  onkeypress='return (event.charCode >= 48 && event.charCode <= 57)' maxlength="10" required>
                    </div>
                    <div class="col-lg-3 form-group" style="padding-top: 30px;">
                        <input  type="submit" class="btn btn-primary form-control" id="btn_show" value="Show">
                    </div>
                </div>
            </form> 
        </div>
    </div>
    <div class="card card-info">
        <div class="card-body">
            <form action="{{ route('admin.marketing.message.send.send') }}" method="post" class="add_form" no-reset="true"> 
            {{ csrf_field() }}
                <div class="row" id="result_div_id"> 

                </div>
            </form>   
        </div>
    </div> 
</section>
@endsection