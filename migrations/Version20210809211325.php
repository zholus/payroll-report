<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809211325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE payroll_report
            (
                id CHAR(36) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT NOW(),
                CONSTRAINT payroll_report_pk
                    PRIMARY KEY (id)
            );
        ');
        $this->addSql('
            CREATE TABLE payroll_report_records
            (
                id CHAR(36) NOT NULL,
                report_id CHAR(36) NOT NULL,
                first_name VARCHAR (255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                department_name VARCHAR(255) NOT NULL,
                basic_salary INT NOT NULL,
                additional_salary_type VARCHAR(255) NOT NULL,
                additional_salary_value INT NOT NULL,
                total_salary INT NOT NULL,
                CONSTRAINT payroll_report_records_pk
                    PRIMARY KEY (id)
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE payroll_report_records');
        $this->addSql('DROP TABLE payroll_report');
    }
}
