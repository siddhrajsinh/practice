@extends('layouts.visitor')
@push('before-script')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
            <div class="card-header">{{ __('Advance Filter') }}</div>
                <div class="card-body advance-filters">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="first_name" id="first_name"  placeholder="First Name">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="last_name" id="last_name"  placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="email" id="email"  placeholder="Email">
                        </div>
                    
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="ip_address" id="ip_address"  placeholder="Ip Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="created_at" id="created_at" readonly placeholder="Visited On">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-sm btn-primary" id="clear_frm" > Clear </button>
                            <button class="btn btn-sm btn-success" id="search" > Search </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix mb-2"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('Visitors List') }}</div>
                <div class="card-body">
                    <span class="mb-5">
                        <a class=" btn btn-sm btn-success float-right" id="export" onclick="exportVisitors();" > <i class="fa-fa-download"></i> Export </a>
                        <a id="downloadLink" href="#" download='visitors.csv' style="display:none;"></a>
                    </span>
                    <table id="visitors" class="table table-hover table-condensed" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>IP Address</th>
                                <th>Visited On</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-script')
<script>
    $(document).ready(function() {
        $('#created_at').datepicker({
            format : 'dd-mm-yyyy'
        });

        var table = $('#visitors').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{ route('visitor.list') }}",
          type :"post",
          data: function (d){
            d.email  = $("#email").val();
            d.first_name  = $("#first_name").val();
            d.last_name  = $("#last_name").val();
            d.ip_address  = $("#ip_address").val();
            d.created_at  = $("#created_at").val();
          }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'created_at', name: 'created_at'},
        ],
        "order": [[ 1, "asc" ]]
    });
   
    $("#search").click(function(){
        table.draw();
    });

    $("#clear_frm").click(function(){
        $('.advance-filters input').val('');
        table.draw();
    });
})

function exportVisitors()
{
    $('#export').html('Processing...');
    $('#export').attr("disabled", true);
    let email  = $("#email").val();
    let first_name  = $("#first_name").val();
    let last_name  = $("#last_name").val();
    let ip_address  = $("#ip_address").val();
    let created_at  = $("#created_at").val();
    $.ajax({
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('visitor.export') }}",
        type :"post",
        data : {'email' : email,'first_name' : first_name,'last_name' : last_name, 'ip_address' : ip_address, 'created_at'  : created_at },
        success:function(response) {
            if (response.status == 1) {
                window.open(response.url,'_blank');
            } else {
                alert(response.message);
            }
        },
        error: function(error) {
            alert('Something went wrong. Please try after some time.');
            console.log(error);

        },
        complete:function(jqXhr) {
            $('#export').attr("disabled", false);
            $('#export').html('Export');
        }
    });
}

</script>

@endpush