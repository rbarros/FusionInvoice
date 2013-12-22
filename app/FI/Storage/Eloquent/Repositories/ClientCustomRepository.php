<?php namespace FI\Storage\Eloquent\Repositories;

use FI\Storage\Eloquent\Models\ClientCustom;

class ClientCustomRepository implements \FI\Storage\Interfaces\ClientCustomRepositoryInterface {

	public function save($input, $clientId)
	{
		$record = (ClientCustom::find($clientId)) ?: new ClientCustom;

		$record->client_id = $clientId;
		
		$record->fill($input);

		$record->save();
	}

}