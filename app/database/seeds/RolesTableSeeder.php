<?php
use Illuminate\Database\Seeder;
class RolesTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('roles')->delete();
		$roles = array(
				['name' => 'Admin', 'description' => 'Hat alle Berechtigungen'],
				['name' => 'Lehrplanung', 'description' => 'Hat Einblick in alle Planungen und kann diese bearbeiten, vergibt LV-Nummern für Projekt, Seminar etc.'],
				['name' => 'Raumplanung', 'description' => 'Zuständig für die Raum- und Zeitplanungen, hat Einblick in alle Planungen'],
				['name' => 'Lokale Lehrplanung', 'description' => 'Zuständig für die Planung von Lehrveranstaltungen von zugewiesenen Arbeitsbereichen'],
		);
		DB::table('roles')->insert($roles);
	}
}