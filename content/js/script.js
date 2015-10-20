var photodata;


function getapi(query_string) { //roept api aan en gooit in array

    var unApi = "https://api.unsplash.com/photos/search";
    query_string["client_id"] = "d9f2893f54375a39bdb4802cb7b3acfbc5fde5d1616fcfe1f6e0965e0aea8987"; //adds api key to conditions

    $.getJSON(unApi, query_string)
        .done(function (data) {
            photodata = data;
        });
}

function listthem() {
    $.each(photodata, function (k, v) {
        alert("Key: " + k + ", Value: " + v);
    });

}







$(document).ready(function () {

    //zoeken op titel
    $(".nav form").submit(function (e) {

        var search_term = $("#search_term").val();
        e.preventDefault();

        getapi({
            query: search_term
        });
        listthem();
    });

});
