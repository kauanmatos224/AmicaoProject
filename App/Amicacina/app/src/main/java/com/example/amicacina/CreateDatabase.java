package com.example.amicacina;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class CreateDatabase extends SQLiteOpenHelper {

    private static final String DATABASE_NAME = "db_amicao";
    private static final int DATABASE_VERSION = 1;
    public final String CREATE_TABLE = "create table if not exists tb_pets (id integer primary key, nome text, status text, comportamento text, endereco text, genero text, favoritado text, foto text, raca text, idade text, porte text, nascimento text);";
    public final String CREATE_TABLE_SYNC = "create table if not exists tb_sync(id integer primary key);";
    public final String CREATE_TABLE_SETTINGS = "create table if not exists tb_settings(id integer primary key, refresh_time integer);";

    public CreateDatabase(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_TABLE); db.execSQL(CREATE_TABLE_SYNC); db.execSQL(CREATE_TABLE_SETTINGS);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }
}