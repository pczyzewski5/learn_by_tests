CREATE TABLE questions
(
    id          VARCHAR(36) NOT NULL,
    question    TEXT NOT NULL,
    created_at  DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
