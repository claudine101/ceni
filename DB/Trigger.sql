-- Suppression des anciens déclencheurs pour votes
DROP TRIGGER IF EXISTS prevent_votes_insert;
DROP TRIGGER IF EXISTS prevent_votes_update;
DROP TRIGGER IF EXISTS prevent_votes_delete;
DROP TRIGGER IF EXISTS update_is_current_event;


-- Suppression des anciens déclencheurs pour resultants_votes
DROP TRIGGER IF EXISTS prevent_resultants_votes_insert;
DROP TRIGGER IF EXISTS prevent_resultants_votes_update;
DROP TRIGGER IF EXISTS prevent_resultants_votes_delete;


DELIMITER $$



-- Déclencheur pour empêcher les insertions dans votes
CREATE TRIGGER prevent_votes_insert
BEFORE INSERT ON votes
FOR EACH ROW
BEGIN
    IF @is_from_application IS NULL OR @is_from_application = FALSE THEN
        -- Enregistre la tentative dans la table de log
        INSERT INTO journal_tentatives (operation, utilisateur) 
        VALUES (CONCAT("Tentative d\'insertion interdite dans la table votes pour ID: ", NEW.ID_VOTE ), USER());

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Insertion interdite dans la table votes';
    END IF;
END$$

-- Déclencheur pour empêcher les mises à jour dans votes
CREATE TRIGGER prevent_votes_update
BEFORE UPDATE ON votes
FOR EACH ROW
BEGIN
    IF @is_from_application IS NULL OR @is_from_application = FALSE THEN
        -- Enregistre la tentative dans la table de log
        INSERT INTO journal_tentatives (operation, utilisateur) 
        VALUES (CONCAT('Tentative de mise à jour interdite dans la table votes pour ID: ', OLD.ID_VOTE ), USER());

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Mise à jour interdite dans la table votes';
    END IF;
END$$

-- Déclencheur pour empêcher les suppressions dans votes
CREATE TRIGGER prevent_votes_delete
BEFORE DELETE ON votes
FOR EACH ROW
BEGIN
    IF @is_from_application IS NULL OR @is_from_application = FALSE THEN
        -- Enregistre la tentative dans la table de log
        INSERT INTO journal_tentatives (operation, utilisateur) 
        VALUES (CONCAT('Tentative de suppression interdite dans la table votes pour ID: ', OLD.ID_VOTE ), USER());

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Suppression interdite dans la table votes';
    END IF;
END$$

-- Déclencheur pour empêcher les insertions dans resultants_votes
CREATE TRIGGER prevent_resultants_votes_insert
BEFORE INSERT ON resultants_votes
FOR EACH ROW
BEGIN
    IF @is_from_application IS NULL OR @is_from_application = FALSE THEN
        -- Enregistre la tentative dans la table de log
        INSERT INTO journal_tentatives (operation, utilisateur) 
        VALUES (CONCAT("Tentative d\'insertion interdite dans la table resultants_votes pour ID_CANDIDAT: ", NEW.ID_RESULTANT_VOTE ), USER());

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Insertion interdite dans la table resultants_votes';
    END IF;
END$$

-- Déclencheur pour empêcher les mises à jour dans resultants_votes
CREATE TRIGGER prevent_resultants_votes_update
BEFORE UPDATE ON resultants_votes
FOR EACH ROW
BEGIN
    IF @is_from_application IS NULL OR @is_from_application = FALSE THEN
        -- Enregistre la tentative dans la table de log
        INSERT INTO journal_tentatives (operation, utilisateur) 
        VALUES (CONCAT('Tentative de mise à jour interdite dans la table resultants_votes pour ID_CANDIDAT: ', OLD.ID_RESULTANT_VOTE ), USER());

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Mise à jour interdite dans la table resultants_votes';
    END IF;
END$$

-- Déclencheur pour empêcher les suppressions dans resultants_votes
CREATE TRIGGER prevent_resultants_votes_delete
BEFORE DELETE ON resultants_votes
FOR EACH ROW
BEGIN
    IF @is_from_application IS NULL OR @is_from_application = FALSE THEN
        -- Enregistre la tentative dans la table de log
        INSERT INTO journal_tentatives (operation, utilisateur) 
        VALUES (CONCAT('Tentative de suppression interdite dans la table resultants_votes pour ID_CANDIDAT: ', OLD.ID_RESULTANT_VOTE ), USER());

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Suppression interdite dans la table resultants_votes';
    END IF;
END$$

DELIMITER ;






DELIMITER //

CREATE EVENT update_is_current_event
ON SCHEDULE EVERY 1 DAY
STARTS '2024-12-14 00:00:00'  -- Date et heure de début
DO
BEGIN
    UPDATE session_votes
    SET IS_CURRENT = CASE
        WHEN NOW() BETWEEN DATE_DEBUT AND DATE_FIN THEN 1
        WHEN NOW() > DATE_FIN THEN 0
        WHEN NOW() < DATE_DEBUT THEN 2
        ELSE IS_CURRENT
    END;
END;

//


POUR VERIFIER AGE 

DELIMITER //



CREATE TRIGGER check_age_before_insert
BEFORE INSERT ON participants
FOR EACH ROW
BEGIN
  DECLARE age INT;
  SET age = TIMESTAMPDIFF(YEAR, NEW.DATE_NAISSANCE, CURDATE());
  
  IF (NEW.IS_CANDIDAT = 1 AND age < 35) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Un candidat doit avoir au moins 35 ans.';
  END IF;

  IF (NEW.IS_CANDIDAT = 0 AND age < 18) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Un électeur doit avoir au moins 18 ans.';
  END IF;
END; //

DELIMITER //



DELIMITER //

CREATE TRIGGER check_age_before_update
BEFORE UPDATE ON participants
FOR EACH ROW
BEGIN
  DECLARE age INT;
  SET age = TIMESTAMPDIFF(YEAR, NEW.DATE_NAISSANCE, CURDATE());
  
  IF (NEW.IS_CANDIDAT = 1 AND age < 35) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Un candidat doit avoir au moins 35 ans.';
  END IF;

  IF (NEW.IS_CANDIDAT = 0 AND age < 18) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Un électeur doit avoir au moins 18 ans.';
  END IF;
END; //

DELIMITER //