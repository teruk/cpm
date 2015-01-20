<?php

use Illuminate\Database\Seeder;
class ResearchGroupsTableSeeder extends Seeder 
{
	
	public function run()
	{
		$research_groups = array(
				['name' => 'Human-Computer Interaction', 'short' => 'MCI', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Natural Language Systems Division', 'short' => 'NATS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Kognitive Systeme', 'short' => 'KOGS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Technical Aspects of Multimodal Systems', 'short' => 'TAMS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Wissens- und Sprachverarbeitung', 'short' => 'WSV', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Knowledge Technology Group', 'short' => 'WTM', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Datenbanken und Informationssysteme', 'short' => 'ISYS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Informationstechnikgestaltung und Genderperspektive', 'short' => 'ITG', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'IT-Management und -Consulting', 'short' => 'ITMC', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Modellbildung und Simulation', 'short' => 'MBS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Mobile Services & Software Engineering', 'short' => 'MOBIS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Sicherheit in verteilten Systemen', 'short' => 'SVS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Softwaretechnik', 'short' => 'SWT', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Softwareentwicklungs- und konstruktionsmethoden', 'short' => 'SWK', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Theoretische Grundlagen der Informatik', 'short' => 'TGI', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Telekommunikation und Rechnernetze', 'short' => 'TKRN', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Verteilte Systeme', 'short' => 'VSYS', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Algorithmisches Molekulares Design', 'short' => 'AMD', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Machine Learning Group', 'short' => 'ML', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Wissenschaftliches Rechnen', 'short' => 'WR', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Wissenschaftliche Visualisierung und Parallelverarbeitung', 'short' => 'WVP', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Angewandte und Sozialorientierte Informatik', 'short' => 'ASI', 'department_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
		);
		DB::table('researchgroups')->insert($research_groups);
	}
}
