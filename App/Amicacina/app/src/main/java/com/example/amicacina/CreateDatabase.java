package com.example.amicacina;

//Realiza as importações de bibliotecas necessárias para a execução de métodos da classe.
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class CreateDatabase extends SQLiteOpenHelper {

    //Constantes que carregam as queries a serem executadas ao decorrer da classe, como criação do banco de dados e de suas tabelas.
    private static final String DATABASE_NAME = "db_amicao";
    private static final int DATABASE_VERSION = 1;
    public final String CREATE_TABLE = "create table if not exists tb_pets (id integer primary key, nome text, status text, comportamento text, endereco text, genero text, favoritado text, foto text, raca text, idade text, porte text, nascimento text);";
    public final String CREATE_TABLE_SYNC = "create table if not exists tb_sync(id integer primary key);";
    public final String CREATE_TABLE_SETTINGS = "create table if not exists tb_settings(id integer primary key, refresh_time integer);";

    //Instância a classe.
    public CreateDatabase(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    /*
    Método responsável por criar as tabelas necessárias para o banco de dados na primeira execução do app no
    smartphone do usuário. Bem como, tabelas de pets e de configuração do app.
    */
    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_TABLE); db.execSQL(CREATE_TABLE_SYNC); db.execSQL(CREATE_TABLE_SETTINGS);
    }

    //O método abaixo é responsável por a atualização da estrutura de tabelas no banco de dados.
    //Em caso de necessidades futuras, queries SQL podem ser atribuidas para serem executadas quanto à atualização da base.
    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
    }
}