/* Nederlandse tekst toevoegen aan database */
TRUNCATE TABLE text_nl;
/* you can consider truncating tables in this kind of operations, suggestion */
INSERT INTO text_nl (Name, Text) VALUES
	('Title', 		'ThreeSixtyWeb'),
	('ID', 			'ID'),
	('Username', 	'Gebruikersnaam'),
	('Password', 	'Wachtwoord'),
	('User', 		'Gebruiker'),
	('Reviewer', 	'Reviewer'),
	('Reviewee', 	'Reviewee'),
	('Poll', 		'Vragenlijst'),
	('Polls', 		'Vragenlijsten'),
	('Question', 	'Vraag'),
	('Questions', 	'Vragen'),
	('Answer', 		'Antwoord'),
	('Answers', 	'Antwoorden'),
	('Add',			'Voeg toe'),
	('Add_poll', 	'Vragenlijst toevoegen'),
	('Add_answer', 	'Antwoord toevoegen'),
	('Add_answers', 'Antwoorden toevoegen'),
	('Add_batch', 	'Batch toevoegen'),
	('Preference',	'Voorkeur'),
	('Preferences', 'Voorkeuren'),
	('No_polls_found', 'Geen vragenlijsten gevonden'),
	('Choose_a', 	'Kies een'),
	('Select_a',	'Selecteer een'),
	('View', 		'Bekijk'),
	('About', 		'Over'),
	('This_person_may_answer_my_poll', 'Deze persoon mag mijn vragenlijst invullen'),
	('I_want_to_answer_poll_about_this_person', 'Ik wil de vragenlijst van deze persoon invullen'),
	('Time_Created', 'Aangemaakt op'),
	('Information',	'Informatie'),
	('Please_choose_a_user', 'Gelieve een gebruiker te selecteren'),
	('Poll_already_exists', 'Deze vragenlijst bestaat al'),
	('Question_already_answered', 'Deze vraag werd al beantwoord'),
	('Answered', 'Beantwoord'),
	('Prohibited_to_prefer_yourself', 'Het is verboden om jezelf als voorkeur op te geven'),
	('Added',		'Toegevoegd'),
	('Phase1_text', '<p>Welkom bij het ThreeSixtyWeb evaluatieproject.</p><p>Klik op <b>Start</b> om jouw vragenlijst in te vullen.</p>'),
	('Phase2_text', '<p>Welkom bij het ThreesixtyWeb evaluatieproject, fase 2</p><p>We hebben het algoritme losgelaten op onze database en deze heeft dan, rekening houdend met uw voorkeuren, koppels berekend.</p><p>De voor u berekende koppels worden op de volgende pagina weergegeven. U kan vanaf nu de vragenlijsten van deze gebruikers invullen.</p>'),
	('Project_text', '	Het ThreeSixtyWeb evalutieproject bestaat uit twee fasen:
						<ol>
							<li>
								Fase 1 gaat over je eigen vragenlijst. Deze fase bestaat op zijn beurt weer uit 3 stappen:
								<ol>
									<li>Tijdens de eerste stap moet je je eigen vragenlijst invullen. Zodra deze vragenlijst is ingevuld, kan je deze insturen. Het is ook mogelijk om de vragenlijst op te slaan, zodat je deze later nog kan aanpassen. Zodra je de antwoorden op de vragenlijst heb doorgestuurd, is het niet meer mogelijk om deze aan te passen.</li>
									<li>Zodra je je eigen vragenlijst hebt doorgestuurd, kom je op een nieuw scherm terecht. Op dit scherm dient u medewerkers te selecteren waarvan u graag hebt dat zijn dezelfde vragenlijst over u invullen.</li>
									<li>Op het laatste venster dien je tenslotte medewerkers te selecteren waarvan u graag de vragenlijst invult</li>
									De selecties die u hebt gemaakt in stap 1 en 2 worden gebruikt om de bepalen welke vragenlijsten u uiteindelijk mag invullen, en welke medewerkers u vragenlijst zullen invullen.
								</ol>
							</li>
							<li>
								Zodra alle gebruikers fase 1 hebben afgerond, wordt fase 2 gestart. Tijdens deze fase dient u de vragenlijsten in te vullen van een aantal medewerkers.
								Ook hier is het mogelijk om de vragenlijst op te slaan, zodat u deze later nog kan aanpassen alvorens deze definitief te verzenden.
							</li>
						</ol>'),
	('Start', 'Start'),
	('Next', 'Volgende'),
	('Back', 'Vorige'),
	('Poll_send_successfully', 'De vragenlijst is succesvol doorgestuurd.'),
	('Poll_saved_successfully', 'Je vragenlijst is succesvol opgeslagen.'),
	('Click_next_for_next_step', 'Klik op Volgende om naar de volgende stap te gaan.'),
	('Select_x_users_at_least', 'Gelieve minstens x gebruikers te selecteren.'),
	('End_phase1_text', '<p>U bent aan het einde gekomen van fase 1.</p>
						<p>Zodra alle gebruikers fase 1 hebben afgerond, zal fase 2 beginnen.</p>
						<p>U zult via mail een bericht ontvangen wanneer fase 2 begint, zodat u de reviews van de andere gebruikers kan invullen.</p>'),
	('Exit', 'Afsluiten'),
	('Error_occured_try_again','Er is een fout opgetreden. Probeer later nog eens.'),
	('Poll_already_answered', 'Deze enquete werd reeds ingevuld'),
	('Answer_poll', 'Vragenlijst invullen'),
	('Send', 'Versturen'),
	('Save', 'Opslaan'),
	('These_users_have_not_filled_in_own_poll', 'Deze gebruikers hebben hun eigen vragenlijst nog niet ingevuld'),
	('Login', 'Login'),
	('Wrong_password', 'Foutief wachtwoord'),
	('Users_have_not_filled_in_own_poll', 'gebruikers hebben hun eigen vragenlijst nog niet ingevuld'),
	('Users_have_not_filled_in_other_poll', 'gebruikers hebben de andere vragenlijsten nog niet ingevuld'),
	('Send_reminder', 'Stuur herinnering'),
	('Reminder_send', 'Herinnering verzonden'),
	('Every_user_has_answered_own_poll_can_start_phase_2','Elke gebruiker heeft zijn eigen vragenlijst ingevuld. Fase 2 kan gestart worden.'),
	('Every_user_has_answered_other_poll_can_start_publish_results', 'Elke gebruiker heeft de vragenlijsten ingevuld. De resultaten kunnen nu gepubliceerd worden'),
	('Phase_2', 'Fase 2'),
	('List_of_batches', 	'Lijst van batches'),
	('Batches_text', 		"Er kan maar 1 batch in 'Init' state zijn, en maar 1 batch in 'Running' state. Er staat geen limiet op het aantal batches in 'Finished' state."),
	('Init_date', 			'Initialisatie'),
	('Running_phase_1', 	'Start fase 1'),
	('Running_phase_2', 	'Start fase 2'),
	('Finished_date', 		'Einde'),
	('Status', 				'Status'),
	('Comment', 			'Commentaar'),
	('Action', 				'Actie'),
	('Choice', 				'Keuze'),
	('Your_poll', 			'Jouw vragenlijst'),
	('Other_polls', 		'Andere vragenlijsten'),
	('Select_poll', 		'Vragenlijst selecteren'),
	('Delete', 				'Verwijder'),
	('Stop_and_publish_results', 'Stop en publiceer resultaten'),
	('Calculate_polls', 	'Vragenlijsten berekenen'),
	('Home', 				'Index'),
	('My_results',			'Mijn resultaten'),
	('User_results', 		'Gebruikersresultaten'),
	('Admin', 				'Beheer'),
	('Logout', 				'Afmelden'),
	('Edit', 				'Wijzigen');