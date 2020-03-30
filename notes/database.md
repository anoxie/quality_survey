MLD :
APPLICATION :
id, libelle, description, #questionnaires, #users, #sections
SECTION :
id, libelle, description, #questionnaires, #users, #application
USER :
id, email, roles, password, first_name, last_name, #sections, #applications
QUESTIONNAIRE :
id, libelle, description, model_mail, reminder_model_mail, reminder_time, questions_settings, stats_settings, #sondages, #section, #applications
SONDAGE :
id, token, email_interviewed, responses, send_at, completed_at #questionnaire, #created_by


APPLICATION_USER:
#id_user, #id_application
APPLICATION_QUESTIONNAIRE :
#id_application, #id_questionnaire
APPLICATION_SECTION:
#id_application, #id_section
SECTION_USER:
#id_user, #id_section