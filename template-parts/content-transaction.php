          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Investitionen</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Startdatum</th>
                      <th>Enddatum</th>

                      <th>Projekt</th>
                      <th>Summe</th>
                      <th>Rendite</th>
                      <th>Auszahlung (pro Monat)</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    global $transactions;
                    foreach ($transactions->posts as $transaction) : ?>
                      <?php $pay_out = $transaction->invest / 100 * $transaction->rendite; ?>
                      <tr>
                        <td><?php echo get_field('start_date', $transaction->ID); ?></td>
                        <td><?php echo get_field('end_date', $transaction->ID); ?></td>
                        <td><?php echo get_the_title($transaction->project_id); ?></td>
                        <td><?php echo add_thousand_sep($transaction->invest); ?> €</td>
                        <td><?php echo $transaction->rendite; ?> % </td>
                        <td><?php echo add_thousand_sep($pay_out); ?> €</td>

                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>