<?php
defined('_JEXEC') or die;

class PxrdshealthboxModelOrgs extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array('id', 'a.id',
											'name', 'a.name',
											'state', 'a.state',	
											'ordering', 'a.ordering');
											
		}
		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)	
	{
		$app = JFactory::getApplication();

		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');		
		$this->setState('filter.state', $published);

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		parent::populateState('a.ordering', 'asc');
	}

	protected function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select(
						$this->getState(
						'list.select',
						'a.id, a.name,'.
						' a.state, a.logo,'.
						' a.login_url, a.registration_url,'.
						'a.home_url,a.ordering')						
					 
					);
		
		$query->from($db->quoteName('#__xrds_portals').' AS a');

		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		$published = $this->getState('filter.state');
		if (is_numeric($published))
		{
			$query->where('a.state = '.(int) $published);
		} 
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in name
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = '.(int) substr($search, 3));
			} 
			else 
			{
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where(' a.name LIKE '.$search);			
			}
		}

		if ($orderCol == 'a.ordering')
		{
			$orderCol = 'a.ordering';
		}

		$query->order($db->escape($orderCol.' '.$orderDirn));
		
		return $query;
	}
}