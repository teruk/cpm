<?php
use Illuminate\Database\Seeder;
class PermissionsTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('permissions')->delete();
		$permissions = array(
			['name' => 'add_module', 'display_name' => 'Modul erstellen', 'description' => 'Ermöglicht das Anlegen von Modulen.'], // 1
			['name' => 'edit_module', 'display_name' => 'Modul bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Modulen'], // 2
			['name' => 'delete_module', 'display_name' => 'Modul löschen', 'description' => 'Ermöglicht Löschen von Modulen'], // 3
			['name' => 'add_user', 'display_name' => 'Benutzer erstellen', 'description' => ''], // 4
			['name' => 'edit_user', 'display_name' => 'Benutzer bearbeiten', 'description' => ''], // 5
			['name' => 'delete_user', 'display_name' => 'Benutzer löschen', 'description' => ''], // 6
			['name' => 'change_password_user', 'display_name' => 'Benutzerpasswort ändern', 'description' => ''], // 7
			['name' => 'activate_user', 'display_name' => 'Benutzer aktivieren', 'description' => 'Deaktivierten Benutzeraccout wieder aktivieren'], // 8
			['name' => 'deactivate_user', 'display_name' => 'Benutzer deaktivieren', 'description' => 'Benutzeraccout deaktivieren'], // 9
			['name' => 'add_planning', 'display_name' => 'Planung erstellen', 'description' => 'Ermöglicht das Anlegen von Planungen.'], // 10
			['name' => 'edit_planning', 'display_name' => 'Planung bearbeiten', 'description' => ''], // 11
			['name' => 'view_planning', 'display_name' => 'Planung ansehen', 'description' => ''], // 12 Allows room and course planer to see the course
			['name' => 'delete_planning', 'display_name' => 'Planung löschen', 'description' => ''], // 13 Allows course planer to delete the planning, not for local course planer
			['name' => 'edit_planning_course_number', 'display_name' => 'LV-Nummern vergeben', 'description' => ''], // 14 only for course planer
			['name' => 'update_planning_exam_type', 'display_name' => 'Modulabschluss - Planung aktualisieren', 'description' => ''], // 15
			['name' => 'update_planning_employee', 'display_name' => 'Mitarbeiter/In - Planung aktualisieren', 'description' => ''], // 16
			['name' => 'delete_planning_employee', 'display_name' => 'Mitarbeiter/In - Planung löschen', 'description' => ''], // 17
			['name' => 'add_planning_employee', 'display_name' => 'Mitarbeiter/In - Planung hinzufügen', 'description' => ''], // 18
			['name' => 'update_planning_room', 'display_name' => 'Raum - Planung aktualisieren', 'description' => ''], // 19
			['name' => 'delete_planning_room', 'display_name' => 'Raum - Planung löschen', 'description' => ''], // 20
			['name' => 'add_planning_room', 'display_name' => 'Raum - Planung hinzufügen', 'description' => ''],// 21
			['name' => 'copy_planning', 'display_name' => 'Planung kopieren', 'description' => ''],// 22
			['name' => 'copy_planning_all', 'display_name' => 'Alle Planung kopieren', 'description' => ''], // 23 for general course planer, check if this role is nessessary
			['name' => 'generate_planning_mediumterm', 'display_name' => 'Planung aus mittelfristiger Lehrplanung generieren', 'description' => ''], // 24
			['name' => 'generate_planning_mediumterm_all', 'display_name' => 'Alle Planungen aus mittelfristiger Lehrplanung generieren', 'description' => ''], // 25for course planer only
			['name' => 'add_announcement', 'display_name' => 'Ankündigung hinzufügen', 'description' => ''],// 26
			['name' => 'edit_announcement', 'display_name' => 'Ankündigung bearbeiten', 'description' => ''],// 27
			['name' => 'delete_announcement', 'display_name' => 'Ankündigung löschen', 'description' => ''],// 28
			['name' => 'add_appointedday', 'display_name' => 'Termin hinzufügen', 'description' => ''], // 29
			['name' => 'edit_appointedday', 'display_name' => 'Termin bearbeiten', 'description' => ''], // 30
			['name' => 'delete_appointedday', 'display_name' => 'Termin löschen', 'description' => ''], // 31
			['name' => 'change_rg_status', 'display_name' => 'Arbeitsbereichsstatus ändern', 'description' => ''], // 32
			['name' => 'change_board_status', 'display_name' => 'Vorstandsstatus ändern', 'description' => ''], // 33
			['name' => 'add_employee', 'display_name' => 'Mitarbeiter erstellen', 'description' => ''], // 34
			['name' => 'edit_employee', 'display_name' => 'Mitarbeiter bearbeiten', 'description' => ''],// 35
			['name' => 'delete_employee', 'display_name' => 'Mitarbeiter löschen', 'description' => ''],// 36
			['name' => 'deactivate_employee', 'display_name' => 'Mitarbeiter inaktiv setzen', 'description' => ''],// 37
			['name' => 'view_planninglog', 'display_name' => 'Planungshistorie ansehen', 'description' => ''],// 38
			['name' => 'add_role', 'display_name' => 'Rolle erstellen', 'description' => ''],// 39
			['name' => 'edit_role', 'display_name' => 'Rolle bearbeiten', 'description' => ''],// 40
			['name' => 'delete_role', 'display_name' => 'Rolle löschen', 'description' => ''],// 41
			['name' => 'attach_user_role', 'display_name' => 'Rolle Benutzer zuordnen', 'description' => ''],// 42
			['name' => 'detach_user_role', 'display_name' => 'Rollezuordnung lösen', 'description' => ''],// 43
			['name' => 'add_permission', 'display_name' => 'Berechtigung erstellen', 'description' => ''],// 44
			['name' => 'edit_permission', 'display_name' => 'Berechtigung bearbeiten', 'description' => ''],// 45
			['name' => 'delete_permission', 'display_name' => 'Berechtigung löschen', 'description' => ''],// 46
			['name' => 'attach_role_permission', 'display_name' => 'Berechtigung Rolle zuordnen', 'description' => ''],// 47
			['name' => 'detach_role_permission', 'display_name' => 'Berechtigungszuordnung lösen', 'description' => ''],// 48
			['name' => 'add_degreecourse', 'display_name' => 'Studiengang erstellen', 'description' => 'Ermöglicht das Anlegen von Studiengängen.'],// 49
			['name' => 'edit_degreecourse', 'display_name' => 'Studiengang bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Studiengängen'],// 50
			['name' => 'delete_degreecourse', 'display_name' => 'Studiengang löschen', 'description' => 'Ermöglicht Löschen von Studiengängen'],// 51
			['name' => 'add_course', 'display_name' => 'Lehrveranstaltung erstellen', 'description' => 'Ermöglicht das Anlegen von Lehrveranstaltungen.'],// 52
			['name' => 'edit_course', 'display_name' => 'Lehrveranstaltung bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Lehrveranstaltungen'],// 53
			['name' => 'delete_course', 'display_name' => 'Lehrveranstaltung löschen', 'description' => 'Ermöglicht Löschen von Lehrveranstaltungen'],// 54
			['name' => 'add_coursetype', 'display_name' => 'Lehrveranstaltungtyp erstellen', 'description' => 'Ermöglicht das Anlegen von Lehrveranstaltungentyp.'],// 55
			['name' => 'edit_coursetype', 'display_name' => 'Lehrveranstaltungtyp bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Lehrveranstaltungentyp'],// 56
			['name' => 'delete_coursetype', 'display_name' => 'Lehrveranstaltungtyp löschen', 'description' => 'Ermöglicht Löschen von Lehrveranstaltungentyp'],// 57
			['name' => 'add_section', 'display_name' => 'Bereiche erstellen', 'description' => 'Ermöglicht das Anlegen von Bereichen.'],// 58
			['name' => 'edit_section', 'display_name' => 'Bereiche bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Bereichen'],// 59
			['name' => 'delete_section', 'display_name' => 'Bereiche löschen', 'description' => 'Ermöglicht Löschen von Bereichen'],// 60
			['name' => 'add_rotation', 'display_name' => 'Turnus erstellen', 'description' => 'Ermöglicht das Anlegen von Turnusse.'],// 61
			['name' => 'edit_rotation', 'display_name' => 'Turnus bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Turnusse.'],// 62
			['name' => 'delete_rotation', 'display_name' => 'Turnus löschen', 'description' => 'Ermöglicht Löschen von Turnusse'],// 63
			['name' => 'add_room', 'display_name' => 'Raum erstellen', 'description' => 'Ermöglicht das Anlegen von Räumen.'],// 64
			['name' => 'edit_room', 'display_name' => 'Raum bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Räumen.'],// 65
			['name' => 'delete_room', 'display_name' => 'Raum löschen', 'description' => 'Ermöglicht Löschen von Räumen.'],// 66
			['name' => 'add_roomtype', 'display_name' => 'Raumtyp erstellen', 'description' => 'Ermöglicht das Anlegen von Raumtypen.'],// 67
			['name' => 'edit_roomtype', 'display_name' => 'Raumtyp bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Raumtypen.'],// 68
			['name' => 'delete_roomtype', 'display_name' => 'Raumtyp löschen', 'description' => 'Ermöglicht Löschen von Raumtypen.'],// 69
			['name' => 'add_semester', 'display_name' => 'Semester erstellen', 'description' => 'Ermöglicht das Anlegen von Semestern.'],// 70
			['name' => 'edit_semester', 'display_name' => 'Semester bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Semestern.'],// 71
			['name' => 'delete_semester', 'display_name' => 'Semester löschen', 'description' => 'Ermöglicht Löschen von Semestern.'],// 72
			['name' => 'add_degree', 'display_name' => 'Abschluss erstellen', 'description' => 'Ermöglicht das Anlegen von Abschlüssen.'],// 73
			['name' => 'edit_degree', 'display_name' => 'Abschluss bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Abschlüssen.'],// 74
			['name' => 'delete_degree', 'display_name' => 'Abschluss löschen', 'description' => 'Ermöglicht Löschen von Abschlüssen.'],// 75
			['name' => 'add_mediumtermplanning', 'display_name' => 'Mittelfristige Lehrplanung erstellen', 'description' => 'Ermöglicht das Anlegen der mittelfristigen Lehrplanung'],// 76
			['name' => 'edit_mediumtermplanning', 'display_name' => 'Mittelfristige Lehrplanung bearbeiten', 'description' => 'Ermöglicht Bearbeitung der mittelfristigen Lehrplanung'],// 77
			['name' => 'delete_mediumtermplanning', 'display_name' => 'Mittelfristige Lehrplanung löschen', 'description' => 'Ermöglicht Löschen der mittelfristigen Lehrplanung'],// 78
			['name' => 'view_settings', 'display_name' => 'Einstellungen ansehen', 'description' => 'Ermöglicht den Einblick in die Softwareeinstellungen'],// 79
			['name' => 'change_setting_current_turn', 'display_name' => 'Einstellung aktuelles Semester ändern', 'description' => 'Ermöglicht das Verändern der Einstellung des aktuellen Semesters'],// 80
			['name' => 'view_room_preferences', 'display_name' => 'Übersicht über die Raumwünsche', 'description' => 'Ermöglicht einen Überblick über die Raumwünsche für bestimmtes Semester'],// 81
			['name' => 'add_researchgroup', 'display_name' => 'Arbeitsbereich erstellen', 'description' => 'Ermöglicht das Anlegen von Arbeitsbereichen.'],// 82
			['name' => 'edit_researchgroup', 'display_name' => 'Arbeitsbereich bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Arbeitsbereichen.'],// 83
			['name' => 'delete_researchgroup', 'display_name' => 'Arbeitsbereich löschen', 'description' => 'Ermöglicht Löschen von Arbeitsbereichen.'],// 84
			['name' => 'attach_user_researchgroup', 'display_name' => 'Arbeitsbereich Benutzer zuordnen', 'description' => 'Ermöglicht das Zuordnen eines Arbeitsbereiches zu einem Benutzer.'],// 85
			['name' => 'detach_user_researchgroup', 'display_name' => 'Arbeitsbereichszuordnungen lösen', 'description' => 'Ermöglicht das Lösen einer Arbeitsbereichszuordnung.'],// 86
			['name' => 'add_turn', 'display_name' => 'Semester erstellen', 'description' => 'Ermöglicht das Anlegen von Semestern.'],// 87
			['name' => 'edit_turn', 'display_name' => 'Semester bearbeiten', 'description' => 'Ermöglicht Bearbeitung von Semestern.'],// 88
			['name' => 'delete_turn', 'display_name' => 'Semester löschen', 'description' => 'Ermöglicht Löschen von Semestern.'],// 89
			['name' => 'change_planning_status', 'display_name' => 'Planungsstatus ändern', 'description' => 'Ermöglicht Ändern der Planungsstatus.'],// 90 only for course planer
		);
		DB::table('permissions')->insert($permissions);
	}
}