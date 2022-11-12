package com.example.amicacina;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

public class DatabaseController {

    private SQLiteDatabase db;
    private CreateDatabase create_db;

    public DatabaseController(Context context){
        create_db = new CreateDatabase(context);
    }

    public Boolean insertData(int id, String nome, String foto, String comportamento, String status, String raca, String porte, String endereco, String nascimento, String favoritado, String idade, String genero){
        ContentValues values;
        long result;

        db = create_db.getWritableDatabase();
        values = new ContentValues();
        values.put("id", id);
        values.put("nome", nome);
        values.put("foto", foto);
        values.put("comportamento", comportamento);
        values.put("status", status);
        values.put("raca", raca);
        values.put("porte", porte);
        values.put("endereco", endereco);
        values.put("nascimento", nascimento);
        values.put("favoritado", favoritado);
        values.put("idade", idade);
        values.put("genero", genero);
        result = db.insert("tb_pets", null, values);
        db.close();

        if(result==-1){
            return false;
        }
        else{
            return true;
        }

    }

    public Cursor retrieveData(){

        Cursor cursor;
        db = create_db.getReadableDatabase();
        String[] fields = {"id", "nome", "foto", "comportamento", "status", "raca", "porte", "endereco", "nascimento", "favoritado", "idade", "genero"};
        cursor = db.query("tb_pets", fields, null, null, null, null, null, null);

        if(cursor!=null){
            cursor.moveToFirst();
        }
        db.close();
        return cursor;
    }

    public void syncData(int id, String nome, String foto, String comportamento, String status, String raca, String porte, String endereco, String nascimento, String favoritado, String idade, String genero){
        Log.d("id", String.valueOf(id));
        db = create_db.getWritableDatabase();
        Cursor cursor;
        cursor = db.rawQuery("select * from tb_pets where id="+id +";", null);
        if(cursor.moveToFirst()){

            Cursor checkChanges = db.rawQuery("select * from tb_pets where id=? and (nome <> ? or comportamento <> ? or status <> ? or raca <> ? or porte <> ? or endereco <>  ? or nascimento <> ? or idade <> ? or genero <> ?)", null);

            if(checkChanges.moveToFirst()) {
                db.execSQL("update tb_pets " +
                        "set nome=?," +
                        "foto=?," +
                        "comportamento=?," +
                        "status=?," +
                        "raca=?," +
                        "porte=?," +
                        "endereco=?," +
                        "nascimento=?," +
                        "idade=?," +
                        "genero=? " +
                        "where id=? ", new Object[]{nome, foto, comportamento, status, raca, porte, endereco, nascimento, idade, genero, id}
                );
                MainActivity.updated_pets=true;
            }
        }
        else{
            insertData(id, nome, foto, comportamento, status, raca, porte, endereco, nascimento, favoritado, idade, genero);
        }
    }

    public void favPet(int id, String value){
        db = create_db.getWritableDatabase();
        db.execSQL("update tb_pets " +
                "set favoritado=? " +
                "where id=?", new Object[] {value, id});
    }

    public Cursor retrieveFavPets(){
        db = create_db.getReadableDatabase();
        Cursor cursor = db.rawQuery("select * from tb_pets where favoritado=\"true\"", null);
        cursor.moveToNext();
        return cursor;
    }
}
