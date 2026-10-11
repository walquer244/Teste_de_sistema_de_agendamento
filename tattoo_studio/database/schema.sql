-- =====================================================================
-- INK STUDIO - DATABASE SCHEMA & SEED DATA DUMP
-- Import via phpMyAdmin, MySQL Workbench, DBeaver or mysql CLI
-- mysql -u root -p < schema.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `tattoo_studio` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tattoo_studio`;

-- Ensure user permissions
CREATE USER IF NOT EXISTS 'tattoo_user'@'%' IDENTIFIED BY 'tattoo_password';
GRANT ALL PRIVILEGES ON `tattoo_studio`.* TO 'tattoo_user'@'%';
FLUSH PRIVILEGES;

-- ---------------------------------------------------------------------
-- Table: users
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: password_reset_tokens
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: sessions
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: cache & cache_locks
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: jobs, job_batches, failed_jobs
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: migrations (Laravel migration tracking)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: funcionarios
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foto_perfil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idade` int NOT NULL,
  `data_admissao` date NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `funcao` enum('tatuador','atendente','gerente','auxiliar','recepcionista') COLLATE utf8mb4_unicode_ci NOT NULL,
  `especialidade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: agendamentos
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `agendamentos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foto_perfil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idade_cliente` int NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem_tatuagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao_tatuagem` text COLLATE utf8mb4_unicode_ci,
  `local_corpo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tamanho` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_agendamento` date NOT NULL,
  `hora_agendamento` time NOT NULL,
  `valor_estimado` decimal(10,2) DEFAULT NULL,
  `forma_pagamento` enum('dinheiro','cartao_credito','cartao_debito','pix','transferencia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `parcelas` int NOT NULL DEFAULT '1',
  `status` enum('pendente','confirmado','concluido','cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendente',
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `funcionario_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agendamentos_funcionario_id_foreign` (`funcionario_id`),
  CONSTRAINT `agendamentos_funcionario_id_foreign` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: galerias
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `galerias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_perfil_cliente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem_tatuagem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estilo_tatuagem` enum('realismo','blackwork','aquarela','old_school','new_school','geometrico','minimalista','tribal','japones','dotwork','fineline','trash_polka','neotradicional','lettering','outro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avaliacao_atendimento` int NOT NULL DEFAULT '5',
  `avaliacao_resultado` int NOT NULL DEFAULT '5',
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `destaque` tinyint(1) NOT NULL DEFAULT '0',
  `funcionario_id` bigint unsigned NOT NULL,
  `agendamento_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galerias_funcionario_id_foreign` (`funcionario_id`),
  KEY `galerias_agendamento_id_foreign` (`agendamento_id`),
  CONSTRAINT `galerias_agendamento_id_foreign` FOREIGN KEY (`agendamento_id`) REFERENCES `agendamentos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `galerias_funcionario_id_foreign` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Insert Migration entries so Laravel recognises schema
-- ---------------------------------------------------------------------
INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000010_create_funcionarios_table', 1),
(5, '2024_01_01_000020_create_agendamentos_table', 1),
(6, '2024_01_01_000030_create_galerias_table', 1);

-- ---------------------------------------------------------------------
-- Seed Data: users (Password: password)
-- ---------------------------------------------------------------------
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Administrador Ink Studio', 'admin@inkstudio.com', '$2y$12$R0kXG1wAecmF8wGgq6c3Uee7dJkvz49h.Y4Z5e0k5iI50p1p8gQ2W', NOW(), NOW());

-- ---------------------------------------------------------------------
-- Seed Data: funcionarios
-- ---------------------------------------------------------------------
INSERT INTO `funcionarios` (`id`, `foto_perfil`, `nome`, `idade`, `data_admissao`, `salario`, `funcao`, `especialidade`, `bio`, `instagram`, `ativo`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Marcus Silva', 32, '2022-03-15', 6500.00, 'tatuador', 'Realismo & Blackwork', 'Especialista em retratos realistas em preto e cinza com mais de 8 anos de experiência internacional.', '@marcus.tattoos', 1, NOW(), NOW()),
(2, NULL, 'Camila Rossi', 28, '2022-07-01', 5800.00, 'tatuador', 'Fineline & Floral', 'Traços finos, microrealismo botânico e delicadeza em cada detalhe. Formada em Artes Visuais.', '@camila.fineline', 1, NOW(), NOW()),
(3, NULL, 'Diego Aoki', 35, '2021-11-10', 7200.00, 'tatuador', 'Oriental & Neo Tradicional', 'Mestre na tradição oriental e neo tradicional com cores vibrantes e anatomia precisa.', '@diego.aoki.ink', 1, NOW(), NOW()),
(4, NULL, 'Lucas Ferreira', 29, '2023-01-20', 5200.00, 'tatuador', 'Old School & Lettering', 'Apaixonado pela estética clássica americana, tipografias customizadas e traços sólidos.', '@lucas.ferreira.art', 1, NOW(), NOW()),
(5, NULL, 'Beatriz Mendes', 24, '2023-05-10', 2600.00, 'recepcionista', NULL, 'Responsável pelo atendimento aos clientes, recepção e agendamento de consultas e sessões.', '@beatriz.mendes', 1, NOW(), NOW()),
(6, NULL, 'Rodrigo Alcantara', 41, '2021-01-15', 5500.00, 'gerente', NULL, 'Gestor operacional do Ink Studio, cuidando da biossegurança, compras e suporte aos artistas.', '@rodrigo.alcantara', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `nome`=VALUES(`nome`);

-- ---------------------------------------------------------------------
-- Seed Data: agendamentos
-- ---------------------------------------------------------------------
INSERT INTO `agendamentos` (`id`, `foto_perfil`, `nome_cliente`, `idade_cliente`, `telefone`, `email`, `imagem_tatuagem`, `descricao_tatuagem`, `local_corpo`, `tamanho`, `data_agendamento`, `hora_agendamento`, `valor_estimado`, `forma_pagamento`, `parcelas`, `status`, `observacoes`, `funcionario_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Larissa Souza', 26, '(11) 98765-4321', 'larissa.souza@gmail.com', NULL, 'Ramo de oliveira com rosas delicadas em fineline', 'Antebraço direito', '15cm', '2026-10-10', '14:00:00', 850.00, 'pix', 1, 'concluido', 'Cliente sem alergias conhecidas, ótima cicatrização.', 2, NOW(), NOW()),
(2, NULL, 'Gabriel Martins', 31, '(11) 97654-3210', 'gabriel.martins@outlook.com', NULL, 'Leão em realismo com detalhes geométricos na juba', 'Braço esquerdo (fechamento)', '25cm', '2026-10-09', '10:00:00', 1800.00, 'cartao_credito', 3, 'concluido', 'Sessão de fechamento finalizada com sucesso.', 1, NOW(), NOW()),
(3, NULL, 'Thiago Oliveira', 29, '(11) 96543-2109', 'thiago.oliveira@gmail.com', NULL, 'Dragão oriental clássico com flores de cerejeira', 'Costas', 'Fechamento parcial', '2026-10-11', '15:30:00', 2500.00, 'pix', 1, 'confirmado', 'Segunda sessão do projeto. Tinta vegetal.', 3, NOW(), NOW()),
(4, NULL, 'Juliana Castro', 24, '(11) 95432-1098', 'juliana.castro@gmail.com', NULL, 'Adaga tradicional com serpente e rosas old school', 'Coxa direita', '18cm', '2026-10-12', '11:00:00', 950.00, 'cartao_debito', 1, 'confirmado', 'Arte pré-aprovada pelo WhatsApp.', 4, NOW(), NOW()),
(5, NULL, 'Bruno Albuquerque', 33, '(11) 94321-0987', 'bruno.alb@gmail.com', NULL, 'Retrato estilo estátua grega em blackwork texturizado', 'Panturrilha', '20cm', '2026-10-13', '14:00:00', 1400.00, 'cartao_credito', 2, 'pendente', 'Aguardando envio da imagem de referência de alta resolução.', 1, NOW(), NOW()),
(6, NULL, 'Fernanda Lima', 27, '(11) 93210-9876', 'fernanda.lima@hotmail.com', NULL, 'Constelação com lettering minimalista no pulso', 'Pulso esquerdo', '8cm', '2026-10-14', '16:00:00', 450.00, 'pix', 1, 'pendente', 'Primeira tatuagem da cliente.', 2, NOW(), NOW()),
(7, NULL, 'Rafael Santos', 38, '(11) 92109-8765', 'rafael.santos@gmail.com', NULL, 'Máscara Hannya com ondas e folhas de bordo', 'Ombro', '16cm', '2026-10-15', '09:30:00', 1600.00, 'transferencia', 1, 'confirmado', 'Agendado após consulta presencial.', 3, NOW(), NOW())
ON DUPLICATE KEY UPDATE `nome_cliente`=VALUES(`nome_cliente`);

-- ---------------------------------------------------------------------
-- Seed Data: galerias
-- ---------------------------------------------------------------------
INSERT INTO `galerias` (`id`, `nome_cliente`, `foto_perfil_cliente`, `imagem_tatuagem`, `estilo_tatuagem`, `avaliacao_atendimento`, `avaliacao_resultado`, `comentario`, `destaque`, `funcionario_id`, `agendamento_id`, `created_at`, `updated_at`) VALUES
(1, 'Larissa Souza', NULL, '', 'fineline', 5, 5, 'Experiência impecável! A Camila tem a mão super leve e os traços ficaram absurdamente perfeitos.', 1, 2, 1, NOW(), NOW()),
(2, 'Gabriel Martins', NULL, '', 'realismo', 5, 5, 'O Marcus é um gênio do realismo. Parece uma fotografia na minha pele! Super recomendo.', 1, 1, 2, NOW(), NOW()),
(3, 'Pedro Henrique', NULL, '', 'blackwork', 5, 5, 'Trabalho de pretos sólidos impecável. O estúdio tem uma vibe incrível e biossegurança de ponta.', 1, 1, NULL, NOW(), NOW()),
(4, 'Mariana Costa', NULL, '', 'fineline', 5, 5, 'Minha primeira tatuagem e foi maravilhoso. Traço fino e delicado exatamente como eu sonhava.', 0, 2, NULL, NOW(), NOW()),
(5, 'Eduardo Ramos', NULL, '', 'japones', 5, 5, 'Diego é referência em estilo oriental. Cores vivas e contraste perfeito!', 1, 3, NULL, NOW(), NOW()),
(6, 'Carla Vieira', NULL, '', 'old_school', 5, 5, 'Lucas mandou muito bem na composição tradicional! As cores ficaram intensas demais.', 0, 4, NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `nome_cliente`=VALUES(`nome_cliente`);
