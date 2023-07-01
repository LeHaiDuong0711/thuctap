<?php
$today = getdate();

if (isset($_POST['month'])) {
    $month = $_POST['month'];
} else {
    $month = $today['mon'];
}

if (isset($_POST['year'])) {
    $year = $_POST['year'];
} else {
    $year = $today['year'];
} ?>
<div class="statistical mt-5">

    <form action="admin.php?use=statistical_filed" method="post">
        <div class="row">
            <div class="col-lg-2 "><select class="form-select " aria-label="Default select example" name="month">
                    <option value="0">Tháng</option>
                    <option value="1" <?php if ($month == 1) echo "selected" ?>>1</option>
                    <option value="2" <?php if ($month == 2) echo "selected" ?>>2</option>
                    <option value="3" <?php if ($month == 3) echo "selected" ?>>3</option>
                    <option value="4" <?php if ($month == 4) echo "selected" ?>>4</option>
                    <option value="5" <?php if ($month == 5) echo "selected" ?>>5</option>
                    <option value="6" <?php if ($month == 6) echo "selected" ?>>6</option>
                    <option value="7" <?php if ($month == 7) echo "selected" ?>>7</option>
                    <option value="8" <?php if ($month == 8) echo "selected" ?>>8</option>
                    <option value="9" <?php if ($month == 9) echo "selected" ?>>9</option>
                    <option value="10" <?php if ($month == 20) echo "selected" ?>>10</option>
                    <option value="11" <?php if ($month == 11) echo "selected" ?>>11</option>
                    <option value="12" <?php if ($month == 12) echo "selected" ?>>12</option>
                </select></div>
            <div class="col-lg-2">
                <input class="form-control" type="number" name="year" id="" value="<?php $today = getdate();
                                                                                    echo $today['year'] ?>">

            </div>
            <div class="col-lg-1">
                <input class=" form-control btn-success" type="submit" name="submit" value="Lọc">

            </div>




        </div>
    </form>

    <div id="statistical">

    </div>

</div>

<script>
    function drawStatistical() {
        var data = new google.visualization.DataTable();
        var pro_name = new Array();
        var quantityBuy = new Array();
        var rows = new Array();
        var dataProduct = 0;
        var quantityBuyProduct = 0;

        <?php


        $pr = new products();
        $result = $pr->getStatistical($month, $year);
        while ($set = $result->fetch()) :
            $pro_name = $set['name'];
            $quantity = $set['quantity'];
        ?>
            pro_name.push("<?php echo $pro_name ?>");
            quantityBuy.push("<?php echo $quantity ?>");

        <?php endwhile ?>

        for (let i = 0; i < pro_name.length; i++) {
            dataProduct = pro_name[i];
            quantityBuyProduct = parseInt(quantityBuy[i]);
            rows.push([dataProduct, quantityBuyProduct]);
        }

        data.addColumn("string", "Sản Phẩm");
        data.addColumn("number", "Số lượng bán");
        data.addRows(rows);
        var option = {
            title: "Thống Kê Số Lượng Bán Hàng Hóa",
            "with": 700,
            "height": 500,
            "backgroundColor": "#ffffff",
            "is3D": true
        }

        var chart = new google.visualization.ColumnChart(document.getElementById("statistical"));
        chart.draw(data, option);

    }
</script>