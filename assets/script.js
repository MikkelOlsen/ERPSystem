function openModal(id) {
    document.getElementById("modal-" + id).classList.add("is-active")
}

function closeModal(id) {
    document.getElementById("modal-" + id).classList.remove("is-active")
}

function updateServices() {
    //Initialize variables
    var postData = []
    var id = event.target.id
    var err = false

    //Loop through the table in the current modal and build a multi dimensional array from the table rows and columns.
    $('#modalTBody-' + id + ' td').each(function() {
        var row = this.parentElement.rowIndex - 1 //Exclude the header row
        while (row >= postData.length) {
            postData.push([])
        }
        postData[row].push($(this).text())
    })


    $('#errorBox-' + id).html("")
    var count = 0;

    /*
    Run an ajax call for each index in multidimensional array.
    Data is sent to PHP API page, which handles validation of data and insertion / update.

    If there are any errors returned, print these to the user, otherwise refresh the page to display new data.
    */
    for(const [i, element] of postData.entries()) {
        $.ajax({
            method: 'POST',
            url: $('#baseurl').text() + 'ServicesAPI',
            data: {
                id: element[0],
                name: element[1],
                hours: element[2],
                rate: element[3]
            },
            dataType: 'JSON'
        })
        .done(function(data) {
            if(data.err == true) {
                $.each(data.msg, function(key, value) {
                    $('#errorBox-' + id).append(value + '</br>')
                }) 
                err = true
            }
            if(count == i) {
                if(err == false) {
                    location.reload()
                }
            }
            count++
        })
        .fail(function(data) {
            console.log("A failure occured.")
            console.log(data)
        });

        
    }
    
    
}

function updateInvoice() {
      /*
        Run an ajax call for the invoice that was clicked on.
        Data is sent to PHP API page, which handles validation of data and insertion / update.

        Then reload page to display new data.
        */
        $.ajax({
            method: 'POST',
            url: $('#baseurl').text() + 'InvoiceAPI',
            data: {
                id: event.target.id
            },
            dataType: 'html'
        })
        .done(function(data) {
            console.log("SUCCESS")
        })
        .fail(function() {
            console.warn("FAILED")
        });
        

    
    location.reload()
}
