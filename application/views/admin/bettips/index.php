<?php
defined('BASEPATH') OR exit('No direct script access allowed');


?>

			<div class="content-wrapper">
				<section class="content-header">
					<?php echo $pagetitle; ?>
					<?php echo $breadcrumb; ?>
				</section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							 <div class="box">
								<div class="box-header with-border">
									<h3 class="box-title"><?php echo anchor('admin/bettips/create', '<i class="fa fa-plus"></i> '. lang('bettips_create_bettip'), array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
								</div>
								<div class="box-body">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th><?php echo lang('bettips_id');?></th>
												<th><?php echo lang('bettips_fixture');?></th>
												<th><?php echo lang('bettips_odds');?></th>
												<th><?php echo lang('bettips_prediction');?></th>
												<th><?php echo lang('bettips_result');?></th>
												<th><?php echo lang('bettips_date_submitted');?></th>
											</tr>
										</thead>
										<tbody>
<?php var_dump($bettips); ?>
<?php foreach($bettips as $bettip){ ?> 
											<tr>
												<td><?php echo htmlspecialchars($bettip->id, ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($bettip->fixture, ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($bettip->odds, ENT_QUOTES, 'UTF-8'); ?></td>
</tr> 
<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						 </div>
					</div>
				</section>
			</div>
