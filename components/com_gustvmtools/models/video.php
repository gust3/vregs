<?php// ������ ������� �������.defined('_JEXEC') or die; // ���������� ���������� modellist Joomla.jimport('joomla.application.component.modellist'); /** * ������ ������ ��������� ���������� HelloWorld. */class gustVMtoolsModelVideo extends JModelList{    /**     * ����� ��� ���������� SQL ������� ��� �������� ������ ������.     *     * @return string SQL ������.     */	 	public function __construct($config = array())	 {		parent::__construct($config);	 }	protected function getListQuery()    {        // ������� ����� query ������.        $db = JFactory::getDBO();        $query = $db->getQuery(true);        $query->select('*');        $query->from('#__vmtools_videos');		$query->order("id DESC");		        return $query;    }	protected function populateState($ordering = null, $direction = null)	{		parent::populateState('id', 'asc');	}}