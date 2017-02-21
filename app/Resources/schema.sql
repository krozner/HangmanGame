SET foreign_key_checks = 0;


DROP TABLE IF EXISTS hangman_game_status;
CREATE TABLE hangman_game_status (
  status_id     INT UNSIGNED NOT NULL,
  name          VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (status_id)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO hangman_game_status (status_id, name) VALUES
  (1, 'Busy'),
  (2, 'Fail'),
  (3, 'Success')
;

DROP TABLE IF EXISTS hangman_word_category;
CREATE TABLE hangman_word_category (
  category_id   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name          VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (category_id)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE UNIQUE INDEX UNIQ_hangman_word_category_name ON hangman_word_category(name);


DROP TABLE IF EXISTS hangman_word;
CREATE TABLE hangman_word (
  word_id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id   INT UNSIGNED NOT NULL,
  word          VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL,
  hint          VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (word_id),
  CONSTRAINT fk_hangman_word_category_id FOREIGN KEY (category_id)
    REFERENCES hangman_word_category(category_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


DROP TABLE IF EXISTS hangman_game;
CREATE TABLE hangman_game (
  game_id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  word_id       INT UNSIGNED NOT NULL,
  status_id     INT UNSIGNED NOT NULL,
  tries_left    INT UNSIGNED NOT NULL,
  characters_guessed TEXT COLLATE utf8_unicode_ci NULL COMMENT '(DC2Type:array)',
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (game_id),
  CONSTRAINT fk_hangman_game_word_id FOREIGN KEY (word_id)
      REFERENCES hangman_word(word_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT fk_hangman_game_status_id FOREIGN KEY (status_id)
      REFERENCES hangman_game_status(status_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


SET foreign_key_checks = 1;