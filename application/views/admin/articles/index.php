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
									<h3 class="box-title"><?php echo anchor('admin/articles/create', '<i class="fa fa-plus"></i> '. lang('articles_create_article'), array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
								</div>
								<div class="box-body">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th><?php echo lang('articles_firstname');?></th>
												<th><?php echo lang('articles_lastname');?></th>
												<th><?php echo lang('articles_email');?></th>
												<th><?php echo lang('articles_groups');?></th>
												<th><?php echo lang('articles_status');?></th>
												<th><?php echo lang('articles_action');?></th>
											</tr>
										</thead>
										<tbody>
<?php foreach ($users as $user):?>
											<tr>
												<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
												<td>
<?php

foreach ($user->groups as $group)
{

	// Disabled temporary !!!
	// echo anchor('admin/groups/edit/'.$group->id, '<span class="label" style="background:'.$group->bgcolor.';">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>');
	echo anchor('admin/groups/edit/'.$group->id, '<span class="label label-default">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>');
}

?>
												</td>
												<td><?php echo ($user->active) ? anchor('admin/articles/deactivate/'.$user->id, '<span class="label label-success">'.lang('articles_active').'</span>') : anchor('admin/articles/activate/'. $user->id, '<span class="label label-default">'.lang('articles_inactive').'</span>'); ?></td>
												<td>
													<?php echo anchor('admin/articles/edit/'.$user->id, lang('actions_edit')); ?>
													<?php echo anchor('admin/articles/profile/'.$user->id, lang('actions_see')); ?>
												</td>
											</tr>
<?php endforeach;?>
										</tbody>
									</table>
								</div>
							</div>
						 </div>
					</div>
				</section>
			</div>
