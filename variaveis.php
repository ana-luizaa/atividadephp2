<?php
class Aluno {
    public $nome;
    public $notas = array();
    public $totalNotas = 0;
    public $media = 0;
    public $status;

    function __construct($nome) {
        $this->nome = $nome;
    }

    public function adicionarNota($nota) {
        if ($nota >= 0 && $nota <= 10) {
            $this->notas[] = $nota;
            $this->calcularTotalEMedia();
        } else {
            echo "Nota inválida! As notas devem estar entre 0 e 10.\n";
        }
    }

    private function calcularTotalEMedia() {
        $this->totalNotas = array_sum($this->notas);
        $this->media = $this->totalNotas / count($this->notas);
        $this->atualizarStatus();
    }

    private function atualizarStatus() {
        if ($this->media < 4) {
            $this->status = "Reprovado";
        } elseif ($this->media >= 4 && $this->media <= 6) {
            $this->status = "Recuperação";
        } else {
            $this->status = "Aprovado";
        }
    }

    public function editarNota($indice, $novaNota) {
        if (isset($this->notas[$indice])) {
            $this->notas[$indice] = $novaNota;
            $this->calcularTotalEMedia();
        } else {
            echo "Índice de nota inválido!\n";
        }
    }

    public function exibirInformacoes() {
        echo "Nome: $this->nome\n";
        echo "Notas: " . implode(", ", $this->notas) . "\n";
        echo "Total de Notas: $this->totalNotas\n";
        echo "Média: $this->media\n";
        echo "Status: $this->status\n";
    }
}

$alunos = array();

function menu() {
    echo "\nMenu:\n";
    echo "1. Cadastrar Aluno\n";
    echo "2. Adicionar Nota\n";
    echo "3. Exibir Informações dos Alunos\n";
    echo "4. Editar Nota\n";
    echo "5. Sair\n";
    echo "Escolha uma opção: ";
}

function cadastrarAluno(&$alunos) {
    if (count($alunos) < 5) {
        echo "Digite o nome do aluno: ";
        $nome = trim(readline());
        $alunos[] = new Aluno($nome);
        echo "Aluno cadastrado com sucesso!\n";
    } else {
        echo "Limite de alunos atingido!\n";
    }
}

function adicionarNota(&$alunos) {
    if (empty($alunos)) {
        echo "Nenhum aluno cadastrado!\n";
        return;
    }

    echo "Digite o nome do aluno: ";
    $nome = trim(readline());
    foreach ($alunos as $aluno) {
        if ($aluno->nome === $nome) {
            echo "Digite a nota (0-10): ";
            $nota = floatval(trim(readline()));
            $aluno->adicionarNota($nota);
            return;
        }
    }
    echo "Aluno não encontrado!\n";
}

function exibirInformacoes($alunos) {
    if (empty($alunos)) {
        echo "Nenhum aluno cadastrado!\n";
        return;
    }

    foreach ($alunos as $aluno) {
        $aluno->exibirInformacoes();
        echo "\n";
    }
}

function editarNota(&$alunos) {
    if (empty($alunos)) {
        echo "Nenhum aluno cadastrado!\n";
        return;
    }

    echo "Digite o nome do aluno: ";
    $nome = trim(readline());
    foreach ($alunos as $aluno) {
        if ($aluno->nome === $nome) {
            echo "Digite o índice da nota a ser editada (0-" . (count($aluno->notas) - 1) . "): ";
            $indice = intval(trim(readline()));
            echo "Digite a nova nota (0-10): ";
            $novaNota = floatval(trim(readline()));
            $aluno->editarNota($indice, $novaNota);
            return;
        }
    }
    echo "Aluno não encontrado!\n";
}

while (true) {
    menu();
    $opcao = trim(readline());

    switch ($opcao) {
        case 1:
            cadastrarAluno($alunos);
            break;
        case 2:
            adicionarNota($alunos);
            break;
        case 3:
            exibirInformacoes($alunos);
            break;
        case 4:
            editarNota($alunos);
            break;
        case 5:
            exit("Saindo...\n");
        default:
            echo "Opção inválida!\n";
    }
}
?>
