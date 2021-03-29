<?php
class ServicesToBooking_model extends MY_Model
{
    public $table = 'services_to_booking';

    public function save($bookingId, $services)
	{
		$this->deleteByKey('booking_id', $bookingId);
		foreach ($services as $serviceId) {
			var_dump($bookingId, $serviceId);exit;
			$this->update(['booking_id' => $bookingId, 'service_id' => $serviceId]);
		}
	}

	public function getById($id)
	{
		if (!$id) {
			return [];
		}
		$params = [
			'filters' => [
				[
					'field' => 'booking_id',
					'operand' => '=',
					'value' => $id
				]
			]
		];
		$res = $this->get($params);
		$result = [];

		foreach ($res as $r) {
			$result[] = $r['service_id'];
		}

		return $result;
	}
}
