<?php// ������ ������� �������.defined('_JEXEC') or die; // ���������� ���������� modellist Joomla.jimport('joomla.application.component.modeladmin'); /** * ������ ������ ��������� ���������� HelloWorld. */class gustVMtoolsModelProduct extends JModelAdmin{    /**     * ����� ��� ���������� SQL ������� ��� �������� ������ ������.     *     * @return string SQL ������.     */	public function getForm($data = array(), $loadData = true) 	{		 // Get the form.		 $form = $this->loadForm('com_gustvmtools.product', 'product', array('load_data' => $loadData));		 if (empty($form)) 		 {		 return false;		 }		 return $form;	}	protected function loadFormData()	{		$id = JRequest::getVar('id');		$table = JModel::getTable('products');		$table->load($id);		$data = $table;		return $data;	}	    public function set_product_change()	{		$row =& JTable::getInstance('products', 'Table');		$form = JRequest::get('post');		$row->bind($form);		$row->check($form);		$row->store($form, true);	}	 public function add_product()	{		$row =& JTable::getInstance('products', 'Table');		$form = JRequest::get('post');		$row->bind($form);		$row->check($form);		$row->store($form, true);	}}