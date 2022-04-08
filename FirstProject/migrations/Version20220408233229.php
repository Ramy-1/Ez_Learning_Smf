<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408233229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie CHANGE idcat idcat INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP nom, DROP prenom, DROP tel, DROP pwd, DROP carte_banq, DROP role, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie CHANGE idcat idcat INT NOT NULL, CHANGE domaine domaine VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE nomcat nomcat VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE cours CHANGE titre titre VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE description description VARCHAR(250) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE duree duree VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE datecreate datecreate VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE support support VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE demande CHANGE description description VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE pathCv pathCv VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE enseignant CHANGE nom nom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE prenom prenom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE pwd pwd VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE carte_banq carte_banq VARCHAR(28) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE role role VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE universite universite VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE section section VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE etudiant CHANGE nom nom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE prenom prenom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE pwd pwd VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE carte_banq carte_banq VARCHAR(28) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE role role VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE section section VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE evenement CHANGE idOrg idOrg VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE description description VARCHAR(1000) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE date date VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE heure heure VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE lien lien VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE imgEv imgEv VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE offre CHANGE titre titre VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE type type VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE questions CHANGE contenu contenu VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE reponses reponses VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE reclamation CHANGE type type VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE description description TEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE idetudiant idetudiant VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE idcours idcours VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE recruteur CHANGE nom nom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE prenom prenom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE pwd pwd VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE carte_banq carte_banq VARCHAR(28) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE role role VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE societe societe VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE reponserec CHANGE description description VARCHAR(250) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE reponses CHANGE contenu contenu VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE responsable CHANGE nom nom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE prenom prenom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE pwd pwd VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE carte_banq carte_banq VARCHAR(28) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE role role VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE universite universite VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE societe CHANGE idsoc idsoc VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE nom nom VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE adresse adresse VARCHAR(250) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE imgsoc imgsoc VARCHAR(250) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE mdpsoc mdpsoc VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE test CHANGE titre titre VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE description description VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE universite CHANGE nom nom VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE adresse adresse VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE imguni imguni VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE mdpuni mdpuni VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, ADD prenom VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, ADD tel INT NOT NULL, ADD pwd VARCHAR(64) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, ADD carte_banq VARCHAR(28) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, ADD role VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, DROP roles, DROP password, CHANGE email email VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
    }
}
