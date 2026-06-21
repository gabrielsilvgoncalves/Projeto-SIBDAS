<?php

function validar_nome(string $nome): array {
    $erros = [];
    if (empty(trim($nome))) {
        $erros[] = "O campo Nome é obrigatório.";
    } elseif (preg_match('/\d/', $nome)) {
        $erros[] = "O campo Nome não pode conter números.";
    }
    return $erros;
}

function validar_designacao(string $designacao): array {
    $erros = [];
    if (empty(trim($designacao))) {
        $erros[] = "O campo Designação é obrigatório.";
    } elseif (preg_match('/\d/', $designacao)) {
        $erros[] = "O campo Designação não pode conter números.";
    }
    return $erros;
}

function validar_obrigatorio(string $valor, string $label): array {
    $erros = [];
    if (empty(trim($valor))) {
        $erros[] = "O campo $label é obrigatório.";
    }
    return $erros;
}

function validar_nif(string $nif): array {
    $erros = [];
    if (empty(trim($nif))) {
        $erros[] = "O campo NIF é obrigatório.";
    } elseif (!preg_match('/^\d{9}$/', $nif)) {
        $erros[] = "O NIF deve ter exatamente 9 dígitos numéricos.";
    }
    return $erros;
}

function validar_email_opcional(string $email): array {
    $erros = [];
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O endereço de email não é válido.";
    }
    return $erros;
}

function validar_telefone_opcional(string $telefone): array {
    $erros = [];
    if (!empty($telefone) && !preg_match('/^9\d{8}$/', $telefone)) {
        $erros[] = "O número de telefone não é válido. Deve começar por 9 e ter 9 dígitos.";
    }
    return $erros;
}

function validar_data_opcional(string $data, string $label): array {
    $erros = [];
    if (!empty($data)) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
            $erros[] = "Formato de $label inválido. Use AAAA-MM-DD.";
        } else {
            $partes = explode('-', $data);
            if (!checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
                $erros[] = "$label inválida.";
            }
        }
    }
    return $erros;
}

function validar_data_obrigatoria(string $data, string $label): array {
    $erros = [];
    if (empty($data)) {
        $erros[] = "O campo $label é obrigatório.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
        $erros[] = "Formato de $label inválido. Use AAAA-MM-DD.";
    } else {
        $partes = explode('-', $data);
        if (!checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
            $erros[] = "$label inválida.";
        }
    }
    return $erros;
}

function validar_data_validade(string $data): array {
    $erros = validar_data_opcional($data, 'Data de Validade');
    if (empty($erros) && !empty($data) && $data < date('Y-m-d')) {
        $erros[] = "A Data de Validade não pode ser anterior à data atual.";
    }
    return $erros;
}
