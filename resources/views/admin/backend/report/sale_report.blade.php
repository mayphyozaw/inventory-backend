@extends('admin.admin_main')
@section('title', 'All Reports')
@section('admin')
    <div class="page-content m-2">
        <div class="container">
           @include('admin.backend.report.body.report_top')
        </div>

        <div class="card">
            <nav class="navbar navbar-expand-lg bg-dark">
                <div class="container-fluid">
                    @include('admin.backend.report.body.report_menu')

                    {{-- Date Range Picker --}}
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-center position-relative">
                            <select  id="date-range" class="form-control large-select">
                                <option value="" selected disabled>Select Date Range</option>
                                <option value="today">Today</option>
                                <option value="this_week">This Week</option>
                                <option value="last_week">Last Week</option>
                                <option value="this_month">This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            {{-- <span class="mdi mdi-filter-menu"></span> --}}
                             <i data-feather="filter"></i>
                        </div>

                        {{-- Custom date filed --}}
                        <div class="dropdown-menu p-2 custom-dropdown position-absolute shadow bg-white">
                            <label for="custom-start-date">Start Date:</label>
                            <input type="date" id="custom-start-date" class="form-control mb-2">

                            <label for="custom-end-date">End Date:</label>
                            <input type="date" id="custom-end-date" class="form-control mb-2">

                            <button id="apply-filter" class="btn btn-primary w-100"> Apply</button>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="card-body">
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper db-bootstrap5">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example" class="table table-stripe table-bordered dataTable" 
                                style="width:100%;" role="grid" aria-describedby="example_info">
                                    <thead>
                                        <tr role="row">
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Supplier</th>
                                            <th>Warehouse</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Status</th>
                                            <th>Grand Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($saleReports as $key=>$saleReport)
                                            @foreach ($saleReport->saleItems as $item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$saleReport->date}}</td>
                                                <td>{{$saleReport->customer->name ?? ''}}</td>
                                                <td>{{$saleReport->warehouse->name ?? ''}}</td>
                                                <td>{{$item->product->name ?? ''}}</td>
                                                <td>{{$item->quantity ?? ''}}</td>
                                                <td>{{$item->net_unit_cost ?? ''}}</td>
                                                <td>{{$saleReport->status ?? ''}}</td>
                                                <td>{{$saleReport->grand_total ?? ''}}</td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .navbar .container-fluid{
            position: relative;
        }

        .filter-container{
            position: relative;
            display: inline-block;
            width: 200px;
            margin-left: 10px;
        }

        .large-select{
            background-color: #343a40;
            color: white;
            border: 1px solid #495057;
            padding: 5px 10px;
            width: 150px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image:("data:image/svg+xml, %3Csvg xmlns='https://www.w3.org/2000/svg' viewBox='0 0 24 24'");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }

        .mdi-filter-menu{
            position: relative;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            color:white;
            pointer-events: none;
        }

        .custom-dropdown{
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            width: 250px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        @media (max-width: 991px){
            .filter-container{
                width: 100%;
                margin-top: 10px;
            }
            .custom-dropdown{
                right: auto;
                left: 0;
                width: 100%;
            }
        }
    </style>


    <script>
        document.getElementById("date-range").addEventListener("change", function(){
            let selectedValue = this.value;
            let today = new Date();
            let startDate, endDate;

            if(selectedValue == 'custom'){
                document.querySelector('.custom-dropdown').style.display = "block";
                return;
            }else{
                document.querySelector('.custom-dropdown').style.display = "none";
            }

            switch(selectedValue){
                case "today":
                    startDate = formatDate(today);
                    endDate = formatDate(today);
                    break;
                
                case "this_week":
                    startDate = formatDate(getWeekStart(today));
                    endDate = formatDate(today);
                    break;
                
                case "last_week":
                    let lastWeekStart = new Date(getWeekStart(today));
                    lastWeekStart.setDate(lastWeekStart.getDate() - 7);

                    let lastWeekEnd = new Date(lastWeekStart);
                    lastWeekEnd.setDate(lastWeekStart.getDate() + 6);

                    startDate = formatDate(lastWeekStart);
                    endDate = formatDate(lastWeekEnd);
                    break;
                
                case "this_month":
                    startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
                    endDate = formatDate(today);
                    break;
                
                case "last_month":
                    let lastMonthStart = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    let lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                    startDate = formatDate(lastMonthStart);
                    endDate = formatDate(lastMonthEnd);
                    break;
                
                default:
                    return;
            }

            //Fetch data via AJAX
            fetchFilteredData(startDate, endDate);
        });

        document.getElementById("apply-filter").addEventListener("click", function(){
            let startDate = document.getElementById("custom-start-date").value;
            let endDate = document.getElementById("custom-end-date").value;

            if(startDate && endDate){
                fetchFilteredData(startDate, endDate);
            }else{
                alert("Please select both start and end dates.");
            }
        });

        function fetchFilteredData(startDate, endDate){
            fetch(`/filter-sales?start_date=${startDate}&end_date=${endDate}`,{
                headers: {
                    'Accept' : 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',

                }
            })
            .then(response => response.json())
            .then(data => {
                updateTable(data.saleReports);
            })
            .catch(error => console.error('Error Fetching data:', error));
        }
        function updateTable(saleReports){
            let tbody = document.querySelector("#example tbody");
            tbody.innerHTML = ""; // Clear Existing Rows

            saleReports.forEach(saleReport => {
                saleReport.sale_items.forEach(item => {
                    const netUnitCost = item.net_unit_cost ? parseFloat(item.net_unit_cost) : 0;

                    let row = `
                        <tr>
                            <td> ${saleReport.id} </td>
                            <td> ${saleReport.date} </td>
                            <td> ${saleReport.customer ? saleReport.customer.name : ''} </td>
                            <td>${saleReport.warehouse ? saleReport.warehouse.name : ''}</td>
                            <td> ${item.product ? item.product.name : ''}</td>
                            <td> ${item.quantity} </td>
                            <td> ${netUnitCost.toFixed(2)} </td>
                            <td> ${saleReport.status} </td>
                            <td> ${saleReport.grand_total ? parseFloat(saleReport.grand_total).toFixed(2): '0.00'} </td>
                        </tr>
                        `;
                        tbody.insertAdjacentHTML('beforeend',row);
                });
            });
        }
        function formatDate(date){
            return date.toISOString().split("T")[0];
        }

        function getWeekStart(date){
            let d = new Date(date);
            d.setDate(d.getDate() - d.getDay());
            return d;
        }
    </script>
@endsection