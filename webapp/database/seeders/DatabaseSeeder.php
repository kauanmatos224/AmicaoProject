<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Seeds institutions and staffs data.
        DB::insert('insert into tb_org (cnpj, cep, endereco, phone, country, nome_fantasia)
            values(?, ?, ?, ?, ?, ?)',
            array(
                '000000000000000000',
                00000000,
                'Rua teste 1, n 2 - Cidade 1, SP - Brazil',
                '+55 (00) 00000-0000',
                'Brazil',
                'Nome Fantasia Teste 0'
            ));

        DB::insert('insert into tb_org (cnpj, cep, endereco, phone, country, nome_fantasia)
            values(?, ?, ?, ?, ?, ?)',
            array(
                '1111111111111111111',
                11111111,
                'Rua teste 1, n 1 - Cidade 1, SP - Brazil',
                '+55 (00) 11111-1111',
                'Brazil',
                'Nome Fantasia Teste 1'
        ));

        DB::insert('insert into tb_org (cnpj, cep, endereco, phone, country, nome_fantasia)
            values(?, ?, ?, ?, ?, ?)',
            array(
                '222222222222222222',
                222222222,
                'Rua teste 2, n 2 - Cidade 2, SP - Brazil',
                '+55 (00) 22222-2222',
                'Brazil',
                'Nome Fantasia Teste 2'
        ));

        DB::insert('insert into tb_org (cnpj, cep, endereco, phone, country, nome_fantasia)
            values(?, ?, ?, ?, ?, ?)',
            array(
                '1111111111111111',
                111111,
                'Rua teste 3, n 3 - Cidade 3, SP - Brazil',
                '+55 (00) 33333-3333',
                'Brazil',
                'Nome Fantasia Teste 3'
        ));

        
        DB::insert('insert into tb_auth_org (id_org, email, password, user_type, status, email_status) values(?, ?, ?, ?, ?, ?)', 
            array(
                1,
                'victorrayansouzaramos@gmail.com',
                'd00a72eea5068b5b0b2a6d001b8aff53955ac2ffdbe0f915d3856ff6275e05e7',
                'inst',
                'approved',
                'verified',
        ));

        DB::insert('insert into tb_auth_org (id_org, email, password, user_type, status, email_status) values(?, ?, ?, ?, ?, ?)', 
            array(
                2,
                'victorrayansouzaramos@yahoo.com.br',
                'd00a72eea5068b5b0b2a6d001b8aff53955ac2ffdbe0f915d3856ff6275e05e7',
                'staff',
                'approved',
                'verified',
        ));

        DB::insert('insert into tb_auth_org (id_org, email, password, user_type, status) values(?, ?, ?, ?, ?)', 
            array(
                3,
                'staff_test_email@yahoo.com.br',
                'd00a72eea5068b5b0b2a6d001b8aff53955ac2ffdbe0f915d3856ff6275e05e7',
                'staff',
                'approved',
        ));

        DB::insert('insert into tb_auth_org (id_org, email, password, user_type, status) values(?, ?, ?, ?, ?)', 
            array(
                4,
                'enriconathanromero@gmail.com',
                'd00a72eea5068b5b0b2a6d001b8aff53955ac2ffdbe0f915d3856ff6275e05e7',
                'staff',
                'approved',
        ));




        //Seeds pets data.
        DB::insert('insert into tb_pets(id_org, nome, raca_pai, raca_mae, raca, nascimento, idade, status, comportamento, genero, img_path, porte, vacinas_essenciais)
        values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
            1,
            'nome pet 1',
            'raca do pai 1',
            'raca da mãe 2',
            'raca do pet 1',
            '0001-11-11 00:00:00',
            11,
            'apadrinhado',
            'calmo',
            'femea',
            '/no-photo.png',
            'pequeno',
            'sim'
        ));


        DB::insert('insert into tb_pets(id_org, nome, raca_pai, raca_mae, raca, nascimento, idade, status, comportamento, genero, img_path, porte, vacinas_essenciais)
        values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
            1,
            'nome pet 2',
            'raca do pai 2',
            'raca da mãe 2',
            'raca do pet 2',
            '0001-11-11 00:00:00',
            10,
            'em_adocao',
            'agressivo',
            'macho',
            '/no-photo.png',
            'grande',
            'não'
        ));

        DB::insert('insert into tb_pets(id_org, nome, raca_pai, raca_mae, raca, nascimento, idade, status, comportamento, genero, img_path, porte, vacinas_essenciais)
        values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
            1,
            'nome pet 3',
            'raca do pai 3',
            'raca da mãe 3',
            'raca do pet 3',
            '0001-11-11 00:00:00',
            13,
            'disponivel',
            'dócil, inteligente...',
            'femea',
            '/no-photo.png',
            'grande',
            'não'
        ));



        //Seeds requests data.
        DB::insert('insert into tb_reqs(id_pet, nome, phone, email, status, req_type, date) values(?, ?, ?, ?, ?, ?, ?)', array(
            1,
            'Victor Rayan',
            '11991226950',
            'victorrayansouzaramos@gmail.com',
            'not_seen',
            'apadrinhamento',
            1664662367
        ));

        DB::insert('insert into tb_reqs(id_pet, nome, phone, email, status, req_type, date) values(?, ?, ?, ?, ?, ?, ?)', array(
            2,
            'Victor Rayan',
            '11991226950',
            'victorrayansouzaramos@gmail.com',
            'answered',
            'apadrinhamento',
            1664662367
        ));

        DB::insert('insert into tb_reqs(id_pet, nome, phone, email, status, req_type, date) values(?, ?, ?, ?, ?, ?, ?)', array(
            3,
            'Victor Rayan',
            '11991226950',
            'victorrayansouzaramos@gmail.com',
            'not_seen',
            'visita',
            1664662367,

        ));


        


        /*DB::insert('insert into tb_auth_org (id_org, email, password, user_type, status) values(?, ?, ?, ?, ?)', 
            array(
                3,
                'inst_test_not_approved@yahoo.com.br',
                'd00a72eea5068b5b0b2a6d001b8aff53955ac2ffdbe0f915d3856ff6275e05e7',
                'inst',
                'denied',
        ));

        DB::insert('insert into tb_auth_org (id_org, email, password, user_type, status) values(?, ?, ?, ?, ?)', 
            array(
                3,
                'inst_test_waiting@yahoo.com.br',
                'd00a72eea5068b5b0b2a6d001b8aff53955ac2ffdbe0f915d3856ff6275e05e7',
                'inst',
                'waiting',
        ));
        */
        
    }
}
