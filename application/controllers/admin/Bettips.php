<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bettips extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		/* Load :: Common */
		$this->lang->load('admin/bettips');

		//load model
		 $this->load->model('admin/tips_model');

		/* Title Page :: Common */
		$this->page_title->push(lang('menu_bettips'));
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_bettips'), 'admin/bettips');
	}


	public function index()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			// /* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();

			// /* Get all articles */
			// $this->data['bettips'] = $this->ion_auth->users()->result();
			// foreach ($this->data['bettips'] as $k => $user)
			// {
			// 	$this->data['bettips'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			// }

			$query = $this->tips_model->getBettips();
			$data['bettips'] = null;
				if($query){
				$data['bettips'] =  $query;
				}
				// }else{
				// $data['bettips'] =  $this->db->error();	
				// }

			//$this->$data['bettips'] = "George";

				//$this->$data['bettips'] = [0 => 1, 1 =>2];
			// $this->load->view('index.php', $data);
			// }			

			/* Load Template */
			$this->template->admin_render('admin/bettips/index', $this->data);
		}
	}


	public function create()
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_bettips_create'), 'admin/bettips/create');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
        

        /* Variables */
		$tables = $this->config->item('tables', 'ion_auth');

		/* Validate form input */
		$this->form_validation->set_rules('home_team', 'lang:bettips_home', 'required');
		$this->form_validation->set_rules('away_team', 'lang:bettips_away', 'required');
		$this->form_validation->set_rules('odds', 'lang:bettips_odds', 'required');
	    $this->form_validation->set_rules('prediction', 'lang:bettips_prediction', 'required');
	    $this->form_validation->set_rules('result', 'lang:bettips_result', 'required');
	    $this->form_validation->set_rules('competition', 'lang:bettips_competition', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$fixture =  ucfirst($this->input->post('home_team')) . ' vs ' . ucfirst($this->input->post('away_team'));
			$odds    =  $this->input->post('odds');
			$prediction = $this->input->post('prediction');
			$result = " "
			$competition_id = $this->input->post('competition');
			
			$timestamp = new DateTime();			
			$date_submitted = $timestamp->format(DateTime::ISO8601);

			$date_ended  = " ";
			$submitted_by  = $this->session->userdata('name');


			$additional_data = array(
				'fixture' => $fixture,
				'odds'  => $odds,
				'prediction' => $prediction,
				'result' => $result,
				'competition' => $competition_id,
				'date_submitted' => $date_submitted,
				'date_ended' => $date_ended,
				'submitted_by' => $submitted_by,
			);
		}

		if ($this->form_validation->run() == TRUE && $this->createTip($additional_data/*, $email, $additional_data*/))
		{
			//$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('admin/bettips', 'refresh');
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['home_team'] = array(
				'name'  => 'home_team',
				'id'    => 'home_team',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('home_team'),
			);
			$this->data['away_team'] = array(
				'name'  => 'away_team',
				'id'    => 'away_team',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('away_team'),
			);
			$this->data['odds'] = array(
				'name'  => 'odds',
				'id'    => 'odds',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('odds'),
			);	
			$this->data['prediction'] = array(
				'name'  => 'prediction',
				'id'    => 'prediction',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('prediction'),
			);	

			$this->data['result'] = array(
				'name'  => 'result',
				'id'    => 'result',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('result'),
			);	

			$this->data['competition'] = array(
				'name'  => 'competition',
				'id'    => 'competition',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('competition'),
			);	
		}
				
		/* Load Template */
		$this->template->admin_render('admin/bettips/create', $this->data);		
	}


	public function delete()
	{
		/* Load Template */
		$this->template->admin_render('admin/articles/delete', $this->data);
	}


	public function edit($id)
	{
		$id = (int) $id;

		if ( ! $this->ion_auth->logged_in() OR ( ! $this->ion_auth->is_admin() && ! ($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_articles_edit'), 'admin/articles/edit');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Data */
		$user          = $this->ion_auth->user($id)->row();
		$groups        = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_articles_groups($id)->result();

		/* Validate form input */
		$this->form_validation->set_rules('first_name', 'lang:edit_user_validation_fname_label', 'required');
		$this->form_validation->set_rules('last_name', 'lang:edit_user_validation_lname_label', 'required');
		$this->form_validation->set_rules('phone', 'lang:edit_user_validation_phone_label', 'required');
		$this->form_validation->set_rules('company', 'lang:edit_user_validation_company_label', 'required');

		if (isset($_POST) && ! empty($_POST))
		{
			if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() == TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone')
				);

				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				if ($this->ion_auth->is_admin())
				{
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData))
					{
						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}

				if($this->ion_auth->update($user->id, $data))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());

					if ($this->ion_auth->is_admin())
					{
						redirect('admin/articles', 'refresh');
					}
					else
					{
						redirect('admin', 'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());

					if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}
				}
			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user']          = $user;
		$this->data['groups']        = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('first_name', $user->first_name)
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('last_name', $user->last_name)
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('company', $user->company)
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'tel',
			'pattern' => '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('phone', $user->phone)
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'class' => 'form-control',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'class' => 'form-control',
			'type' => 'password'
		);


		/* Load Template */
		$this->template->admin_render('admin/articles/edit', $this->data);
	}


	function activate($id, $code = FALSE)
	{
		$id = (int) $id;

		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('admin/articles', 'refresh');
		}
		else
		{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('auth/forgot_password', 'refresh');
		}
	}


	public function deactivate($id = NULL)
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_articles_deactivate'), 'admin/articles/deactivate');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Validate form input */
		$this->form_validation->set_rules('confirm', 'lang:deactivate_validation_confirm_label', 'required');
		$this->form_validation->set_rules('id', 'lang:deactivate_validation_user_id_label', 'required|alpha_numeric');

		$id = (int) $id;

		if ($this->form_validation->run() === FALSE)
		{
			$user = $this->ion_auth->user($id)->row();

			$this->data['csrf']       = $this->_get_csrf_nonce();
			$this->data['id']         = (int) $user->id;
			$this->data['firstname']  = ! empty($user->first_name) ? htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8') : NULL;
			$this->data['lastname']   = ! empty($user->last_name) ? ' '.htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8') : NULL;

			/* Load Template */
			$this->template->admin_render('admin/articles/deactivate', $this->data);
		}
		else
		{
			if ($this->input->post('confirm') == 'yes')
			{
				if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			redirect('admin/articles', 'refresh');
		}
	}


	public function profile($id)
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_articles_profile'), 'admin/groups/profile');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Data */
		$id = (int) $id;

		$this->data['user_info'] = $this->ion_auth->user($id)->result();
		foreach ($this->data['user_info'] as $k => $user)
		{
			$this->data['user_info'][$k]->groups = $this->ion_auth->get_articles_groups($user->id)->result();
		}

		/* Load Template */
		$this->template->admin_render('admin/articles/profile', $this->data);
	}


	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}


	public function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	public function createTip($additional_data){
		$this->tips_model->createTip($additional_data);
	}
}
