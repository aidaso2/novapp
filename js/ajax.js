function getMarkers() {
    $.ajax({
         type: "POST",
         url: '../src/ajax.php',
         data:{
             action:'get_markers'
            },
         async: false,
         success:function(html) {
             markersArr = html;
         }

    });
    // location.reload(); 
}

function removeAirport(id) {
    $.ajax({
         type: "POST",
         url: '../src/ajax.php',
         data:{
             action:'remove_airport',
             id: id
            },
         success:function(html) {
            alert(html);
            location.reload();
         }
    });
}

function removeAvialine(id) {
    $.ajax({
         type: "POST",
         url: '../src/ajax.php',
         data:{
             action:'remove_avialine',
             id: id
            },
         success:function(html) {
            alert(html);
            location.reload();
         }
    }); 
}

function updateAirport() {
    var id = document.getElementById("apid").value;
    var name = document.getElementById("apname").value;
    var lat = document.getElementById("aplat").value;
    var lng = document.getElementById("aplng").value;
    var country_id = document.getElementById("apcountry").value;
    if(id) {
        $.ajax({
            type: "POST",
            url: '../src/ajax.php',
            data:{
                action:'update_airport',
                id: id,
                name: name,
                lat: lat,
                lng: lng,
                country_id: country_id
                },
            success:function(html) {
                alert(html);
                location.reload();
            }
        });
    }
    else {
        alert('id is missing');
    }
}

function updateAvialine() {
    var id = document.getElementById("avid").value;
    var name = document.getElementById("avname").value;
    var country_id = document.getElementById("avcountry").value;
    if(id) {
        $.ajax({
            type: "POST",
            url: '../src/ajax.php',
            data:{
                action:'update_avialine',
                id: id,
                name: name,
                country_id: country_id
                },
            success:function(html) {
                alert(html);
                location.reload();
            }
        }); 
    }
    else {
        alert('id is missing');
    }
}

function addAvialine() {
    var name = document.getElementById("avname").value;
    var country_id = document.getElementById("avcountry").value;
    if(name && country_id) {
        $.ajax({
            type: "POST",
            url: '../src/ajax.php',
            data:{
                action:'add_avialine',
                name: name,
                country_id: country_id
                },
            success:function(html) {
                alert(html);
                location.reload();
            }
        }); 
    }
    else {
        alert('some fields are missing');
    }
}

function addAirport() {
    var name = document.getElementById("apname").value;
    var lat = document.getElementById("aplat").value;
    var lng = document.getElementById("aplng").value;
    var country_id = document.getElementById("apcountry").value;
    if(name && lat && lng && country_id) {
        $.ajax({
            type: "POST",
            url: '../src/ajax.php',
            data:{
                action:'add_airport',
                name: name,
                lat: lat,
                lng: lng,
                country_id: country_id
                },
            success:function(html) {
                alert(html);
                location.reload();
            }
        });
    }
    else {
        alert('some fields are missing');
    }
}

function getAirportAvialines() {
    var id = document.getElementById("apsel").value;
    var tbodyRef = document.getElementById('airport_avialines').getElementsByTagName('tbody')[0];
    tbodyRef.textContent = "";

    $.ajax({
        type: "POST",
        url: '../src/ajax.php',
        data:{
            action:'get_airport_avialines',
            id: id
            },
        success:function(html) {
            var newRow;
            var newCell;
            let newText;
            var newSpan;

            html.forEach(row => {
                newRow = tbodyRef.insertRow()

                newCell = newRow.insertCell()
                newText = document.createTextNode(row['id'])
                newCell.appendChild(newText);
            
                newCell = newRow.insertCell();
                newText = document.createTextNode(row['name']);
                newCell.appendChild(newText);
            
                newCell = newRow.insertCell();
                newText = document.createTextNode('-');
                newSpan = document.createElement("span");   
                newSpan.appendChild(newText);
                newSpan.setAttribute('onclick', 'removeAirportAvialine('+row['id']+')');
                newCell.appendChild(newSpan);
            });


        }
    });

}

function removeAirportAvialine(id_avialine) {
    var id_airport = document.getElementById("apsel").value;
    $.ajax({
        type: "POST",
        url: '../src/ajax.php',
        data:{
            action:'remove_airport_avialine',
            id_airport: id_airport,
            id_avialine: id_avialine
            },
        success:function(html) {
            alert(html);
            getAirportAvialines();
        }
    });
}

function addAirportAvialine() {
    var id_airport = document.getElementById("apsel").value;
    var id_avialine = document.getElementById("avsel").value;
    $.ajax({
        type: "POST",
        url: '../src/ajax.php',
        data:{
            action:'add_airport_avialine',
            id_airport: id_airport,
            id_avialine: id_avialine
            },
        success:function(html) {
            alert(html);
            getAirportAvialines();
        }
    });
}