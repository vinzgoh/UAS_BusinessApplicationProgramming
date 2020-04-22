<?php
//cashflow.php

include('database_connection.php');
if(!isset($_SESSION["type"]))
{
    header('location:login.php');
}

if($_SESSION['type'] != 'master')
{
    header('location:index.php');
}

include('header.php');

?>

<div class="page-wrapper">
    <div class="container-fluid">
        <span id="alert_action"></span>
        <!-- /row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">cashflow List</h3>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table id="cashflow_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                            <th>Saldo</th>
                                            <th>Enter By</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="cashflowModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="cashflow_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add cashflow</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Enter Cashflow Name</label>
                                <input type="text" name="cashflow_name" id="cashflow_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Cashflow Date</label>
                                <input type="date" name="cashflow_date" id="cashflow_date" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Pick Cashflow Type</label>
                                <input type="radio" class="radioBtn" name="cashflow_status" id="cashflow_status" value="debit" required>Income
                                <input type="radio" class="radioBtn" name="cashflow_status" id="cashflow_status" value="kredit" required>Outcome   
                            </div>
                            <div class="form-group" >
                                <div class="Box2" style="display:none">
                                    <label>Enter Debit</label>
                                    <input type="number" name="debit" id="debit" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group" >
                                <div class="Box1" style="display:none">
                                    <label>Enter Kredit</label>
                                    <input type="number" name="kredit" id="kredit" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="cashflow_id" id="cashflow_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>  
                    </div>
                </form>
            </div>
        </div>

        <div id="cashflowdetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="cashflow_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Cashflow Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="cashflow_details"></Div>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            $('input[type="radio"]').click(function(){
                if($(this).attr("value")=="debit"){
                    $(".Box1").hide('slow');
                    $(".Box2").show('slow');
                    document.getElementById("kredit").value = 0;
                }   
                if($(this).attr("value")=="kredit"){
                    $(".Box1").show('slow');
                    $(".Box2").hide('slow');
                    document.getElementById("debit").value = 0;
                }        
            });

            $('input[type="radio"]').trigger('click');

            $(document).ready(function(){
                var cashflowdataTable = $('#cashflow_data').DataTable({
                    "processing":true,
                    "serverSide":true,
                    "order":[],
                    "ajax":{
                        url:"cashflow_fetch.php",
                        type:"POST"
                    },
                    "columnDefs":[
                    {
                        "targets":[0, 7, 8, 9, 10],
                        "orderable":false,
                    },
                    ],
                    "dom": 'Bfrtip',
                    "buttons": [
                    {
                        "extend": 'copy',
                        "text": 'Copy Table',
                        "exportOptions": {
                            "columns": [ 0, 1, 2, 3, 4, 5 ],
                            "modifier": {
                                "page": 'current'
                            },
                        },
                    },
                    {
                        "extend": 'csv',
                        "text": 'Save as Csv',
                        "exportOptions": {
                            "columns": [ 0, 1, 2, 3, 4, 5 ],
                            "modifier": {
                                "page": 'current'
                            },
                        },
                    },
                    {
                        "extend": 'excel',
                        "text": 'Save as Excel',
                        "exportOptions": {
                            "columns": [ 0, 1, 2, 3, 4, 5 ],
                            "modifier": {
                                "page": 'current'
                            },
                        },
                    },
                    {
                        "extend": 'pdf',
                        "text": 'Save as PDF',
                        "exportOptions": {
                            "columns": [ 0, 1, 2, 3, 4, 5 ],
                            "modifier": {
                                "page": 'current'
                            },
                        },
                    },
                    {
                        "extend": 'print',
                        "text": 'Print',
                        "exportOptions": {
                            "columns": [ 0, 1, 2, 3, 4, 5 ],
                            "modifier": {
                                "page": 'current'
                            },
                        },
                    },
                    
                    ],
                    "pageLength": 25
                });

                $('#add_button').click(function(){
                    $('#cashflowModal').modal('show');
                    $('#cashflow_form')[0].reset();
                    $('.modal-title').html("<i class='fa fa-plus'></i> Add cashflow");
                    $('#action').val("Add");
                    $('#btn_action').val("Add");
                });


                $(document).on('submit', '#cashflow_form', function(event){
                    event.preventDefault();
                    $('#action').attr('disabled', 'disabled');
                    var form_data = $(this).serialize();
                    $.ajax({
                        url:"cashflow_action.php",
                        method:"POST",
                        data:form_data,
                        success:function(data)
                        {
                            $('#cashflow_form')[0].reset();
                            $('#cashflowModal').modal('hide');
                            $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                            $('#action').attr('disabled', false);
                            cashflowdataTable.ajax.reload();
                        }
                    })
                });

                $(document).on('click', '.view', function(){
                    var cashflow_id = $(this).attr("id");
                    var btn_action = 'cashflow_details';
                    $.ajax({
                        url:"cashflow_action.php",
                        method:"POST",
                        data:{cashflow_id:cashflow_id, btn_action:btn_action},
                        success:function(data){
                            $('#cashflowdetailsModal').modal('show');
                            $('#cashflow_details').html(data);
                        }
                    })
                });

                $(document).on('click', '.update', function(){
                    var cashflow_id = $(this).attr("id");
                    var btn_action = 'fetch_single';
                    $.ajax({
                        url:"cashflow_action.php",
                        method:"POST",
                        data:{cashflow_id:cashflow_id, btn_action:btn_action},
                        dataType:"json",
                        success:function(data){
                            $('#cashflowModal').modal('show');
                            $('#cashflow_name').val(data.cashflow_name);
                            $('#cashflow_date').val(data.cashflow_date);
                            $('#cashflow_status').val(data.cashflow_status);
                            $('#kredit').val(data.kredit);
                            $('#debit').val(data.debit);
                            $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit cashflow");
                            $('#cashflow_id').val(cashflow_id);
                            $('#action').val("Edit");
                            $('#btn_action').val("Edit");
                        }
                    })
                });

                $(document).on('click', '.delete', function(){
                    var cashflow_id = $(this).attr("id");
                    var status = $(this).data("status");
                    var btn_action = 'delete';
                    if(confirm("Are you sure you want to delete cashflow?"))
                    {
                        $.ajax({
                            url:"cashflow_action.php",
                            method:"POST",
                            data:{cashflow_id:cashflow_id, status:status, btn_action:btn_action},
                            success:function(data){
                                $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                                cashflowdataTable.ajax.reload();
                            }
                        });
                    }
                    else
                    {
                        return false;
                    }
                });

            });
        </script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
        <link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet">
