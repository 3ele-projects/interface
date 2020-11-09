<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#basicExampleModal">Kontakt</button>

<!-- Modal -->
<div class="modal" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kontakt</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo do_shortcode('[contact-form-7  title="modal"]'); ?>
    </div>
  </div>
</div>