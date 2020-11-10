<?php global $transactions; ?>
<?php 

global $wp;
$current_url = home_url( add_query_arg( array(), $wp->request ) );
?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Dokumente</h6>
  </div>
  <div class="card-body">
    <?php if ($transactions->docs) : ?>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Download</th </tr> </thead> <tfoot>
            <tr>
              <th>Name</th>
              <th>Download</th>
            </tr>
            </tfoot>
          <tbody>

            <?php foreach ($transactions->docs as $doc) : ?>
              <tr>
                <td><?php echo $doc->post_title; ?></td>
                <td><a class="btn btn-primary"   href="<?php echo $current_url// $doc->guid; ?>" download="<?php echo $doc->post_title; ?>">Download</a></td>
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

<?php 
//header("Content-Type: application/octet-stream"); 
  
//$file = $_GET["file"]  . ".pdf"; 
  
//header("Content-Disposition: attachment; filename=" . urlencode($file));    
//header("Content-Type: application/download"); 
//header("Content-Description: File Transfer");             
//header("Content-Length: " . filesize($file)); 
  
//flush(); // This doesn't really matter. 
  
//$fp = fopen($file, "r"); 
//while (!feof($fp)) { 
//    echo fread($fp, 65536); 
//    flush(); // This is essential for large downloads 
//}  
  
//fclose($fp);  
?>