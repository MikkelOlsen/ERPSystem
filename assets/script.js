function openModal(id) {
    document.getElementById("modal-" + id).classList.add("is-active")
}

function closeModal(id) {
    document.getElementById("modal-" + id).classList.remove("is-active")
}

function updateServices() {
    var postData = []
    $('#modalTBody-' + event.target.id + ' td').each(function() {
        var row = this.parentElement.rowIndex - 1 //Exclude the header row
        while (row >= postData.length) {
            postData.push([])
        }
        postData[row].push($(this).text())
    })


    
    postData.forEach(element => {
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
            console.log(data)
            $.each(data.msg, function(key, value) {
                console.log(value)
            }) 
        })
        .fail(function() {
            console.log("A failure occured.")
        });
        
    });

    
    //location.reload();
}

function updateInvoice() {
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
        

    
    location.reload();
}
