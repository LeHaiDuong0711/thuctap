$(document).ready(function() {
    
function formatDate(dateFormat) {
    date = new Date(dateFormat);
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
    formattedDate = day + "-" + month + "-" + year;
    return formattedDate;
  }
    url = new URLSearchParams(window.location.href);
    id = url.get("id");
    $.ajax({
        type: "get",
        url: "index.php?act=newsDetail_act&id=" + id,
        success: function(response) {
            arr = response.split('##-##');
            result = JSON.parse(arr[1]);
            $(result.title).appendTo('.title');
            $('.dateCreate').html(formatDate(result.dateCreate));
            $('.description').append(result.description);
            $('.content').append(result.content);
            $('.imgNew').append('<img src="./Assets/img/' + result.image + '" alt="">');
        }
    });
});