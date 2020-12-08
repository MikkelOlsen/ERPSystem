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

<pre>
  <?php
    var_dump(Invoice::fetchAllInvoices());
  ?>
  </pre>
