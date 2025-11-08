USE draftosaurus_db;

INSERT INTO Games (date_played, winner_id) VALUES
(CURDATE(), NULL),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), NULL),
(DATE_SUB(CURDATE(), INTERVAL 2 DAY), NULL);

-- Insertar jugadores por partida con puntaje inicial 0

-- Partida 1
INSERT INTO GamePlayers (game_id, user_id, score) VALUES
(1, 1, 150),  -- Marcos
(1, 2, 120),  -- Nacho
(1, 3, 100),  -- Marcel
(1, 4, 90),   -- Gabriel
(1, 5, 80);   -- Luis

-- Partida 2
INSERT INTO GamePlayers (game_id, user_id, score) VALUES
(2, 1, 130),  -- Marcos
(2, 2, 140),  -- Nacho
(2, 3, 110),  -- Marcel
(2, 4, 95),   -- Gabriel
(2, 5, 85);   -- Luis

-- Partida 3
INSERT INTO GamePlayers (game_id, user_id, score) VALUES
(3, 1, 160),  -- Marcos
(3, 2, 135),  -- Nacho
(3, 3, 120),  -- Marcel
(3, 4, 100),  -- Gabriel
(3, 5, 90);   -- Luis

-- Inserts Dinno-runner

INSERT INTO `Dinosaurs` (`dino_id`, `species`, `weight`, `sprite_frame1`, `sprite_frame2`) VALUES
(1, 'T-Rex', 90, 't-rex_f1.png', 't-rex_f2.png'),
(2, 'Diplodocus', 120, 'diplodocus_f1.png', 'diplodocus_f2.png'),
(3, 'Triceratops', 80, 'triceratops_f1.png', 'triceratops_f2.png'),
(4, 'Estegosaurio', 65, 'estegosaurio_f1.png', 'estegosaurio_f2.png'),
(5, 'Espinosaurio', 70, 'espinosaurio_f1.png', 'espinosaurio_f2.png'),
(6, 'Parasaurolofus', 50, 'parasaurolofus_f1.png', 'parasaurolofus_f2.png');