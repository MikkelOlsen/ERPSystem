<div class="box" >
    <h1 class="title is-1">Your invoices</h1>
    <h3 class="subtitle is-3">
        Here you will find all your invoices, ready for approval and flagged if something is wrong.
    </h3>
<table class="table" id="invoiceTable">
  <thead>
    <tr>
      <th></th>
      <th>Company</th>
      <th>Date</th>
      <th>Billed to</th>
      <th>Approved</th>
      <th>Total</th>
    </tr>
  </thead>
  
  <tbody>
    <?php
        foreach (Invoice::fetchAllInvoices() as $key => $value) {
            $approved = ($value->invoiceApproved == "0") ? "Not approved" : "Approved";
            $flagged = ($value->invoiceApproved == "0") ? "<span class='icon has-text-warning' onclick='openModal(".$value->invoiceid.")'> <i class='fas fa-exclamation-triangle'></i></span>" : "";
          
            echo '<tr>';
            echo '<td>' . $flagged . '</td>';
            echo '<td>' . $value->company . '</td>';
            echo '<td>' . $value->date . '</td>';
            echo '<td>' . $value->billedTo . '</td>';
            echo '<td>' . $approved . '</td>';
            echo '<td>' . $value->total .'</td>';
            echo '</tr>';
        }
    ?>
  </tbody>
</table>
<div class="modalBox">
<?php
    foreach (Invoice::fetchAllInvoices() as $key => $value) {
        echo '<div class="modal" id="modal-'.$value->invoiceid.'">
        <div class="modal-background"></div>
        <div class="modal-content">
        <div class="box">';
        
        echo '<table class="table" id="modalTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<td>Name</td>';
        echo '<td>Hours</td>';
        echo '<td>Rate</td>';
        echo '<td>Total:</td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach (Service::fetchServices($value->invoiceid) as $services => $service) {
            echo '<tr>';
            echo '<td>' . $service->name . '</td>';
            echo '<td>' . $service->hours . '</td>';
            echo '<td>' . $service->rate . '</td>';
            echo '<td>' . $service->total . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';

        echo '</div></div>
        <button class="modal-close is-large" aria-label="close" onclick="closeModal('.$value->invoiceid.')"</button>
        </div>';
    }
?>
</div>
</div>
