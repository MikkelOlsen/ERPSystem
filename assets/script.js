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
            url: $('#baseurl').text() + 'Api/Services',
            data: {
                id: element[0],
                name: element[1],
                hours: element[2],
                rate: element[3]
            },
            dataType: 'html'
        })
        .done(function(data) {
            console.log("SUCCESS")
        })
        .fail(function() {
            console.warn("FAILED")
        });
        
    });

    
    //location.reload();
}

function updateInvoice() {
        $.ajax({
            method: 'POST',
            url: $('#baseurl').text() + 'Api/Invoice',
            data: {
                id: JSON.stringify(event.target.id)
            },
            dataType: 'html'
        })
        .done(function(data) {
            console.log("SUCCESS")
        })
        .fail(function() {
            console.warn("FAILED")
        });
        

    
    //location.reload();
}
