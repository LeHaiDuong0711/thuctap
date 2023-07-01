$(document).ready(function () {
  function formatDate(dateFormat) {
    date = new Date(dateFormat);
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
    formattedDate = day + "-" + month + "-" + year;
    return formattedDate;
  }
  $.ajax({
    type: "get",
    url: "index.php?act=news_act",

    success: function (response) {
      arr = response.split("##-##");
      result = JSON.parse(arr[1]);
      result.forEach((element) => {
        $("#sectionNews .containerNews").append(
          `<div class="card mt-5 p-5  imgNew" id="` +
            element.id +
            `">
          <span class="text-end">` +
            formatDate(element.dateCreate) +
            `</span>
          <img  class="" src="./Assets/img/` +
            element.image +
            `">
          <div class="card-body">
              <h5 class="card-title"> <a href="index.php?act=newsDetail&id=` +
            element.id +
            `">` +
            element.title +
            `</a></h5>
              <p class="card-text">` +
            element.description +
            `</p>
              <a href="index.php?act=newsDetail&id=` +
            element.id +
            `" class="btn btn-primary">Đọc thêm...</a>
          </div>
      </div>`
        );
      });
    },
  });

  $.ajax({
    type: "get",
    url: "index.php?act=newsEveryday_act",
    success: function (response) {
      arr = response.split("##-##");

      result = JSON.parse(arr[1]);
      if (result.length > 0) {
        htmls = [];
        result.forEach((element) => {
          html =
            `<div class="card mt-5 p-5  imgNew" id="` +
            element.id +
            `">
        <span class="text-end">` +
            element.dateCreate +
            `</span>
        <img  class="" src="./Assets/img/` +
            element.image +
            `">
        <div class="card-body">
            <h5 class="card-title"> <a href="index.php?act=newsDetail&id=` +
            element.id +
            `">` +
            element.title +
            `</a></h5>
            <p class="card-text">` +
            element.description +
            `</p>
            <a href="index.php?act=newsDetail&id=` +
            element.id +
            `" class="btn btn-primary">Đọc thêm...</a>
        </div>
    </div>`;
    htmls.push(html)
        });
        $("#sectionNewsEveryday .containerNews").html(htmls);

      } else {
        $("#sectionNewsEveryday .containerNews").append(
          `<h3 class="text-bg-danger">Hôm nay không có tin mới</h3>`
        );
      }
    },
  });
  $.ajax({
    type: "get",
    url: "index.php?act=commodityNews_act",
    data: { id: 8 },
    success: function (response) {
      arr = response.split("##-##");

      result = JSON.parse(arr[1]);
      if (result.length > 0) {
        result.forEach((element) => {
          $("#commodityNews .containerNews").append(
            `<div class="card mt-5 p-5  imgNew" id="` +
              element.id +
              `">
            <span class="text-end">` +
              element.dateCreate +
              `</span>
            <img  class="" src="./Assets/img/` +
              element.image +
              `">
            <div class="card-body">
                <h5 class="card-title"> <a href="index.php?act=newsDetail&id=` +
              element.id +
              `">` +
              element.title +
              `</a></h5>
                <p class="card-text">` +
              element.description +
              `</p>
                <a href="index.php?act=newsDetail&id=` +
              element.id +
              `" class="btn btn-primary">Đọc thêm...</a>
            </div>
        </div>`
          );
        });
      } else {
        $("#commodityNews .containerNews").append(
          `<h3 class="text-bg-danger">Tin tức chưa được cập nhật</h3>`
        );
      }
    },
  });

  $.ajax({
    type: "get",
    url: "index.php?act=marketNews_act",
    data: { id: 9 },
    success: function (response) {
      arr = response.split("##-##");

      result = JSON.parse(arr[1]);
      if (result.length > 0) {
        result.forEach((element) => {
          $("#marketNews .containerNews").append(
            `<div class="card mt-5 p-5  imgNew" id="` +
              element.id +
              `">
            <span class="text-end">` +
              element.dateCreate +
              `</span>
            <img  class="" src="./Assets/img/` +
              element.image +
              `">
            <div class="card-body">
                <h5 class="card-title"> <a href="index.php?act=newsDetail&id=` +
              element.id +
              `">` +
              element.title +
              `</a></h5>
                <p class="card-text">` +
              element.description +
              `</p>
                <a href="index.php?act=newsDetail&id=` +
              element.id +
              `" class="btn btn-primary">Đọc thêm...</a>
            </div>
        </div>`
          );
        });
      } else {
        $("#marketNews .containerNews").append(
          `<h3 class="text-bg-danger">Tin tức chưa được cập nhật</h3>`
        );
      }
    },
  });
});
