$(document).ready(function () {
  $.ajax({
    type: "get",
    url: "admin.php?act=supplier",

    success: function (response) {
      arr = response.split("##-##");
      arrSuppliers = JSON.parse(arr[1]);

      arrSuppliers.forEach((item) => {
        $("#supplierAddProduct").append(
          "<option id=" +
            item.id +
            " value=" +
            item.id +
            ">" +
            item.name +
            "</option>"
        );
      });
    },
  });

  $.ajax({
    type: "get",
    url: "admin.php?act=type",

    success: function (response) {
      arr = response.split("##-##");
      arrType = JSON.parse(arr[1]);

      arrType.forEach((item) => {
        $("#typeAddProduct").append(
          " <option id=" +
            item.type_id +
            " value=" +
            item.type_id +
            ">" +
            item.type_name +
            "</option>"
        );
      });
    },
  });

  $("input[name='uploadImageAddProduct']").change(function () {
    file = $(this)[0].files[0];
    fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.onloadend = function (e) {
      $("#avatar-image").attr("src", e.target.result);
    };
  });

  $(document).on("click", "#back", function () {
    window.history.back();
  });

  //input tag

  // "use strict"

  // Plugin Constructor
  var TagsInput = function (opts) {
    this.options = Object.assign(TagsInput.defaults, opts);
    this.init();
  };

  // Initialize the plugin
  TagsInput.prototype.init = function (opts) {
    this.options = opts ? Object.assign(this.options, opts) : this.options;

    if (this.initialized) this.destroy();

    if (
      !(this.orignal_input = document.getElementById(this.options.selector))
    ) {
      console.error(
        "tags-input couldn't find an element with the specified ID"
      );
      return this;
    }
    this.arr = [];
    this.wrapper = document.createElement("div");
    this.wrapper.setAttribute("class", "col-lg-10");
    this.input = document.createElement("input");
    init(this);
    initEvents(this);
    this.initialized = true;
    return this;
  };

  // Add Tags
  TagsInput.prototype.addTag = function (string) {
    if (this.anyErrors(string)) return;

    this.arr.push(string);
    var tagInput = this;

    var tag = document.createElement("span");
    tag.className = this.options.tagClass;
    tag.innerText = string;

    var closeIcon = document.createElement("a");
    closeIcon.innerHTML = "&times;";

    // delete the tag when icon is clicked
    closeIcon.addEventListener("click", function (e) {
      e.preventDefault();
      var tag = this.parentNode;

      for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
        if (tagInput.wrapper.childNodes[i] == tag) tagInput.deleteTag(tag, i);
      }
    });

    tag.appendChild(closeIcon);
    this.wrapper.insertBefore(tag, this.input);
    this.orignal_input.value = this.arr.join(",");
    return this;
  };

  // Delete Tags
  TagsInput.prototype.deleteTag = function (tag, i) {
    tag.remove();
    this.arr.splice(i, 1);
    this.orignal_input.value = this.arr.join(",");
    return this;
  };

  // Make sure input string have no error with the plugin
  TagsInput.prototype.anyErrors = function (string) {
    if (this.options.max != null && this.arr.length >= this.options.max) {
      console.log("max tags limit reached");
      return true;
    }

    if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
      console.log('duplicate found " ' + string + ' " ');
      return true;
    }

    return false;
  };

  // Add tags programmatically
  TagsInput.prototype.addData = function (array) {
    var plugin = this;

    array.forEach(function (string) {
      plugin.addTag(string);
    });

    return this;
  };

  // Get the Input String
  TagsInput.prototype.getInputString = function () {
    return this.arr.join(",");
  };

  // destroy the plugin
  TagsInput.prototype.destroy = function () {
    this.orignal_input.removeAttribute("hidden");

    delete this.orignal_input;
    var self = this;

    Object.keys(this).forEach(function (key) {
      if (self[key] instanceof HTMLElement) self[key].remove();

      if (key != "options") delete self[key];
    });

    this.initialized = false;
  };

  // Private function to initialize the tag input plugin
  function init(tags) {
    tags.wrapper.append(tags.input);
    tags.wrapper.classList.add(tags.options.wrapperClass);
    tags.orignal_input.setAttribute("hidden", "true");
    tags.orignal_input.parentNode.insertBefore(
      tags.wrapper,
      tags.orignal_input
    );
  }

  // initialize the Events
  function initEvents(tags) {
    tags.wrapper.addEventListener("click", function () {
      tags.input.focus();
    });

    tags.input.addEventListener("keydown", function (e) {
      var str = tags.input.value.trim();

      if (!!~[9, 13, 188].indexOf(e.keyCode)) {
        e.preventDefault();
        tags.input.value = "";
        if (str != "") tags.addTag(str);
      }
    });
    tags.input.addEventListener("blur", function (e) {
      var str = tags.input.value.trim();

      e.preventDefault();
      tags.input.value = "";
      if (str != "") tags.addTag(str);
    });
  }

  // Set All the Default Values
  TagsInput.defaults = {
    selector: "",
    wrapperClass: "tags-input-wrapper",
    tagClass: "tag",
    max: null,
    duplicate: false,
  };

  window.TagsInput = TagsInput;

  $(document).on("click", ".add-btn.property", function () {
    i = $(".tags-input-wrapper").length + 1;

    $(".containerProperty").append(
      '<div id="container' +
        i +
        '" class="row container"><input type="text" id="title' +
        i +
        '" class="titleProperty col-lg-2" placeholder="Thuộc tính ' +
        i +
        '"></div>'
    );
    $("#container" + i).append(
      '<input type="text" class="tag-input" id="tag-input' + i + '">'
    );
    $("#container" + i).append(
      '<button type="button" data-id="' +
        i +
        '" class="btn-remove removeProperty col-lg-1"><i class="far fa-trash-alt"></i></button>'
    );
    $("#container" + i).append(
      '<span class="text-bg-danger" id="error-tag' + i + '"></span>'
    );
    tagInput = new TagsInput({
      selector: "tag-input" + i,
      duplicate: false,
      max: 10,
    });

    if ($(".containerProperty").children().length > 0) {
      $(".create").html(
        '<button type="button" class="float-end btn-create"><i class="far fa-play-circle"></i></button>'
      );
    }
  });

  $(document).on("blur", ".titleProperty", function () {
    html = $(this);
    value1 = $(this).val();
    index1 = $(".titleProperty").index($(this));

    $(".titleProperty").each(function (index, value) {
      if (value1 == value.value && index != index1) {
        html.siblings("span").html("Thuộc tính bị trùng lặp");
        return false;
      } else {
        html.siblings("span").html("");
      }
    });
  });
  property = [];
  $(document).on("keydown", ".tags-input-wrapper input", function (e) {
    title = $(this).parent().siblings().val();

    if (e.keyCode === 13) {
      e.preventDefault();

      check = false;
      if (property.length <= 0) {
        item = {
          title: title,
          value: tagInput.arr,
        };

        property.push(item);
      } else {
        for (i = 0; i < property.length; i++) {
          if (property[i].title == title) {
            check = true;
            break;
          }
        }

        if (check == false) {
          item1 = {
            title: title,
            value: tagInput.arr,
          };
          property.push(item1);
        }
      }
      setTimeout(() => {}, 500);

      // Thực hiện hành động khác ở đây
    }
  });
  // function combineProperties(properties, index, current) {
  //   if (index == properties.length) {
  //     return [current];
  //   } else {
  //     var results = [];
  //     for (var i = 0; i < properties[index].value.length; i++) {
  //       var result = combineProperties(
  //         properties,
  //         index + 1,
  //         current + "/" + properties[index].value[i]
  //       );
  //       results.push.apply(results, result);
  //     }
  //     return results;
  //   }
  // }

  $(document).on("click", ".create", function () {
    productProperty = [];
    arrTitle = [];
    isCheck = true;

    $(".productProperty")
      .children(".containerProperty")
      .children(".container")
      .each((index, item) => {
        title = item.children[0].value;
        $(".titleProperty").each((index1, item1) => {
          if (item1.value == title && index != index1) {
            isCheck = false;
            $(item.children[0]).focus();
          }
        });
        if (isCheck == true) {
          arrTitle.push(item.children[0].value);
          value = item.children[2].value;
          item2 = {
            title: title,
            value: value,
          };
          productProperty.push(item2);
        }
      });

    if (isCheck == true) {
      indexTh = 1;
      productProperty.forEach((value) => {
        isset = false;

        $("#productPropertyTable thead th").each((index, item) => {
          if ($(item).text() == value.title) {
            isset = true;
            indexTh = index;
          }
        });
        if (isset == false) {
          $("#productPropertyTable")
            .find("th")
            .eq(indexTh++)
            .after(`<th>` + value.title + `</th>`);
        }
      });

      function combineElements(array, currentObj) {
        // Nếu mảng chỉ còn 1 phần tử, trả về mảng gồm đối tượng hiện tại
        if (array.length === 1) {
          const values = array[0].value.split(",");
          const result = [];

          values.forEach((value) => {
            const newObj = {};
            newObj[currentObj.title] = value;
            result.push(newObj);
          });

          return result;
        }

        // Nếu mảng còn nhiều hơn 1 phần tử, đệ qui để tạo ra tất cả các cặp phần tử
        const firstObj = array[0];
        const restArray = array.slice(1);
        const values = firstObj.value.split(",");
        const tempArray = [];

        values.forEach((value, index) => {
          const newObj = {};
          newObj[firstObj.title] = value;

          const resultArray = combineElements(restArray, array[1]);
          resultArray.forEach((resultObj) => {
            const finalObj = Object.assign({}, newObj, resultObj);
            tempArray.push(finalObj);
          });
        });

        return tempArray;
      }

      const resultArray = combineElements(productProperty, productProperty[0]);
      htmls = [];

      sku = 10000;
      for (let i = 0; i < resultArray.length; i++) {
        const row = $("<tr>");
        row.attr("id", i + 1);

        row.append('<td class="idProductProperty">' + (i + 1) + "</td>");
        row.append('<td class="skuProductProperty">#0' + sku++ + "</td>");
        arrTitle.forEach((value) => {
          row.append(
            '<td class="' + value + '">' + resultArray[i][value] + "</td>"
          );
        });

        row.append(
          '<td class="priceProductProperty"><input type="number" class="form-control" value=0 /></td>'
        );
        row.append(
          '<td class="promotionProductProperty"><input type="number" class="form-control" value=0 /></td>'
        );
        row.append(
          '<td class="quantityProductProperty"><input type="number" class="form-control" value=0 /></td>'
        );
        row.append(
          ` <td>
                <div class="wrap">
      
                <div class="profile">
                    <div class="image_product" id="avatar" src="./../Assets/img/default.jpg">
                       <img id="avatar-image` +
            i +
            `" class="avatar_img">
      
                        <div class="avatar_upload">
                            <label class="upload_label">Upload
                                <input type="file" id="upload" name="uploadImageAddProductProperty[` +
            i +
            `]" class="uploadImageAddProductProperty">
                            </label>
                        </div>
                    </div>
                </div>
      
            </div>
                </td>`
        );
        // row.append(
        //   `  <td><button type="button" data-id="` +
        //    (i+1)  +
        //     `" class="btn-remove removeProductProperty"><i class="far fa-trash-alt"></i></button><td>`
        // );
        htmls.push(row);
      }
      $("#listProductProperty").html(htmls);
      if ($("#listProductProperty tr").length > 0) {
        $("#productPropertyTable").prop("hidden", false);
      }

      $(document).on("submit", "#addProductForm", function (e) {
        e.preventDefault();
        const productProperty = [];
        $("#listProductProperty tr").each((index, item) => {
          index += 1;
          sku = $("tr#" + index + " .skuProductProperty")
            .text()
            .split("#0");
          const product = {
            sku: sku[1],
            // image: $("tr#" + index + " .avatar_img").attr("src"),
            price: $("tr#" + index + " .priceProductProperty input").val(),
            promotion: $(
              "tr#" + index + " .promotionProductProperty input"
            ).val(),
            quantity: $(
              "tr#" + index + " .quantityProductProperty input"
            ).val(),
          };

          const newObj = {};

          for (let i = 0; i < arrTitle.length; i++) {
            const title = arrTitle[i];
            const value = $("tr#" + index + " ." + title).text();
            newObj[title] = value;
          }

          const newProduct = Object.assign({}, product, newObj);

          productProperty.push(newProduct);
        });

        data = new FormData(this);
        productProperty.forEach(function (prod, index) {
          for (var key in prod) {
            data.append(`product[${index}][${key}]`, prod[key]);
          }
        });
        arrTitle.forEach((value, index) => {
          data.append(`title[${index}]`, value);
        });

        $.ajax({
          type: "post",
          url: "admin.php?act=addProduct_action",
          data: data,
          processData: false,
          contentType: false,
          success: function (response) {
            arr = response.split("##-##");
            result = arr[1];

            if (result == "success") {
              alert("thêm sản phẩm thành công");
              $("#addProductForm")[0].reset();
              $(".avatar_img").attr("src", "./../Assets/img/default.jpg");
              $(".containerProperty").html("");
              $("#listProductProperty").html("");
              $(".create").html("");
              $("#productPropertyTable").prop("hidden", true);
            } else if (result == "product exited") {
              alert("Sản phẩm này đã tồn tại");
            } else {
              console.log(result);
            }
          },
        });
      });
    }
  });
  $(document).on("click", ".removeProperty", function () {
    id = $(this).data("id");
    index = id - 1;
    $("#container" + id).remove();
    property.splice(index, 1);
    if ($(".containerProperty").children().length <= 0) {
      $(".create").html("");
    }
  });

  $(document).on("click", ".removeProductProperty", function () {
    id = $(this).data("id");
    console.log(id);
    index = id - 1;
    $("#listProductProperty tr#" + id).remove();
    if ($("#listProductProperty tr").length <= 0) {
      $("#productPropertyTable").prop("hidden", true);
    }
  });

  $(document).on(
    "change",
    "#listProductProperty input.uploadImageAddProductProperty",
    function () {
      element = $(this);
      file = $(this)[0].files[0];

      fileReader = new FileReader();

      fileReader.readAsDataURL(file);
      fileReader.onloadend = function (e) {
        element.parent().parent().siblings().attr("src", e.target.result);
      };
    }
  );
});
