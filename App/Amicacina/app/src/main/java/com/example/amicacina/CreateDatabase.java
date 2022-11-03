package com.example.amicacina;
import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class CreateDatabase extends SQLiteOpenHelper {

    private static final String DATABASE_NAME = "db_amicao";
    private static final int DATABASE_VERSION = 1;
    public final String CREATE_TABLE = "create table tb_pets (id integer primary key, nome text, status text, comportamento text, endereco text, genero text, favoritado text, foto text, raca text, idade text, porte text, nascimento text);";
    public CreateDatabase(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_TABLE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("drop table if exists tb_pets;");
        db.execSQL(CREATE_TABLE);
    }
}