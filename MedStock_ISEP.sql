-- ============================================================
-- MedStock — Base de Dados
-- Sistema de Gestão de Equipamentos Médicos
-- Servidor ISEP — vsgate-s1.dei.isep.ipp.pt
-- ============================================================

-- ============================================================
-- LIMPEZA (ordem inversa das dependências)
-- ============================================================
DROP TABLE IF EXISTS Documento;
DROP TABLE IF EXISTS Garantia;
DROP TABLE IF EXISTS Equipamento;
DROP TABLE IF EXISTS Localizacao;
DROP TABLE IF EXISTS Fornecedor;

-- ============================================================
-- TABELA: Fornecedor
-- ============================================================
CREATE TABLE Fornecedor (
    idFornecedor    INT             AUTO_INCREMENT,
    nome            VARCHAR(150)    NOT NULL,
    nif             VARCHAR(20)     NOT NULL UNIQUE,
    tipo            VARCHAR(60)     NOT NULL,
    morada          VARCHAR(255),
    telefone        VARCHAR(30),
    email           VARCHAR(100),
    website         VARCHAR(200),
    pessoaContacto  VARCHAR(100),
    telContacto     VARCHAR(30),
    observacoes     TEXT,
    CONSTRAINT pkFornecedoridFornecedor PRIMARY KEY (idFornecedor)
);

-- ============================================================
-- TABELA: Localizacao
-- ============================================================
CREATE TABLE Localizacao (
    idLocalizacao   INT             AUTO_INCREMENT,
    servico         VARCHAR(100)    NOT NULL,
    edificio        VARCHAR(100),
    piso            VARCHAR(30),
    sala            VARCHAR(50),
    CONSTRAINT pkLocalizacaoidLocalizacao PRIMARY KEY (idLocalizacao)
);

-- ============================================================
-- TABELA: Equipamento
-- ============================================================
CREATE TABLE Equipamento (
    codigoInterno   VARCHAR(20)     NOT NULL,
    designacao      VARCHAR(150)    NOT NULL,
    categoria       VARCHAR(50)     NOT NULL,
    estado          VARCHAR(30)     NOT NULL,
    criticidade     VARCHAR(30)     NOT NULL,
    marca           VARCHAR(80)     NOT NULL,
    modelo          VARCHAR(80)     NOT NULL,
    fabricante      VARCHAR(100),
    numSerie        VARCHAR(80)     NOT NULL UNIQUE,
    anoFabrico      SMALLINT,
    dataAquisicao   DATE,
    custoAquisicao  DECIMAL(12, 2),
    tipoEntrada     VARCHAR(20),
    idFornecedor    INT,
    idLocalizacao   INT,
    observacoes     TEXT,
    CONSTRAINT pkEquipamentocodigoInterno PRIMARY KEY (codigoInterno)
);

ALTER TABLE Equipamento
    ADD CONSTRAINT fkEquipamentoFornecedor
        FOREIGN KEY (idFornecedor) REFERENCES Fornecedor (idFornecedor);

ALTER TABLE Equipamento
    ADD CONSTRAINT fkEquipamentoLocalizacao
        FOREIGN KEY (idLocalizacao) REFERENCES Localizacao (idLocalizacao);

-- ============================================================
-- TABELA: Documento
-- ============================================================
CREATE TABLE Documento (
    idDocumento         INT             AUTO_INCREMENT,
    tipo                VARCHAR(60)     NOT NULL,
    nomeDocumento       VARCHAR(200)    NOT NULL,
    codigoEquipamento   VARCHAR(20)     NOT NULL,
    idFornecedor        INT,
    dataDocumento       DATE,
    dataValidade        DATE,
    caminhoFicheiro     VARCHAR(500),
    CONSTRAINT pkDocumentoidDocumento PRIMARY KEY (idDocumento)
);

ALTER TABLE Documento
    ADD CONSTRAINT fkDocumentoEquipamento
        FOREIGN KEY (codigoEquipamento) REFERENCES Equipamento (codigoInterno);

ALTER TABLE Documento
    ADD CONSTRAINT fkDocumentoFornecedor
        FOREIGN KEY (idFornecedor) REFERENCES Fornecedor (idFornecedor);

-- ============================================================
-- TABELA: Garantia
-- ============================================================
CREATE TABLE Garantia (
    idGarantia          INT             AUTO_INCREMENT,
    codigoEquipamento   VARCHAR(20)     NOT NULL,
    dataInicio          DATE            NOT NULL,
    dataFim             DATE            NOT NULL,
    temContrato         TINYINT(1)      NOT NULL DEFAULT 0,
    tipoContrato        VARCHAR(20),
    periodicidade       VARCHAR(20),
    idFornecedor        INT,
    numContrato         VARCHAR(50),
    observacoes         TEXT,
    CONSTRAINT pkGarantiaidGarantia PRIMARY KEY (idGarantia)
);

ALTER TABLE Garantia
    ADD CONSTRAINT fkGarantiaEquipamento
        FOREIGN KEY (codigoEquipamento) REFERENCES Equipamento (codigoInterno);

ALTER TABLE Garantia
    ADD CONSTRAINT fkGarantiaFornecedor
        FOREIGN KEY (idFornecedor) REFERENCES Fornecedor (idFornecedor);

-- ============================================================
-- DADOS DE EXEMPLO
-- ============================================================

-- Fornecedores
INSERT INTO Fornecedor (nome, nif, tipo, morada, telefone, email, website, pessoaContacto, telContacto) VALUES
  ('Philips Healthcare Portugal', '500123456', 'Fabricante', 'Av. Engenheiro Duarte Pacheco, 19, 1070-072 Lisboa', '+351 21 721 7200', 'healthcare.portugal@philips.com', 'https://www.philips.pt', 'Joao Figueiredo', '+351 912 345 678'),
  ('Drager Medical Portugal', '500234567', 'Empresa de assistencia tecnica', 'Rua da Garagem, 6, 2790-154 Carnaxide', '+351 21 424 8800', 'info.pt@draeger.com', 'https://www.draeger.com/pt', 'Ana Cardoso', '+351 916 789 012'),
  ('B. Braun Portugal', '500345678', 'Distribuidor / Fornecedor comercial', 'Av. do Brasil, 1649, 4100-130 Porto', '+351 22 609 8700', 'info@bbraun.pt', 'https://www.bbraun.pt', 'Carlos Mendes', '+351 931 234 567'),
  ('Zoll Medical Iberia', '500456789', 'Fabricante', 'Calle Orense, 34, 28020 Madrid', '+34 91 598 4530', 'iberia@zoll.com', 'https://www.zoll.com', 'Sofia Moreira', '+351 965 432 109'),
  ('GE Healthcare Portugal', '500567890', 'Fabricante', 'Torre Fernao de Magalhaes, Av. D. Joao II, 1990-083 Lisboa', '+351 21 413 2800', 'gehealthcare.pt@ge.com', 'https://www.gehealthcare.com', 'Rui Santos', '+351 917 654 321');

-- Localizacoes
INSERT INTO Localizacao (servico, edificio, piso, sala) VALUES
  ('UCI', 'Edificio Principal', 'Piso 3', 'Sala 301'),
  ('Medicina Interna', 'Edificio Principal', 'Piso 2', 'Sala 215'),
  ('Urgencia', 'Edificio de Urgencia', 'Piso 0', 'Sala U1'),
  ('Cardiologia', 'Edificio Principal', 'Piso 4', 'Sala 408'),
  ('Bloco Operatorio', 'Edificio Cirurgia', 'Piso 1', 'Sala B2'),
  ('Radiologia', 'Edificio de Meios Complementares', 'Piso 0', 'Sala R3'),
  ('Pediatria', 'Edificio Pediatrico', 'Piso 2', 'Sala P201');

-- Equipamentos
INSERT INTO Equipamento (codigoInterno, designacao, categoria, estado, criticidade, marca, modelo, fabricante, numSerie, anoFabrico, dataAquisicao, custoAquisicao, tipoEntrada, idFornecedor, idLocalizacao) VALUES
  ('04.002.00', 'Monitor multiparametrico', 'Monitorizacao', 'Ativo', 'Alta', 'Philips', 'IntelliVue MP5', 'Philips Healthcare', 'MP5-2022-45873', 2022, '2022-03-15', 18500.00, 'Compra', 1, 1),
  ('06.001.00', 'Ventilador pulmonar', 'Suporte de vida', 'Ativo', 'Suporte de vida', 'Drager', 'Evita V500', 'Drager Medical', 'EV500-2021-9934', 2021, '2021-06-20', 42000.00, 'Compra', 2, 1),
  ('03.005.00', 'Bomba de infusao', 'Terapia', 'Em manutencao', 'Media', 'B. Braun', 'Infusomat Space', 'B. Braun', 'INF-2020-88321', 2020, '2020-09-10', 3200.00, 'Compra', 3, 2),
  ('02.003.00', 'Desfibrilhador', 'Suporte de vida', 'Ativo', 'Suporte de vida', 'Zoll', 'R Series', 'Zoll Medical', 'ZR-2021-7712', 2021, '2021-11-05', 15800.00, 'Compra', 4, 3),
  ('09.001.00', 'Ecografo', 'Diagnostico', 'Em calibracao', 'Alta', 'GE', 'Vivid S70', 'GE Healthcare', 'GE-2019-33201', 2019, '2019-04-22', 65000.00, 'Compra', 5, 4),
  ('05.001.00', 'Cama hospitalar motorizada', 'Reabilitacao', 'Ativo', 'Baixa', 'Stryker', 'S3 Med Surg', 'Stryker Corporation', 'STR-2023-10045', 2023, '2023-01-18', 4500.00, 'Compra', NULL, 2),
  ('08.002.00', 'Electrocardiografo portatil', 'Diagnostico', 'Ativo', 'Alta', 'Schiller', 'Cardiovit AT-102plus', 'Schiller AG', 'SCH-2020-55412', 2020, '2020-07-30', 8900.00, 'Compra', NULL, 4),
  ('07.003.00', 'Autoclave de esterilizacao', 'Esterilizacao', 'Ativo', 'Media', 'Systec', 'VX-150', 'Systec GmbH', 'SYS-2018-22310', 2018, '2018-11-12', 12000.00, 'Compra', NULL, 5);

-- Garantias
INSERT INTO Garantia (codigoEquipamento, dataInicio, dataFim, temContrato, tipoContrato, periodicidade, idFornecedor, numContrato, observacoes) VALUES
  ('04.002.00', '2022-03-15', '2025-03-15', 1, 'Anual', 'Anual', 1, 'CT-2022-0101', 'Contrato inclui pecas e mao de obra'),
  ('06.001.00', '2021-06-20', '2026-06-20', 1, 'Plurianual', 'Semestral', 2, 'CT-2021-0204', 'Manutencao preventiva semestral obrigatoria'),
  ('03.005.00', '2020-09-10', '2023-09-10', 0, NULL, NULL, NULL, NULL, 'Garantia de fabrica expirada, sem contrato ativo'),
  ('02.003.00', '2021-11-05', '2024-11-05', 1, 'Anual', 'Anual', 4, 'CT-2021-0389', NULL),
  ('09.001.00', '2019-04-22', '2024-04-22', 1, 'Plurianual', 'Anual', 5, 'CT-2019-0512', 'Inclui calibracoes anuais certificadas'),
  ('08.002.00', '2020-07-30', '2023-07-30', 0, NULL, NULL, NULL, NULL, NULL);

-- Documentos
INSERT INTO Documento (tipo, nomeDocumento, codigoEquipamento, idFornecedor, dataDocumento, dataValidade, caminhoFicheiro) VALUES
  ('Manual de utilizador', 'Manual Utilizador IntelliVue MP5', '04.002.00', 1, '2022-03-15', NULL, '/documentos/equipamentos/manual_mp5.pdf'),
  ('Manual de servico', 'Manual Servico IntelliVue MP5', '04.002.00', 1, '2022-03-15', NULL, '/documentos/equipamentos/servico_mp5.pdf'),
  ('Certificado de calibracao', 'Certificado Calibracao Evita V500 2024', '06.001.00', 2, '2024-01-10', '2025-01-10', '/documentos/calibracoes/cal_evita_2024.pdf'),
  ('Contrato de manutencao', 'Contrato Manutencao Evita V500 CT-2021-0204', '06.001.00', 2, '2021-06-20', '2026-06-20', '/documentos/contratos/ct2021_0204.pdf'),
  ('Fatura / Guia de aquisicao', 'Fatura Aquisicao Desfibrilhador Zoll', '02.003.00', 4, '2021-11-05', NULL, '/documentos/faturas/fat_zoll_2021.pdf'),
  ('Declaracao de conformidade', 'Declaracao CE Ecografo Vivid S70', '09.001.00', 5, '2019-04-22', NULL, '/documentos/conformidade/ce_vivid_s70.pdf'),
  ('Relatorio tecnico', 'Relatorio Manutencao Bomba Infusao Mar/2024', '03.005.00', 3, '2024-03-15', NULL, '/documentos/relatorios/rel_bomba_mar2024.pdf'),
  ('Certificado de calibracao', 'Certificado Calibracao Ecografo Vivid S70 2024', '09.001.00', 5, '2024-02-20', '2025-02-20', '/documentos/calibracoes/cal_vivid_2024.pdf');
