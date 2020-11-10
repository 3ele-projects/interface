<?php global $project; ?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Dokumente für <?php the_title(); ?></h6>
  </div>
  <div class="card-body">
    <?php if ($project->docs) : ?>
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

            <?php foreach ($project->docs as $doc) : ?>


              <tr>
                <td><?php echo $doc->post_title; ?></td>

                <td><a class="btn btn-primary download" href="<?php echo $doc->guid; ?>">Download</a></td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    <?php else : ?>
      Keine Dokumente vorhanden
    <?php endif; ?>
  </div>
</div>

<script>
jQuery( ".download" ).click(function(event) {
  console.log(this);
  event.preventDefault();
  var addressValue =  jQuery(this).attr("href");
 //       alert(addressValue );
  //window.open('https://docs.google.com/gview?url=urltoyour.pdf')
  jQuery('<iframe>', {
   src: addressValue ,
   id:  'myFrame',
   frameborder: 0,
   scrolling: 'no'
   }).appendTo('body');
});

</script>