<?php// ������ ������� �������.defined('_JEXEC') or die; // ���������� ���������� modellist Joomla.jimport('joomla.application.component.modeladmin'); /** * ������ ������ ��������� ���������� HelloWorld. */class gustVMtoolsModelOpisanie extends JModelAdmin{    /**     * ����� ��� ���������� SQL ������� ��� �������� ������ ������.     *     * @return string SQL ������.     */	public function getForm($data = array(), $loadData = true) 	{		 // Get the form.		 $loadData= array('product_id' => JRequest::getVar('product_id'));		 $form = $this->loadForm('com_gustvmtools.opisanie', 'opisanie', array('load_data' => $loadData));		 if (empty($form)) 		 {		 return false;		 }		 return $form;	}	protected function loadFormData()	{		$id = JRequest::getVar('id');		$table = JModel::getTable('opisanie');		$table->load($id);		$data = $table;		if (JRequest::getVar('product_id'))		{			$table->product_id = JRequest::getVar('product_id');		}		return $data;	}	    public function set_opisanie_change()	{        $row =& JTable::getInstance('opisanie', 'Table');		$form = JRequest::get('post');        $form['text'] = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWHTML );        $row->bind($form);		$row->check($form);		$row->store($form, true);	}	 public function add_opisanie()	{		$row =& JTable::getInstance('opisanie', 'Table');		$form = JRequest::get('post');        $form['text'] = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWHTML );		$row->bind($form);		$row->check($form);		$row->store($form, true);	}}