<div id="sectionDashboard">
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3" id="todaySales">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Đơn hàng hôm nay</p>
                        <h6 class="mb-0"></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3" id="allOrders">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tất cả đơn hàng</p>
                        <h6 class="mb-0"></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3" id="totalSalesToday">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Doanh thu hôm nay</p>
                        <h6 class="mb-0"></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3" id="totalRevenue">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng doanh thu</p>
                        <h6 class="mb-0"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Doanh thu và bán hàng</h6>
                        <a href="admin.php?act=chart">Xem tất cả</a>
                    </div>
                    <div class="d-flex">
                        <canvas id="salesRevenue" class="w-50 h-50"></canvas>
                        <hr width="5px" size="mx-auto" class="bg-dark">
                        <canvas id="totalSales" class="w-50 h-50"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function formatCurrency(price) {

        price = parseFloat(price);
        price = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(price);

        return price;

    }

    function lineChart(idCanvas, dataLabels, datasetsLabel, datasetsData) {
        var ctx = $("#" + idCanvas);
        month = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
        data = new Array();
        month.forEach((value,index)=>{
         
          datasetsData.forEach((item,index1) => {

          if(index == dataLabels[index1]-1){
             data.push(item);
          } else{
            data.push(0);
          }
                 
        });
        })
    
        var chartConfig = {
            type: 'line',
            data: {
                labels: month,
                datasets: [{
                        label: datasetsLabel,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                        data: data
                    },

                ]
            },
            // options: {
            //     responsive: true,
            //     title: {
            //         display: true,
            //         text: 'Double Line Chart'
            //     },
            //     tooltips: {
            //         mode: 'index',
            //         intersect: false,
            //     },
            //     hover: {
            //         mode: 'nearest',
            //         intersect: true
            //     },
            //     scales: {
            //         xAxes: [{
            //             display: true,
            //             scaleLabel: {
            //                 display: true,
            //                 labelString: 'Month'
            //             }
            //         }],
            //         yAxes: [{
            //             display: true,
            //             scaleLabel: {
            //                 display: true,
            //                 labelString: 'Value'
            //             }
            //         }]
            //     }
            // }
        };

        var myChart = new Chart(ctx, chartConfig);

    }

    $(document).ready(function() {
        $.ajax({
            type: "get",
            url: "admin.php?act=revenueStatistics",
            success: function(response) {
                arr = response.split("##-##");

                result = JSON.parse(arr[1]);
                todaySales = result.todaySales ? result.todaySales : 0;
                allOrders = result.allOrders ? result.allOrders : 0;
                totalSalesToday = result.totalSalesToday ? result.totalSalesToday : 0;
                totalRevenue = result.totalRevenue ? result.totalRevenue : 0;
                $('#todaySales h6').html(todaySales);
                $('#allOrders h6').html(allOrders);
                $('#totalSalesToday h6').html(formatCurrency(totalSalesToday));
                $('#totalRevenue h6').html(formatCurrency(totalRevenue));
            }
        });
        $.ajax({
            type: "get",
            url: "admin.php?act=salesRevenue",
            success: function(response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);
             
                arrMonth = result.arrMonth;
                arrTotalSales = result.arrTotalSales;
                arrTotalRevenue = result.arrTotalRevenue;
                lineChart('salesRevenue', arrMonth, 'Doanh thu', arrTotalRevenue);
                lineChart('totalSales', arrMonth, 'Đơn hàng', arrTotalSales);

            },
        });
    });
</script>