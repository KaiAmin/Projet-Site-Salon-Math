
-- Drop table pour éviter les soucis 
    DROP TABLE IF EXISTS superviseur,professeur,etablissement,Stand,NiveauVisiteur,Reservation,Logs,Creneau,Logs_user;

--  Table du professeur, on stock le nom de son établissement ainsi que le niveau de ses élèves  
    -- Peut-être faire une table pour stocker tout les etablissements ?
    CREATE TABLE Professeur(
         id_professeur serial unique PRIMARY KEY,
         mail varchar(100),
         nom varchar(50),
         prenom varchar(50),
         etablissement varchar(150), --fk!!
         niveau varchar(20),
         nombreEleve int,
         mdp varchar(150)
    );

    CREATE TABLE Etablissement(
        nom_etablissement varchar(150) PRIMARY key, --fk!!
        ville varchar(150),
        codePostale integer
    );

-- Table du superviseur, les superviseurs n'ont pas besoin de beaucoup d'info.
    CREATE TABLE Superviseur(
        id_superviseur serial unique PRIMARY KEY,
        surnom varchar(50)
    );


-- Stand, différente animations/stands qui seront utiliser dans les créneaux. 
    CREATE TABLE Stand(
        id_stand serial unique PRIMARY KEY,
        nom_stand varchar(50),
        description varchar(1500),
        niveau_visiteur varchar(20), -- fk
        capacite varchar(20),
        allDay boolean,
        duree integer,
        interSession integer,
        pauseDebut time,
        pauseFin time
        );

-- Table niveau des visiteurs 
    CREATE TABLE NiveauVisiteur(
    id_niveau varchar(20) PRIMARY KEY, -- id_niveau : 'P' = Primaire | 'LC' = Lycee et college
    nom_niveau varchar(120) -- nom de niveau : College/Lycee
    );

-- Table ou un exposant pourra ajouter des créneaux et ou un professeur pourra réserver des créneaux. 
    CREATE TABLE Reservation(
        id_reservation serial unique PRIMARY KEY,
        id_creneau integer, -- fk
        id_professeur integer , -- fk
        nbPlace_prise integer
    );

-- Relevé des activités sur la table faites par le superviseur ou par un exposant, une modification sur l'emploi du temps ou la suppression d'un créneau.
    -- Assez flou pour l'instant a voir...
    CREATE TABLE Logs(
        id_logs serial unique PRIMARY KEY,
        type_modif varchar(50),
        date_modif date,
        nom_table varchar(50),
        id_user integer 
    );

-- Les logs d'utilisateur, si l'user change d'email il faut le sauvegarder
    CREATE TABLE Logs_user(
    id_logs_user serial unique PRIMARY KEY,
    type_modif varchar(50),
    date_modif varchar(50),
    val_modif varchar(50),
    id_user int -- fk
    );

-- Creneau des differentes acitivité. Seul le superviseur pourra ajouter des créneaux 
    CREATE TABLE Creneau(
        id_creneau serial unique PRIMARY KEY,
        nbPlace_restant integer,
        date_creneau date,
        heure_debut time,
        heure_fin time,
        id_stand integer,
        id_superviseur integer
    );


-- Ici mes commentaires sur chaque table | \d+ nom_table pour lire les commentaires


    COMMENT ON COLUMN professeur.etablissement IS 'L établisemment du professeur (Lycée Jean Ferry,...)';
    COMMENT ON COLUMN professeur.niveau IS 'On renvoie vers la table niveauVisiteur';
    COMMENT ON COLUMN stand.niveau_visiteur IS 'On prend l id de la table niveauVisiteur';
    COMMENT ON COLUMN logs.type_modif IS 'Quelle type de modification à été faite';
    COMMENT ON COLUMN logs.date_modif IS 'Quand est-ce que il y a eu modification';
    COMMENT ON COLUMN logs.nom_table IS 'Sur quelle table il y a eu modification';
    COMMENT ON COLUMN logs.id_user IS 'Qui a fait la modification';


-- (??-PAS BESOIN-??) Ici on initialise les id de chaque table et on fait en sort qu'elle s'augmente seul


    ALTER SEQUENCE Stand_id_stand_seq RESTART WITH 1 INCREMENT BY 1;
    ALTER SEQUENCE Reservation_id_reservation_seq RESTART WITH 1 INCREMENT BY 1;
    ALTER SEQUENCE Creneau_id_creneau_seq RESTART WITH 1 INCREMENT BY 1;
    ALTER SEQUENCE Logs_id_logs_seq RESTART WITH 1 INCREMENT BY 1;
    ALTER SEQUENCE Logs_user_id_logs_user_seq RESTART WITH 1 INCREMENT BY 1;
    ALTER SEQUENCE Professeur_id_professeur_seq RESTART WITH 1 INCREMENT BY 1;
    ALTER SEQUENCE Superviseur_id_superviseur_seq RESTART WITH 1 INCREMENT BY 1;

-- On met en place les foreign key  

    ALTER TABLE Professeur ADD FOREIGN KEY (etablissement) REFERENCES Etablissement(nom_etablissement); 
    ALTER TABLE Professeur ADD FOREIGN KEY (niveau) REFERENCES NiveauVisiteur(id_niveau);

    ALTER TABLE Stand ADD FOREIGN KEY (niveau_visiteur) REFERENCES NiveauVisiteur(id_niveau);

    ALTER TABLE Reservation ADD FOREIGN KEY (id_professeur) REFERENCES Professeur(id_professeur);
    ALTER TABLE Reservation ADD FOREIGN KEY (id_creneau) REFERENCES Creneau(id_creneau);

    ALTER TABLE Creneau ADD FOREIGN KEY (id_superviseur) REFERENCES Superviseur(id_superviseur);
    ALTER TABLE Creneau ADD FOREIGN KEY (id_stand) REFERENCES Stand(id_stand);
    
-- Fonctions
/**
CREATE OR REPLACE FUNCTION getNiveau(in varchar,out niveau varchar) returns varchar
as
$$
    BEGIN
        WITH niveaux as (
        select unnest(string_to_array(tempo.niveau, ', ')) as niveau from tempo where nom_stand=$1 group by tempo.niveau
        )
        select count(*) case when count=3 THEN 'PCL' END niveau from niveaux group by count;
    END;
    $$ language plpgsql SECURITY DEFINER;

select getNiveau('PlayMaths'); 
*/

-- Fonctions utiliser par les triggers 

    CREATE OR REPLACE FUNCTION trigger_nbPlace() RETURNS trigger as $$
        DECLARE
            nb_place int;
                BEGIN
                    IF (NEW.nbPlace_prise) IS NULL THEN
                        RAISE EXCEPTION 'Le nombre de place ne peut pas être NULL';
                    END IF;
                select NEW.nbPlace_prise from Reservation into nb_place;
                    update Creneau set nbPlace_restant= (nbPlace_restant-nb_place) where NEW.id_creneau=id_creneau;
                RETURN NULL;    
        END;
    $$ language plpgsql SECURITY DEFINER;

    CREATE OR REPLACE function trigger_logs() RETURNS trigger 
    as $$
        DECLARE
        id_table int;
        BEGIN 
            
            insert into Logs (type_modif,date_modif,nom_table,id_user) 
            VALUES (TG_OP,now(),TG_TABLE_NAME,TG_RELID);
            RETURN NULL;    
        END;
    $$ language plpgsql SECURITY DEFINER;


-- Ici la création des triggers

    -- trigger qui modifie le nombre de place restant dans un créneau lorsque l'on réserve
    CREATE TRIGGER trigger_nbPlace BEFORE INSERT OR UPDATE ON Reservation
        FOR EACH ROW EXECUTE PROCEDURE trigger_nbPlace();
    -- triggers qui ajoute automatiquement au logs les modifications faites sur les autres tables
    CREATE TRIGGER trigger_logs AFTER INSERT OR UPDATE OR DELETE ON Reservation
        FOR EACH ROW EXECUTE PROCEDURE trigger_logs();
    
    --CREATE TRIGGER trigger_logs AFTER INSERT OR UPDATE OR DELETE ON Utilisateur FOR EACH ROW EXECUTE PROCEDURE trigger_logs();    
    
    CREATE TRIGGER trigger_logs AFTER INSERT OR UPDATE OR DELETE ON stand
        FOR EACH ROW EXECUTE PROCEDURE trigger_logs();
    CREATE TRIGGER trigger_logs AFTER INSERT OR UPDATE OR DELETE ON Creneau
        FOR EACH ROW EXECUTE PROCEDURE trigger_logs();