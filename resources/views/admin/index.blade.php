@extends('admin.admin_main')
@section('admin')
    <div class="content">

        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                </div>
            </div>

            <!-- start row -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row g-3">

                        <div class="col-md-6 col-xl-3">
                            <div class="card" style="background-color:lightblue">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Brands</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">
                                            {{ $brandAll }}
                                        </div>
                                        <div class="me-auto">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card" style="background-color:lightpink">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Warehouses</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">
                                            {{ $warehouseAll }}
                                        </div>
                                        <div class="me-auto">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card" style="background-color:lightgoldenrodyellow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Supplier</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $supplierAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card" style="background-color:rgb(231, 211, 239)">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Customers</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $customerAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>
                                    {{-- <div id="active-users" class="apex-charts"></div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-2">
                            <div class="card" style="background-color:rgb(231, 211, 239)">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Sales</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $saleAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>
                                    {{-- <div id="active-users" class="apex-charts"></div> --}}
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-xl-2">
                            <div class="card" style="background-color:#dd726c">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Sale Return</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $saleReturnAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>
                                    {{-- <div id="active-users" class="apex-charts"></div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-2">
                            <div class="card" style="background-color:#8de3e9">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Purchase Return</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $purchaseReturnAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>
                                    {{-- <div id="active-users" class="apex-charts"></div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-2">
                            <div class="card" style="background-color:#c0f0f0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Purchase</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $purchaseAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-md-6 col-xl-2">
                            <div class="card" style="background-color:#efef7a">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Stock</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $productAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>
                                    {{-- <div id="active-users" class="apex-charts"></div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-2">
                            <div class="card" style="background-color:#b7eaae">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Users</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $userAll }}</div>
                                        <div class="me-auto">

                                        </div>
                                    </div>
                                    {{-- <div id="active-users" class="apex-charts"></div> --}}
                                </div>
                            </div>
                        </div>


                    </div>
                </div> <!-- end sales -->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3>Monthly Sales </h3>
                            <div style="width: 90%; height: 350px;">
                                <canvas id="saleChart" height="150px;"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3> Monthly Purchase Report </h3>
                            <div style="width: 90%; height: 350px;">
                                <canvas id="purchaseChart" height="150px;"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
@endsection



<script>
    document.addEventListener("DOMContentLoaded", function() {

        const ctx = document.getElementById('saleChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($monthlySales->pluck('label')), // ["Oct", "Nov", "Dec"]
                datasets: [{
                    label: 'Sales - {{ date('Y') }}',
                    data: @json($monthlySales->pluck('total')),
                    borderWidth: 2,
                    borderColor: 'rgb(229, 199, 234)',
                    backgroundColor: 'rgb(229, 199, 234)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        const ctx = document.getElementById('purchaseChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($monthlyPurchases->pluck('label')), // ["Oct", "Nov", "Dec"]
                datasets: [{
                    label: 'Purchases - {{ date('Y') }}',
                    data: @json($monthlyPurchases->pluck('value')),
                    borderWidth: 2,
                    borderColor: 'rgb(173, 234, 231)',
                    backgroundColor: 'rgba(75, 192, 192, 0.3)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>
