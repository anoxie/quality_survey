<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329235913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE section_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE questionnaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sondage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE application_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE public.user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE section (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE section_application (section_id INT NOT NULL, application_id INT NOT NULL, PRIMARY KEY(section_id, application_id))');
        $this->addSql('CREATE INDEX IDX_B2AAA2BED823E37A ON section_application (section_id)');
        $this->addSql('CREATE INDEX IDX_B2AAA2BE3E030ACD ON section_application (application_id)');
        $this->addSql('CREATE TABLE questionnaire (id INT NOT NULL, section_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, model_mail JSON DEFAULT NULL, reminder_model_mail JSON DEFAULT NULL, reminder_time VARCHAR(255) DEFAULT NULL, questions_settings JSON NOT NULL, stats_settings JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A64DAFD823E37A ON questionnaire (section_id)');
        $this->addSql('COMMENT ON COLUMN questionnaire.reminder_time IS \'(DC2Type:dateinterval)\'');
        $this->addSql('CREATE TABLE questionnaire_application (questionnaire_id INT NOT NULL, application_id INT NOT NULL, PRIMARY KEY(questionnaire_id, application_id))');
        $this->addSql('CREATE INDEX IDX_2D7F07E1CE07E8FF ON questionnaire_application (questionnaire_id)');
        $this->addSql('CREATE INDEX IDX_2D7F07E13E030ACD ON questionnaire_application (application_id)');
        $this->addSql('CREATE TABLE sondage (id INT NOT NULL, questionnaire_id INT NOT NULL, created_by_id INT DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, email_interviewed VARCHAR(255) NOT NULL, responses JSON DEFAULT NULL, sent_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7579C89FCE07E8FF ON sondage (questionnaire_id)');
        $this->addSql('CREATE INDEX IDX_7579C89FB03A8386 ON sondage (created_by_id)');
        $this->addSql('CREATE TABLE application (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE public."user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_327C5DE7E7927C74 ON public."user" (email)');
        $this->addSql('CREATE TABLE user_section (user_id INT NOT NULL, section_id INT NOT NULL, PRIMARY KEY(user_id, section_id))');
        $this->addSql('CREATE INDEX IDX_757E64E5A76ED395 ON user_section (user_id)');
        $this->addSql('CREATE INDEX IDX_757E64E5D823E37A ON user_section (section_id)');
        $this->addSql('CREATE TABLE user_application (user_id INT NOT NULL, application_id INT NOT NULL, PRIMARY KEY(user_id, application_id))');
        $this->addSql('CREATE INDEX IDX_D401454A76ED395 ON user_application (user_id)');
        $this->addSql('CREATE INDEX IDX_D4014543E030ACD ON user_application (application_id)');
        $this->addSql('ALTER TABLE section_application ADD CONSTRAINT FK_B2AAA2BED823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE section_application ADD CONSTRAINT FK_B2AAA2BE3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFD823E37A FOREIGN KEY (section_id) REFERENCES section (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_application ADD CONSTRAINT FK_2D7F07E1CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_application ADD CONSTRAINT FK_2D7F07E13E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sondage ADD CONSTRAINT FK_7579C89FCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sondage ADD CONSTRAINT FK_7579C89FB03A8386 FOREIGN KEY (created_by_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_section ADD CONSTRAINT FK_757E64E5A76ED395 FOREIGN KEY (user_id) REFERENCES public."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_section ADD CONSTRAINT FK_757E64E5D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_application ADD CONSTRAINT FK_D401454A76ED395 FOREIGN KEY (user_id) REFERENCES public."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_application ADD CONSTRAINT FK_D4014543E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE section_application DROP CONSTRAINT FK_B2AAA2BED823E37A');
        $this->addSql('ALTER TABLE questionnaire DROP CONSTRAINT FK_7A64DAFD823E37A');
        $this->addSql('ALTER TABLE user_section DROP CONSTRAINT FK_757E64E5D823E37A');
        $this->addSql('ALTER TABLE questionnaire_application DROP CONSTRAINT FK_2D7F07E1CE07E8FF');
        $this->addSql('ALTER TABLE sondage DROP CONSTRAINT FK_7579C89FCE07E8FF');
        $this->addSql('ALTER TABLE section_application DROP CONSTRAINT FK_B2AAA2BE3E030ACD');
        $this->addSql('ALTER TABLE questionnaire_application DROP CONSTRAINT FK_2D7F07E13E030ACD');
        $this->addSql('ALTER TABLE user_application DROP CONSTRAINT FK_D4014543E030ACD');
        $this->addSql('ALTER TABLE sondage DROP CONSTRAINT FK_7579C89FB03A8386');
        $this->addSql('ALTER TABLE user_section DROP CONSTRAINT FK_757E64E5A76ED395');
        $this->addSql('ALTER TABLE user_application DROP CONSTRAINT FK_D401454A76ED395');
        $this->addSql('DROP SEQUENCE section_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE questionnaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sondage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE application_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE public.user_id_seq CASCADE');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE section_application');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questionnaire_application');
        $this->addSql('DROP TABLE sondage');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE public."user"');
        $this->addSql('DROP TABLE user_section');
        $this->addSql('DROP TABLE user_application');
    }
}
