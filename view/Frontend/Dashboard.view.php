 <div class="box">
 <nav class="level">
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Total invoices</p>
      <p class="title"><?= count(Invoice::fetchAllInvoices()) ?></p>
    </div>
  </div>
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Invoices not approved</p>
      <p class="title"><?= count(Invoice::fetchNotApprovedInvoices()) ?></p>
    </div>
  </div>
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Invoices approved</p>
      <p class="title"><?= count(Invoice::fetchApprovedInvoices()) ?></p>
    </div>
  </div>
</nav>
 </div>
 <div class="box" >
    <h3 class="subtitle is-3">
        Invoice overview
    </h3>
<table class="table" id="invoiceTable">
  <thead>
    <tr>
      <th>Status</th>
      <th>Company</th>
      <th>Date</th>
      <th>Billed to</th>
      <th>Approved</th>
      <th>Total</th>
      <th>Approve invoice</th>
    </tr>
  </thead>
  
  <tbody>
    <?php
        foreach (Invoice::fetchAllInvoices() as $key => $value) {
          $approved = "Approved";
          $flagged = '<p><span class="icon has-text-success"><i class="fas fa-check-square"></i></span> Invoice approved</p>';
          $approveButton = '<button class="button is-primary is-fullwidth" onclick="updateInvoice()" title="Disabled button" id="' . $value->invoiceid . '" disabled>Invoice already approved</button>';

          if($value->invoiceApproved == "0") {
            $approved = "Not approved";
            $flagged = '<p><span class="icon has-text-info"><i class="fas fa-pen"></i></span> Ready for approval</p>';
            if(count(Service::serviceCheck($value->invoiceid)) !== 0) {
              $flagged = "<p onclick='openModal(".$value->invoiceid.")' class='clickable'><span class='icon has-text-warning'> <i class='fas fa-exclamation-triangle'></i></span> Unapproved service!</p>";
              $approveButton = '<button class="button is-primary is-fullwidth" onclick="updateInvoice()" title="Disabled button" id="' . $value->invoiceid . '" disabled>Not all services are approved!</button>';
            } else {
              $approveButton = '<button class="button is-primary is-fullwidth" onclick="updateInvoice()" id="' . $value->invoiceid . '">Approve Invoice</button>';
            }
          }

          
            echo '<tr id="invoiceRow-' . $value->invoiceid . '">';
            echo '<td>' . $flagged . '</td>';
            echo '<td>' . $value->company . '</td>';
            echo '<td>' . $value->date . '</td>';
            echo '<td>' . $value->billedTo . '</td>';
            echo '<td>' . $approved . '</td>';
            echo '<td>' . $value->total .'</td>';
            echo '<td>' . $approveButton . '</td>';
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
        echo '<td style="display:none;"></td>';
        echo '<td>Name</td>';
        echo '<td>Hours</td>';
        echo '<td>Rate</td>';
        echo '<td>Total:</td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody id="modalTBody-' . $value->invoiceid . '">';
        foreach (Service::fetchServices($value->invoiceid) as $services => $service) {
            echo '<tr>';
            echo '<td style="display:none;">' . $service->id . '</td>';
            echo '<td contenteditable="true">' . $service->name . '</td>';
            echo '<td contenteditable="true">' . $service->hours . '</td>';
            echo '<td contenteditable="true">' . $service->rate . '</td>';
            echo '<td>' . $service->total . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '<div class="columns"><button class="button is-primary is-fullwidth" onclick="updateServices()" id="' . $value->invoiceid . '">Save services</button></div>';
        echo '</div></div> <button class="modal-close is-large" aria-label="close" onclick="closeModal('.$value->invoiceid.')"</button></div>';
    }
?>
</div>
</div>
<p>Test V#</p>
