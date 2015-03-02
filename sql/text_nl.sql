/* Nederlandse tekst toevoegen aan database */
TRUNCATE TABLE text_nl;
/* you can consider truncating tables in this kind of operations, suggestion */
INSERT INTO text_nl (Name, Text) VALUES
  ('Title', '360° Feedback'),
  ('Menu', 'Menu'),
  ('ID', 'ID'),
  ('Username', 'Gebruikersnaam'),
  ('Password', 'Wachtwoord'),
  ('User_as_coworker', 'Gebruiker'),
  ('User_as_participant', 'Deelnemer'),
  ('Users_as_participants', 'Deelnemers'),
  ('Question', 'Vraag'),
  ('Questions', 'Vragen'),
  ('Answer', 'Antwoord'),
  ('Answers', 'Antwoorden'),
  ('Add', 'Voeg toe'),
  ('Add_poll', 'Vragenlijst toevoegen'),
  ('Add_answer', 'Antwoord toevoegen'),
  ('Add_answers', 'Antwoorden toevoegen'),
  ('Add_batch', 'Batch toevoegen'),
  ('Preferences', 'Voorkeuren'),
  ('Poll', 'Vragenlijst'),
  ('Polls', 'Vragenlijsten'),
  ('No_polls_found', 'Geen vragenlijsten gevonden'),
  ('No_batches_found', 'Geen batches gevonden'),
  ('Choose_a', 'Kies een'),
  ('Select_a', 'Selecteer een'),
  ('View', 'Bekijk'),
  ('About', 'Over'),
  ('This_person_may_answer_my_poll', 'Deze persoon mag mijn vragenlijst invullen'),
  ('I_want_to_answer_poll_about_this_person', 'Ik wil de vragenlijst van deze persoon invullen'),
  ('Information', 'Informatie'),
  ('Please_choose_a_user', 'Gelieve een deelnemer te selecteren'),
  ('Poll_already_exists', 'Deze vragenlijst bestaat al'),
  ('Prohibited_to_prefer_yourself', 'Het is verboden om jezelf als voorkeur op te geven'),
  ('Added', 'Toegevoegd'),
  ('Phase1_text', '<p>Welkom bij het 360° feedback project.</p><p>Klik op <b>Start</b> om verder te gaan met deel 1.</p>'),
  ('Phase2_text', "<p>Welkom bij het 360° feedback project, deel 2.</p><p>We hebben het algoritme losgelaten op onze database, rekening houdend met jouw voorkeuren.</p><p>De collega's waarover jij anoniem gedetailleerde feedback moet geven, worden op de volgende pagina weergegeven. Je kan ook anoniem feedback over collega's naar keuze doorgeven via een vrij tekstveld.</p>"),
  ('Project_text', "Het 360° feedback project bestaat uit twee delen:
						<ol>
							<li>
								Deel 1 gaat over jouw eigen vragenlijst (zelfevaluatie) en jouw voorkeuren:
								<ol>
									<li>Tijdens de eerste stap moet je jouw eigen vragenlijst invullen. Zodra deze vragenlijst is ingevuld, kan je deze doorsturen. Het is ook mogelijk om de vragenlijst eerst op te slaan, zodat je deze later nog kan aanpassen. Zodra je de antwoorden op de vragenlijst heb doorgestuurd, is het niet meer mogelijk om deze aan te passen.</li>
									<li>Op het volgende scherm kan je collegas's te selecteren waarvan je graag zou hebben dat ze diezelfde vragenlijst over jouw invullen.</li>
									<li>Op het laatste scherm dien je tenslotte collegas's te selecteren waarvover jijzelf graag deze vragenlijst zou invullen.</li>
									De selecties die je hebt gemaakt zullen worden gebruikt om de bepalen welke vragenlijsten jij uiteindelijk zal invullen, en welke collegas's jouw vragenlijst zullen invullen.
								</ol>
							</li>
							<li>
								Zodra alle deelnemers deel 1 hebben afgerond, wordt deel 2 gestart. Nu dien je dus minstens de vragenlijsten in te vullen van een aantal collega's.
								Ook hier is het weer mogelijk om vragenlijsten op te slaan, zodat je deze later nog kan aanpassen alvorens deze definitief door te sturen.
							</li>
						</ol>"),
  ('Start', 'Start'),
  ('Next', 'Volgende'),
  ('Back', 'Vorige'),
  ('Poll_send_successfully', 'De feedback is succesvol doorgestuurd.'),
  ('Poll_saved_successfully', 'Jouw feedback is succesvol opgeslagen.'),
  ('Comment_added_successfully', 'Jouw feedback is succesvol toegevoegd.'),

  ('End_phase1_text', '<p>Je bent aan het einde gekomen van deel 1.</p>
						<p>Zodra alle deelnemers deel 1 hebben afgerond, kan er worden overgegaan tot deel 2.</p>
						<p>Je zal via mail een bericht ontvangen wanneer deel 2 begint.</p>'),
  ('Exit', 'Afsluiten'),
  ('Error_occured_try_again', 'Er is een fout opgetreden. Probeer later nog eens.'),
  ('Poll_already_answered', 'Deze enquete werd reeds ingevuld'),
  ('Poll_saved', 'Vragenlijst opgeslagen'),
  ('Answer_poll', 'Vragenlijst invullen'),
  ('Send', 'Versturen'),
  ('Save', 'Opslaan'),
  ('These_users_have_not_filled_in_own_poll', 'Deze deelnemers hebben hun eigen vragenlijst nog niet ingevuld'),
  ('Wrong_password', 'Foutief wachtwoord'),
  ('Users_have_not_filled_in_own_poll', 'deelnemers hebben hun eigen vragenlijst nog niet ingevuld'),
  ('Users_have_not_filled_in_other_poll', 'deelnemers hebben de andere vragenlijsten nog niet ingevuld'),
  ('Send_reminder', 'Stuur herinnering'),
  ('Reminder_send', 'Herinnering verzonden'),
  ('Every_user_has_answered_own_poll_can_start_phase_2', 'Elke deelnemer heeft zijn eigen vragenlijst ingevuld. Deel 2 kan gestart worden.'),
  ('Every_user_has_answered_other_poll_can_start_publish_results', 'Elke deelnemer heeft de verplichte vragenlijsten ingevuld. De resultaten kunnen nu gepubliceerd worden'),
  ('Phase_2', 'Deel 2'),
  ('List_of_batches', 'Lijst van batches'),
  ('Batches_text', "Er kan maar 1 batch in 'Init' state zijn, en maar 1 batch in 'Running' state. Er staat geen limiet op het aantal batches in 'Finished' state."),
  ('Init_date', 'Initialisatie'),
  ('Start_phase_1', 'Start deel 1'),
  ('Start_phase_2', 'Start deel 2'),
  ('Finished_date', 'Einde'),
  ('Status', 'Status'),
  ('Comment', 'Feedback'),
  ('Action', 'Actie'),
  ('Choice', 'Keuze'),
  ('Your_poll', 'Jouw vragenlijst'),
  ('Other_polls', 'Andere vragenlijsten'),
  ('Select_poll', 'Vragenlijst selecteren'),
  ('Delete', 'Verwijder'),
  ('Stop_and_publish_results', 'Stop en publiceer resultaten'),
  ('Calculate_polls', 'Vragenlijsten berekenen'),
  ('View_calculated_polls', 'Bekijk berekende vragenlijsten'),
  ('Home', 'Home'),
  ('My_results', 'Mijn resultaten'),
  ('Results', 'Resultaten'),
  ('Admin', 'Beheer'),
  ('Logout', 'Afmelden'),
  ('Edit', 'Wijzigen'),
  ('Remember_me', 'Aangemeld blijven'),
  ('Forgot_password', 'Wachtwoord vergeten'),
  ('Login', 'Aanmelden'),
  ('Reset_password', 'Stuur mij een nieuw wachtwoord'),
  ('Edit_comment', 'Feedback bewerken'),
  ('Delete_comment', 'Feedback verwijderen'),
  ('PDF', 'PDF'),
  ('End', 'Einde'),
  ('Add_question', 'Vraag toevoegen'),
  ('Average_score', 'Gemiddelde van ontvangen scores'),
  ('Your_score', 'Jouw eigen score (zelfevaluatie)'),
  ('Add_user', 'Deelnemer toevoegen'),
  ('Add_department', 'Departement toevoegen'),
  ('Firstname', 'Voornaam'),
  ('Lastname', 'Achternaam'),
  ('Department', 'Departement'),
  ('Manager', 'Manager'),
  ('Admin_intro', '	<h2>Admin paneel</h2>
								<p>Welkom op het adminpaneel.</p>
								<p>Hier kan je onder andere:
									<ul>
										<li>Nieuwe batches starten</li>
										<li>Deelnemers toevoegen</li>
										<li>Resultaten van de deelnemers bekijken</li>
									</ul>
								</p>
								<p>Om een nieuwe batch te starten, dient je hieronder op <i>Batch toevoegen</i> te klikken.</p>'),
  ('Email', 'Email'),
  ('Job_title', 'Functie'),
  ('New_password', 'Nieuw wachtwoord'),
  ('Mail_footer', '<p>
								Met vriendelijke groeten,
							</p>
							<p>
								Het 360° Feedback team
							</p>'),
  ('New_user_credentials', 'Hier zijn jouw nieuwe gebruikersgegevens'),
  ('New_password_send', 'Het nieuwe wachtwoord werd verzonden naar jouw emailadres.'),
  ('Dear', 'Geachte'),
  ('Mail_phase_1', '<p>
								Deel 1 is begonnen. Zodra je je aanmeld met jouw gebruikersnaam en wachtwoord, kan je jouw eigen vragenlijst invullen.
							</p>'),
  ('Results_available', 'Resultaten beschikbaar'),
  ('Mail_phase_2', '<p>
								Deel 2 is begonnen. Zodra je je aanmeld met jouw gebruikersnaam en wachtwoord, kan je de voor jouw verplichtte vragenlijsten invullen.
							</p>'),
  ('Mail_results_available', '	<p>
									De resultaten van het 360° feedback project zijn nu beschikbaar. Log in met jouw gebruikersnaam en wacthwoord om jouw persoonlijke resultaten te bekijken.
								</p>'),
  ('Reminder', 'Herinnering'),
  ('Reminder_own_poll', '<p>
								Via deze mail willen wij je er aan herinneren dat je jouw eigen vragenlijst nog niet hebt ingevuld.
								Wij willen je vriendelijk verzoeken om deze zo snel mogelijk in te vullen en door te sturen.
							</p>'),
  ('Reminder_other_polls', '<p>
								Via deze mail willen wij je er aan herinneren dat je nog niet alle verplichtte vragenlijsten hebt ingestuurd.
								Wij willen je vriendelijk verzoeken om deze zo snel mogelijk in te vullen en door te sturen.
							</p>'),
  ('Login_not_allowed', 'Aanmelden is momenteel niet toegestaan. Je krijgt een email zodra je terug kan aanmelden.'),
  ('Error_occured', 'Er is een fout opgetreden.'),
  ('Do_you_have_account', 'Heb je wel een account?'),
  ('Reviews_written', 'Vragenlijsten ingevuld'),
  ('Reviews_received', 'Beoordelingen ontvangen'),
  ('Reviews_from_teammember', 'Beoordelingen ontvangen van teamleden'),
  ('Reviews_from_not_teammember', 'Beoordelingen ontvangen van niet-teamleden'),
  ('Reviews_from_teammanager', 'Beoordelingen ontvangen van teammanager'),
  ('Reviews_from_not_teammanager', 'Beoordelingen ontvangen van niet-teammanagers'),
  ('Reviews_from_preferred_reviewer', "Aantal beoordelingen gekregen van gekozen collega's"),
  ('Reviews_given_to_preferred_reviewee', "Aantal beoordelingen gegeven aan gekozen collega's"),
  ('Extra_comment', 'Extra commentaar'),
  ('No_managers_found', 'Geen managers gevonden'),
  ('Edit_or_delete_users', 'Wijzig of verwijder deelnemers'),
  ('Departments', 'Departementen'),
  ('Name', 'Naam'),
  ('Edit_or_delete_departments', 'Wijzig of verwijder departementen'),
  ('Parameter', 'Parameter'),
  ('Value', 'Waarde'),
  ('Page', 'Pagina'),
  ('Extra', 'Extra'),
  ('Want_extra_info', 'Indien je graag meer informatie wil over de resultaten, of deze resultaten graag met iemand bespreekt, dan kan dit.'),
  ('Who_may_answer_your_poll', "Van welke collega's zou je het liefst gedetailleerde feedback ontvangen?"),
  ('Answer_poll_about_who', "Welke collega's zou jij graag gedetailleerde feedback willen geven?"),
  ('Poll_about', 'Vragenlijst over'),
  ('Submit_explanation', 'Versturen: Jouw antwoorden worden definitief verzonden. Je kan ze later niet meer wijzigen.'),
  ('Save_explanation', 'Opslaan: Je kan later jouw antwoorden nog wijzigen.'),
  ('Select_poll_to_answer', 'Selecteer een vragenlijst om de vragen te beantwoorden.'),
  ('Written_extra_comment_about', "Over deze collega's heb je extra feedback ingevuld"),
  ('Extra_comment_about_user', 'Extra feedback over een collega'),
  ('Click_next_to_select_new_poll', 'Klik op volgende om een nieuwe vragenlijst te selecteren.'),
  ('Click_back_to_return_to_poll', 'Klik op vorige om terug naar de vragenlijst te gaan.'),
  ('Add_extra_comment_here', 'Als je nog extra opmerking hebt, kan je deze hieronder invullen'),
  ('Click_next_to_select_preferred_reviewers', "Klik op volgende om collega's te selecteren waarvan je het liefst feedback zou ontvangen."),
  ('Click_next_to_select_preferred_reviewees', "Klik op volgende om collega's te selecteren waarover je graag feedback zou geven."),
  ('Click_back_to_return_to_choices', 'Klik op vorige om terug te gaan naar jouw keuzes.'),
  ('Click_here_to_log_out', 'Klik <a href="logout.php">hier</a> om je af te melden'),
  ('Click_here_to_log_in', 'Klik <a href="login.php">hier</a> om je aan te melden.'),
  ('Normal_user_login_required', 'Je dient aan te melden als reguliere deelnemer om deze pagina te zien.'),
  ('Adress_street', 'Philipssite 5 bus 13'),
  ('Adress_city', '3001 Leuven Belgie'),
  ('Tel', 'Tel.: +32 16 28 49 70'),
  ('Website', 'Website : www.dnsbelgium.be'),
  ('Recalculate', 'Herberekenen'),
  ('Accept', 'Aanvaarden'),
  ('Cant_delete_manager',
   'Deze deelnemer is een manager. Je dient het departement te verwijderen of een andere manager toe te wijzen'),
  ('Legend', 'Legende'),
  ('Answered_by', 'Ingevuld door');