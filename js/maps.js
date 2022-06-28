$(document).ready(function () {
    var autocomplete;

    autocomplete = new google.maps.places.Autocomplete((document.getElementById("ID")),{
        types: ['geocode'],
        componentRestrictions:{
            country: "PH"
        }
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
    });    
});