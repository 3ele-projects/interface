<?php
global $project;

$marktwert = get_field('complete_invest', $project->ID);
$complete_invests = $project->invests;
$first_invest_time_obj = get_the_first_invest_time_obj(get_the_ID());
$first_invest_time = get_field('end_date', $first_invest_time_obj->ID);
$first_invest = get_field('invest', $first_invest_time_obj->ID);
//var_dump($first_invest_time );
$procent = round($complete_invests / ($marktwert / 100));
$rest_invest = round(100 - $procent);
$new_invest = round(($marktwert - $complete_invests), 2);

?>

<?php
if ($first_invest_time >= date('Ymd')) :
	$action = 'Ab dem ' . $first_invest_time . ' können wieder ' . $new_invest . '€ investiert werden';
else :
	$action = 'Es kann ' . $new_invest . '€ investiert werden';

endif;

?>

<div class="progress mb-4" style="">
	<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $procent; ?>%" aria-valuenow="<?php echo $procent; ?>" aria-valuemin="0" aria-valuemax="100">
		<?php echo $procent; ?>% belegt</div>
	<?php if ($rest_invest > 0) : ?>
		<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $rest_invest; ?>%" aria-valuenow="<?php echo $rest_invest ?>%" aria-valuemin="0" aria-valuemax="100"><?php echo $rest_invest; ?>%</div>
	<?php endif; ?>
</div>