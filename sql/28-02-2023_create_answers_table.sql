CREATE TABLE answers
(
    id             VARCHAR(36) NOT NULL,
    question_id    VARCHAR(36) NOT NULL,
    answer         TEXT NOT NULL,
    is_correct     BOOLEAN NOT NULL,
    created_at     DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
