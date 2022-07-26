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
        // \App\Models\User::factory(10)->create();
        DB::insert('insert into tb_org (cnpj, cep, endereco, phone, country, nome_fantasia)
            values(?, ?, ?, ?, ?, ?)',
            array(
                '000000000000000000',
                00000000,
                'Rua teste, n 0',
                '+55 (00) 00000-0000',
                'Brazil',
                'Nome Fantasia Teste 0'
            ));

        DB::insert('insert into tb_org (cnpj, cep, endereco, phone, country, nome_fantasia)
            values(?, ?, ?, ?, ?, ?)',
            array(
                '1111111111111111111',
                11111111,
                'Rua teste, n 1',
                '+55 (00) 11111-1111',
                'Brazil',
                'Nome Fantasia Teste 1'
        ));

        
        DB::insert('insert into tb_auth_org (id_org, email, password, user_type) values(?, ?, ?, ?)', 
            array(
                1,
                'victorrayansouzaramos@gmail.com',
                'amicao123',
                'inst',
        ));

        DB::insert('insert into tb_auth_org (id_org, email, password, user_type) values(?, ?, ?, ?)', 
            array(
                2,
                'victorrayansouzaramos@yahoo.com.br',
                'amicao123',
                'staff',
        ));

        DB::insert('insert into tb_auth_org (id_org, email, password, user_type) values(?, ?, ?, ?)', 
            array(
                3,
                'staff_test_email@yahoo.com.br',
                'amicao123',
                'staff',
        ));
        
    }
}
