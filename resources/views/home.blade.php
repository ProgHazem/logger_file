<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <title>Laravel log viewer</title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <style>
        body {
            padding: 25px;
        }
        h1 {
            font-size: 1.5em;
            margin-top: 0;
        }
        #table-log {
            font-size: 0.85rem;
        }
        .sidebar {
            font-size: 0.85rem;
            line-height: 1;
        }
        .btn {
            font-size: 0.7rem;
        }
        .stack {
            font-size: 0.85em;
        }
        .date {
            min-width: 75px;
        }
        .text {
            word-break: break-all;
        }
        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }
        .list-group-item {
            word-break: break-word;
        }
        .folder {
            padding-top: 15px;
        }
        .div-scroll {
            height: 80vh;
            overflow: hidden auto;
        }
        .nowrap {
            white-space: nowrap;
        }
        .list-group {
            padding: 5px;
        }
        /**
        * DARK MODE CSS
        */
        body[data-theme="dark"] {
            background-color: #151515;
            color: #cccccc;
        }
        [data-theme="dark"] a {
            color: #4da3ff;
        }
        [data-theme="dark"] a:hover {
            color: #a8d2ff;
        }
        [data-theme="dark"] .list-group-item {
            background-color: #1d1d1d;
            border-color: #444;
        }
        [data-theme="dark"] a.llv-active {
            background-color: #0468d2;
            border-color: rgba(255, 255, 255, 0.125);
            color: #ffffff;
        }
        [data-theme="dark"] a.list-group-item:focus, [data-theme="dark"] a.list-group-item:hover {
            background-color: #273a4e;
            border-color: rgba(255, 255, 255, 0.125);
            color: #ffffff;
        }
        [data-theme="dark"] .table td, [data-theme="dark"] .table th,[data-theme="dark"] .table thead th {
            border-color:#616161;
        }
        [data-theme="dark"] .page-item.disabled .page-link {
            color: #8a8a8a;
            background-color: #151515;
            border-color: #5a5a5a;
        }
        [data-theme="dark"] .page-link {
            background-color: #151515;
            border-color: #5a5a5a;
        }
        [data-theme="dark"] .page-item.active .page-link {
            color: #fff;
            background-color: #0568d2;
            border-color: #007bff;
        }
        [data-theme="dark"] .page-link:hover {
            color: #ffffff;
            background-color: #0051a9;
            border-color: #0568d2;
        }
        [data-theme="dark"] .form-control {
            border: 1px solid #464646;
            background-color: #151515;
            color: #bfbfbf;
        }
        [data-theme="dark"] .form-control:focus {
            color: #bfbfbf;
            background-color: #212121;
            border-color: #4a4a4a;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 sidebar mb-3">
           @if($errors)
               <div class="alert alert-danger">
                   {{$errors}}
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button></div>
            @endif
        </div>
        <div class="col-12 sidebar mb-3">
            <h1><i class="fa fa-calendar" aria-hidden="true"></i>Log Viewer</h1>
            <form action="/" method="POST">
                @csrf
                <div class="row">
                    <div class="col-10">
                        <input id="path" type="text" name="path" class="form-control" placeholder="/var/log/apache2/error.log">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary" type="submit">preview</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-10 table-container">
            @if ($logs === null)
                <div>
                    Log file Not logger
                </div>
            @else
                <table id="table-log" class="table table-striped" data-ordering-index="0">
                    <thead>
                    <tr>
                        <th>Line number</th>
                        <th>Content</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($logs as $key => $log)
                        <tr data-display="stack{{$key}}">
                            <td class="text">{{ $key + 1 }}</td>
                            <td class="text">{{$log}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
<!-- jQuery for Bootstrap -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<!-- FontAwesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
    $('.alert').alert()
    $(document).ready(function () {
        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });
        $('#table-log').DataTable({
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            // "stateLoadCallback": function (settings) {
            //     var data = JSON.parse(window.localStorage.getItem("datatable"));
            //     if (data) data.start = 0;
            //     return data;
            // }
        });
    });
</script>
</body>
</html>
