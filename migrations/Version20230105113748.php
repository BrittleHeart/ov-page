<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105113748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'First version of migrations needed for the blog app with RSS feed functionality.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "blog__attachment_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__category_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__comment_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__direct_message_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__file_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__friendship_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__message_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__post_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog__tag_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog_histories__post_action_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog_histories__user_direct_message_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "blog_histories__user_friendship_request_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "rss__result_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "rss_group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "blog__attachment" (id INT NOT NULL, post_id INT DEFAULT NULL, file_id INT DEFAULT NULL, type VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C324B53D4B89032C ON "blog__attachment" (post_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C324B53D93CB796C ON "blog__attachment" (file_id)');
        $this->addSql('COMMENT ON COLUMN "blog__attachment".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog__category" (id INT NOT NULL, name VARCHAR(40) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DF2B4EE5E237E06 ON "blog__category" (name)');
        $this->addSql('COMMENT ON COLUMN "blog__category".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog__comment" (id INT NOT NULL, author_id INT DEFAULT NULL, post_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94619736F675F31B ON "blog__comment" (author_id)');
        $this->addSql('CREATE INDEX IDX_946197364B89032C ON "blog__comment" (post_id)');
        $this->addSql('COMMENT ON COLUMN "blog__comment".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog__direct_message" (id INT NOT NULL, receiver_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A968E9FCD53EDB6 ON "blog__direct_message" (receiver_id)');
        $this->addSql('COMMENT ON COLUMN "blog__direct_message".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog__file" (id INT NOT NULL, original_name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, checksum VARCHAR(255) NOT NULL, mimetype VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, relative_path VARCHAR(255) NOT NULL, absolute_path VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "blog__file".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog__friendship" (id INT NOT NULL, friend_id INT DEFAULT NULL, status VARCHAR(20) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C84FC8D96A5458E8 ON "blog__friendship" (friend_id)');
        $this->addSql('COMMENT ON COLUMN "blog__friendship".requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog__message" (id INT NOT NULL, sender_id INT DEFAULT NULL, parent_message_id INT DEFAULT NULL, direct_message_id INT DEFAULT NULL, user_direct_message_history_id INT DEFAULT NULL, subject VARCHAR(170) NOT NULL, message_body TEXT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6A8F525F624B39D ON "blog__message" (sender_id)');
        $this->addSql('CREATE INDEX IDX_B6A8F52514399779 ON "blog__message" (parent_message_id)');
        $this->addSql('CREATE INDEX IDX_B6A8F525445FD6FA ON "blog__message" (direct_message_id)');
        $this->addSql('CREATE INDEX IDX_B6A8F5254E697881 ON "blog__message" (user_direct_message_history_id)');
        $this->addSql('COMMENT ON COLUMN "blog__message".creation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog__post" (id INT NOT NULL, author_id INT DEFAULT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, likes INT NOT NULL, shares INT NOT NULL, thumbnail_url VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, content TEXT NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F7405F5EF675F31B ON "blog__post" (author_id)');
        $this->addSql('CREATE INDEX IDX_F7405F5E12469DE2 ON "blog__post" (category_id)');
        $this->addSql('COMMENT ON COLUMN "blog__post".published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "blog__post".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(post_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_5ACE3AF04B89032C ON post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_5ACE3AF0BAD26311 ON post_tag (tag_id)');
        $this->addSql('CREATE TABLE "blog__tag" (id INT NOT NULL, name VARCHAR(40) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AE3222E95E237E06 ON "blog__tag" (name)');
        $this->addSql('COMMENT ON COLUMN "blog__tag".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog_histories__post_action" (id INT NOT NULL, author_id INT DEFAULT NULL, post_id INT DEFAULT NULL, action VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92FBD5EAF675F31B ON "blog_histories__post_action" (author_id)');
        $this->addSql('CREATE INDEX IDX_92FBD5EA4B89032C ON "blog_histories__post_action" (post_id)');
        $this->addSql('COMMENT ON COLUMN "blog_histories__post_action".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog_histories__user_direct_message" (id INT NOT NULL, receiver_id INT DEFAULT NULL, action VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6AA0A1D7CD53EDB6 ON "blog_histories__user_direct_message" (receiver_id)');
        $this->addSql('COMMENT ON COLUMN "blog_histories__user_direct_message".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "blog_histories__user_friendship_request" (id INT NOT NULL, friend_id INT DEFAULT NULL, action VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_770E39846A5458E8 ON "blog_histories__user_friendship_request" (friend_id)');
        $this->addSql('COMMENT ON COLUMN "blog_histories__user_friendship_request".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "rss__result" (id INT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, guid UUID NOT NULL, pub_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E2AA83D1F675F31B ON "rss__result" (author_id)');
        $this->addSql('COMMENT ON COLUMN "rss__result".pub_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "rss_group" (id INT NOT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, language VARCHAR(5) DEFAULT \'pl-PL\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE "blog__attachment" ADD CONSTRAINT FK_C324B53D4B89032C FOREIGN KEY (post_id) REFERENCES "blog__post" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__attachment" ADD CONSTRAINT FK_C324B53D93CB796C FOREIGN KEY (file_id) REFERENCES "blog__file" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__comment" ADD CONSTRAINT FK_94619736F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__comment" ADD CONSTRAINT FK_946197364B89032C FOREIGN KEY (post_id) REFERENCES "blog__post" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__direct_message" ADD CONSTRAINT FK_7A968E9FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__friendship" ADD CONSTRAINT FK_C84FC8D96A5458E8 FOREIGN KEY (friend_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__message" ADD CONSTRAINT FK_B6A8F525F624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__message" ADD CONSTRAINT FK_B6A8F52514399779 FOREIGN KEY (parent_message_id) REFERENCES "blog__message" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__message" ADD CONSTRAINT FK_B6A8F525445FD6FA FOREIGN KEY (direct_message_id) REFERENCES "blog__direct_message" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__message" ADD CONSTRAINT FK_B6A8F5254E697881 FOREIGN KEY (user_direct_message_history_id) REFERENCES "blog_histories__user_direct_message" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__post" ADD CONSTRAINT FK_F7405F5EF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog__post" ADD CONSTRAINT FK_F7405F5E12469DE2 FOREIGN KEY (category_id) REFERENCES "blog__category" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_tag ADD CONSTRAINT FK_5ACE3AF04B89032C FOREIGN KEY (post_id) REFERENCES "blog__post" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_tag ADD CONSTRAINT FK_5ACE3AF0BAD26311 FOREIGN KEY (tag_id) REFERENCES "blog__tag" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog_histories__post_action" ADD CONSTRAINT FK_92FBD5EAF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog_histories__post_action" ADD CONSTRAINT FK_92FBD5EA4B89032C FOREIGN KEY (post_id) REFERENCES "blog__post" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog_histories__user_direct_message" ADD CONSTRAINT FK_6AA0A1D7CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "blog_histories__user_friendship_request" ADD CONSTRAINT FK_770E39846A5458E8 FOREIGN KEY (friend_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "rss__result" ADD CONSTRAINT FK_E2AA83D1F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "blog__attachment_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__category_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__comment_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__direct_message_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__file_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__friendship_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__message_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__post_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog__tag_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog_histories__post_action_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog_histories__user_direct_message_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "blog_histories__user_friendship_request_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "rss__result_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "rss_group_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "blog__attachment" DROP CONSTRAINT FK_C324B53D4B89032C');
        $this->addSql('ALTER TABLE "blog__attachment" DROP CONSTRAINT FK_C324B53D93CB796C');
        $this->addSql('ALTER TABLE "blog__comment" DROP CONSTRAINT FK_94619736F675F31B');
        $this->addSql('ALTER TABLE "blog__comment" DROP CONSTRAINT FK_946197364B89032C');
        $this->addSql('ALTER TABLE "blog__direct_message" DROP CONSTRAINT FK_7A968E9FCD53EDB6');
        $this->addSql('ALTER TABLE "blog__friendship" DROP CONSTRAINT FK_C84FC8D96A5458E8');
        $this->addSql('ALTER TABLE "blog__message" DROP CONSTRAINT FK_B6A8F525F624B39D');
        $this->addSql('ALTER TABLE "blog__message" DROP CONSTRAINT FK_B6A8F52514399779');
        $this->addSql('ALTER TABLE "blog__message" DROP CONSTRAINT FK_B6A8F525445FD6FA');
        $this->addSql('ALTER TABLE "blog__message" DROP CONSTRAINT FK_B6A8F5254E697881');
        $this->addSql('ALTER TABLE "blog__post" DROP CONSTRAINT FK_F7405F5EF675F31B');
        $this->addSql('ALTER TABLE "blog__post" DROP CONSTRAINT FK_F7405F5E12469DE2');
        $this->addSql('ALTER TABLE post_tag DROP CONSTRAINT FK_5ACE3AF04B89032C');
        $this->addSql('ALTER TABLE post_tag DROP CONSTRAINT FK_5ACE3AF0BAD26311');
        $this->addSql('ALTER TABLE "blog_histories__post_action" DROP CONSTRAINT FK_92FBD5EAF675F31B');
        $this->addSql('ALTER TABLE "blog_histories__post_action" DROP CONSTRAINT FK_92FBD5EA4B89032C');
        $this->addSql('ALTER TABLE "blog_histories__user_direct_message" DROP CONSTRAINT FK_6AA0A1D7CD53EDB6');
        $this->addSql('ALTER TABLE "blog_histories__user_friendship_request" DROP CONSTRAINT FK_770E39846A5458E8');
        $this->addSql('ALTER TABLE "rss__result" DROP CONSTRAINT FK_E2AA83D1F675F31B');
        $this->addSql('DROP TABLE "blog__attachment"');
        $this->addSql('DROP TABLE "blog__category"');
        $this->addSql('DROP TABLE "blog__comment"');
        $this->addSql('DROP TABLE "blog__direct_message"');
        $this->addSql('DROP TABLE "blog__file"');
        $this->addSql('DROP TABLE "blog__friendship"');
        $this->addSql('DROP TABLE "blog__message"');
        $this->addSql('DROP TABLE "blog__post"');
        $this->addSql('DROP TABLE post_tag');
        $this->addSql('DROP TABLE "blog__tag"');
        $this->addSql('DROP TABLE "blog_histories__post_action"');
        $this->addSql('DROP TABLE "blog_histories__user_direct_message"');
        $this->addSql('DROP TABLE "blog_histories__user_friendship_request"');
        $this->addSql('DROP TABLE "rss__result"');
        $this->addSql('DROP TABLE "rss_group"');
        $this->addSql('DROP TABLE "user"');
    }
}
