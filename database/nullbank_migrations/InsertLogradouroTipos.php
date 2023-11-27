<?php

namespace Database\NullBankMigrations;

class InsertLogradouroTipos implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            INSERT INTO logradouro_tipos (nome) VALUES
                ('Aeroporto'),
                ('Alameda'),
                ('Área'),
                ('Avenida'),
                ('Campo'),
                ('Chácara'),
                ('Colônia'),
                ('Condomínio'),
                ('Conjunto'),
                ('Distrito'),
                ('Esplanada'),
                ('Estação'),
                ('Estrada'),
                ('Favela'),
                ('Fazenda'),
                ('Feira'),
                ('Jardim'),
                ('Ladeira'),
                ('Lago'),
                ('Lagoa'),
                ('Largo'),
                ('Loteamento'),
                ('Morro'),
                ('Núcleo'),
                ('Parque'),
                ('Passarela'),
                ('Pátio'),
                ('Praça'),
                ('Quadra'),
                ('Recanto'),
                ('Residencial'),
                ('Rodovia'),
                ('Rua'),
                ('Setor'),
                ('Sítio'),
                ('Travessa'),
                ('Trecho'),
                ('Trevo'),
                ('Vale'),
                ('Vereda'),
                ('Via'),
                ('Viaduto'),
                ('Viela'),
                ('Vila');
        ";
    }
}
