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
                                    <h3 class="box-title"><?php echo lang('bettips_create_bettip'); ?></h3>
                                </div>
                                <div class="box-body">
                                   <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_tip')); ?>
                                       <div class="form-group">
                                            <?php echo lang('bettips_home', 'home_team', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($home_team);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('bettips_away', 'away_team', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($away_team);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('bettips_odds', 'odds', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($odds);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('bettips_prediction', 'prediction', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($prediction);?>
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('bettips_result', 'result', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($result);?>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <?php echo lang('bettips_competition', 'result', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($competition);?>
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                                    <?php echo anchor('admin/users', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>



                                
                                   
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
            </div>
