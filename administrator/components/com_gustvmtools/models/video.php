<?php// ������ ������� �������.defined('_JEXEC') or die; // ���������� ���������� modellist Joomla.jimport('joomla.application.component.modeladmin'); /** * ������ ������ ��������� ���������� HelloWorld. */class gustVMtoolsModelVideo extends JModelAdmin{    /**     * ����� ��� ���������� SQL ������� ��� �������� ������ ������.     *     * @return string SQL ������.     */	public function getForm($data = array(), $loadData = true) 	{		 // Get the form.		 $form = $this->loadForm('com_gustvmtools.video', 'video', array('load_data' => $loadData));		 if (empty($form)) 		 {		 return false;		 }		 return $form;	}	protected function loadFormData()	{		$id = JRequest::getVar('id');		$table = JModel::getTable('video');		$table->load($id);		if (JRequest::getVar('product_id'))		{			$table->product_id = JRequest::getVar('product_id');		}		$data = $table;		return $data;	}	    public function set_video_change()	{		$row =& JTable::getInstance('video', 'Table');		$form = JRequest::get('post');		$row->bind($form);		$row->check($form);		$row->store($form, true);	}	 public function add_video()	{		$row =& JTable::getInstance('video', 'Table');		$form = JRequest::get('post');		$row->bind($form);		$row->check($form);		$row->store($form, true);	}}