<?php
class Apartments_model extends MY_Model
{
    public $table = 'apartments';
    public $hashedId = "10000";

    public function get($params = [])
    {
        if (!isset($params['order'])) {
            $params['order'] = ['orderBy' => 'address'];
        }
        return parent::get($params);
    }

    public function prepare($apartments)
    {
        $result = [];
        foreach ($apartments as $apartment) {
            $result[$apartment['id']] = $apartment['address'];
        }
        return $result;
    }
	
	public function getLastCleanDate($id) {
		$this->table = 'clean_history';
		$filters = [
			'filters' => [['field' => 'apartment_id', 'operand' => '=', 'value' => $id]],
			'select' => 'date',
			'limit' => 1,
			'offset' => 0,
			'order' => ['orderBy' => 'date', 'direction' => 'desc']
		];
		$res = parent::get($filters);
		$this->table = 'apartments';
		return !empty($res) ? $res[0]['date'] : null;
	}

	public function getCleanHistory($id, $limit) {
		$this->table = 'clean_history';
		$filters = [
			'filters' => [['field' => 'apartment_id', 'operand' => '=', 'value' => $id]],
			'select' => 'date',
			'index' => 'date',
			'limit' => $limit,
			'order' => ['orderBy' => 'date', 'direction' => 'desc']
		];
		$res = parent::get($filters);
		$this->table = 'apartments';
		return $res;
	}
	
	public function update($data) {
    	array_extract($data, 'clean_link');
		$id = isset($data['id']) ? $data['id'] : null;
		$lastCleanDateToUpdate = null;
		$result = true;

		if (isset($data['last_clean_date'])) {
			$lastCleanDateToUpdate = array_extract($data, 'last_clean_date');
		}

		if (!empty($data)) {
			$result = parent::update($data);
		}

		if (!$id) {
			$id = $this->getLastId();
		}

		if ($result && $id && $lastCleanDateToUpdate) {
			$this->updateLastCleanDate($id, user('id'), $lastCleanDateToUpdate);
		}
	}

	public function updateLastCleanDate($apartmentId, $userId, $lastCleanDateToUpdate) {
		$lastCleanDate = $this->getLastCleanDate($apartmentId);
		if (!$lastCleanDate || $lastCleanDate != date('Y-m-d', strtotime($lastCleanDateToUpdate))) {
			$lastCleanDateToUpdate = $lastCleanDateToUpdate . " " . date('H:i:s');
			parent::update(['id' => $apartmentId, 'last_clean_date' => $lastCleanDateToUpdate]);
			$this->table = 'clean_history';
			parent::update(['apartment_id' => $apartmentId, 'user_id' => $userId, 'date' => $lastCleanDateToUpdate]);
			$this->table = 'apartments';
		}
	}

	public function getCleanLink($id) {
    	return base_url('/apartments/clean/'.md5($id . $this->hashedId));
	}

	public function getByHash($hash) {
		$apartments = parent::get();
		foreach ($apartments as $ap) {
			if (md5($ap['id'] . $this->hashedId) == $hash) {
				return $ap;
			}
		}
		return null;
	}
	
}
