$(document).ready(function() {
    $.ajax({
        url: "http://localhost:7777/EADAssignment/app/index.php/players",
        contentType: "json",
        beforeSend: function(xhr) {
        xhr.setRequestHeader("Authentication", "Basic " + btoa("16" + ":" + "1234"));
    },
    error: function(jqXHR) {
    console.log("ajax error " + jqXHR.status);
	},
    success: function(data) {
   $('.players-name').append(data.id);
   $('.players-surname').append(data.email);
	}
});
});