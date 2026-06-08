# MedStock — Sistema de Gestão de Inventário Hospitalar

Aplicação web desenvolvida no âmbito da unidade curricular **Sistemas de Informação e Base de Dados Aplicados à Saúde (SIBDAS)** — LEBIOM 2025/2026.

## Autor

- **Gabriel Gonçalves** — 1231236@isep.ipp.pt

## Objetivo

Simular um sistema de gestão do inventário hospitalar de equipamentos médicos, permitindo registar e gerir equipamentos, fornecedores, localizações, garantias e documentação técnica.

## Estrutura de Diretórios

```
SIBDAS_projeto_final/
├── public/                  # Área pública (acessível sem autenticação)
│   ├── index.html           # Página principal pública
│   └── assets/
│       ├── bootstrap/       # Framework Bootstrap
│       ├── css/
│       │   └── 1231236.css  # Estilos da área pública
│       ├── js/
│       │   └── 1231236.js   # Scripts da área pública
│       └── img/             # Imagens
├── private/                 # Área privada (acessível após autenticação)
│   ├── index.html           # Dashboard de gestão
│   ├── assets/
│   │   ├── bootstrap/
│   │   ├── css/
│   │   │   └── 1231236.css  # Estilos da área privada
│   │   ├── js/
│   │   │   └── 1231236.js   # Scripts da área privada
│   │   ├── fontawesome/
│   │   └── img/
│   ├── includes/js/         # Funções JavaScript partilhadas
│   └── views/               # Vistas da área privada
│       ├── equipamentos/    # CRUD equipamentos
│       ├── fornecedores/    # CRUD fornecedores
│       ├── localizacoes/    # CRUD localizações
│       ├── documentos/      # CRUD documentos
│       ├── garantias/       # CRUD garantias
│       └── backoffice/      # Gestão da área pública
├── login/
│   └── login.html           # Página de autenticação
├── MedStock_ISEP.sql        # Script da base de dados MySQL
└── commits.txt              # Histórico de commits Git
```

## Tecnologias utilizadas

- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- Font Awesome 6
- MySQL (base de dados)
- PHP (backend — em desenvolvimento)

## Módulos implementados

| Módulo | Lista | Novo | Detalhes | Editar | Apagar |
|---|:---:|:---:|:---:|:---:|:---:|
| Equipamentos | ✅ | ✅ | ✅ | ✅ | ✅ |
| Fornecedores | ✅ | ✅ | ✅ | ✅ | ✅ |
| Localizações | ✅ | ✅ | — | ✅ | ✅ |
| Documentos | ✅ | ✅ | ✅ | ✅ | ✅ |
| Garantias | ✅ | ✅ | ✅ | ✅ | ✅ |
| Backoffice (área pública) | ✅ | — | — | — | — |
