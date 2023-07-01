function showChartBar(idCanvas, dataLabels, datasetsLabel, datasetsData) {
  new Chart($("#" + idCanvas), {
    type: "bar",
    data: {
      labels: dataLabels,
      datasets: [
        {
          label: datasetsLabel,
          data: datasetsData,
          borderWidth: 1,
          backgroundColor: "#9BD0F5",
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
function lineChart(idCanvas, dataLabels, datasetsLabel, datasetsData) {
  ctx = $("#" + idCanvas);
  chartConfig = {
    type: "line",
    data: {
      labels: dataLabels,
      datasets: [
        {
          label: datasetsLabel,
          backgroundColor: "rgba(255, 99, 132, 0.2)",
          borderColor: "rgb(255, 99, 132)",
          fill: false,
          data: datasetsData,
        },
      ],
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

  myChart = new Chart(ctx, chartConfig);
}
$(document).ready(function () {
  date = new Date();
  month = date.getMonth() + 1;
  $("#month option[value=" + month + "]").attr("selected", true);
  $.ajax({
    type: "get",
    url: "admin.php?act=statistical",
    success: function (response) {
      arr = response.split("##-##");
      result = JSON.parse(arr[1]);
      arrProName = result.arrProName;
      arrQuantity = result.arrQuantity;
      arrMonth = result.arrMonth;
      arrTotalRevenue = result.arrTotalRevenue;
      month = [
        "Tháng 1",
        "Tháng 2",
        "Tháng 3",
        "Tháng 4",
        "Tháng 5",
        "Tháng 6",
        "Tháng 7",
        "Tháng 8",
        "Tháng 9",
        "Tháng 10",
        "Tháng 11",
        "Tháng 12",
      ];
      data = new Array();
      month.forEach((value,index)=>{
         
        arrTotalRevenue.forEach((item,index1) => {
          console.log(index == arrMonth[index1]-1);

        if(index == arrMonth[index1]-1){
           data.push(item);
        } else{
          data.push(0);
        }
               
      });
      })
   
      $("#productSales").append(
        `  <canvas id="bar" class="w-50 h-50"></canvas>
        <hr width="5px" size="mx-auto" class="bg-dark">
        <canvas id="line" class="w-50 h-50"></canvas>`
      );
      showChartBar("bar", arrProName, "số lượng bán", arrQuantity);
      lineChart("line", arrProName, "số lượng bán", arrQuantity);
      $("#monthlyRevenue").append(
        `  <canvas id="bar1" class="w-50 h-50"></canvas>
        <hr width="5px" size="mx-auto" class="bg-dark">
        <canvas id="line1" class="w-50 h-50"></canvas>`
      );
      showChartBar("bar1", month, "doanh thu", data);
      lineChart("line1", month, "doanh thu", data);
    },
  });
  $("#filed").on("submit", function (e) {
    e.preventDefault();
    formData = $(this).serialize();
    $.ajax({
      type: "post",
      url: "admin.php?act=statistical",
      data: formData,
      processData: false,
      cache: false,
      success: function (response) {
        arr = response.split("##-##");
        result = JSON.parse(arr[1]);
        arrProName = result.arrProName;
        arrQuantity = result.arrQuantity;
        arrQuantity = result.arrQuantity;
        arrMonth = result.arrMonth;
        month = [
          "Tháng 1",
          "Tháng 2",
          "Tháng 3",
          "Tháng 4",
          "Tháng 5",
          "Tháng 6",
          "Tháng 7",
          "Tháng 8",
          "Tháng 9",
          "Tháng 10",
          "Tháng 11",
          "Tháng 12",
        ];
        data = new Array();
        arrMonth.forEach((item) => {
          data.push(month[item]);
        });
        arrTotalRevenue = result.arrTotalRevenue;
        $("#productSales").text("");
        $("#productSales").append(
          `  <canvas id="bar" class="w-50 h-50"></canvas>
          <hr width="5px" size="mx-auto" class="m-3 bg-dark">
          <canvas id="line" class="w-50 h-50"></canvas>`
        );
        showChartBar("bar", arrProName, "số lượng bán", arrQuantity);
        lineChart("line", arrProName, "số lượng bán", arrQuantity);
        $("#monthlyRevenue").text("");
        $("#monthlyRevenue").append(
          `  <canvas id="bar1" class="w-50 h-50"></canvas>
          <hr width="5px" size="mx-auto" class="bg-dark">
          <canvas id="line1" class="w-50 h-50"></canvas>`
        );
        showChartBar("bar1", data, "doanh thu", arrTotalRevenue);
        lineChart("line1", data, "doanh thu", arrTotalRevenue);
      },
    });
  });
});
