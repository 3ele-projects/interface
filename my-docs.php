<?php

/**
 * Template Name: My Docs
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Interface
 */

get_header();
?>
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">
    <main id="primary" class="site-main">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary"><?php the_title(); ?></h6>
        </div>
        <div class="card-body">
          <?php

          $user_id = get_current_user_id();
          $trans_obj = new wp_transactions();
          global $trans_obj;

          $transactions = $trans_obj->get_all_transaction_obj($user_id);
          global $transactions;
          if (property_exists($transactions, 'posts')) :

          ?>
            <div class="table-responsive">

              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Download</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>

                    <th>Download</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($transactions->docs as $doc) : ?>
                    <tr>
                      <td><?php echo $doc->post_title; ?></td>
                      <td><a class="btn btn-primary" target="_blank" href="<?php echo $doc->guid; ?>">Download</a></td>
                    </tr>
                  <?php endforeach; ?>

                </tbody>
              </table>
            <?php else : ?>
              Keine Dokumente vorhanden
            <?php endif; ?>
            </div>
        </div>
      </div>

    </main><!-- #main -->
  </div>
  <!-- End of Main Content -->

  <?php

  get_footer();
