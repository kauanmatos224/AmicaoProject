package com.example.amicacina;

import android.annotation.SuppressLint;
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

    public void insertData(int id, String nome, String foto, String comportamento, String status, String raca, String porte, String endereco, String nascimento, String favoritado, String idade, String genero){
        ContentValues values;

        db = create_db.getWritableDatabase();
        ContentValues values_sync = new ContentValues();
        values_sync.put("id", id);
        db.insert("tb_sync", null, values_sync);

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
        db.insert("tb_pets", null, values);
    }

    public Cursor retrieveData(){

        Cursor cursor;
        db = create_db.getReadableDatabase();
        String[] fields = {"id", "nome", "foto", "comportamento", "status", "raca", "porte", "endereco", "nascimento", "favoritado", "idade", "genero"};
        cursor = db.query("tb_pets", fields, null, null, null, null, null, null);

        if(cursor!=null){
            cursor.moveToFirst();
        }
        return cursor;
    }

    public void syncData(int id, String nome, String foto, String comportamento, String status, String raca, String porte, String endereco, String nascimento, String favoritado, String idade, String genero){
        db = create_db.getWritableDatabase();
        Cursor cursor;
        cursor = db.rawQuery("select * from tb_pets where id="+id +";", null);
        if(cursor.moveToFirst()){

            Cursor checkChanges = db.rawQuery("select * from tb_pets where id=? and nome <> ? or foto <> ? or comportamento <> ? or status <> ? or raca <> ? or porte <> ? or endereco <>  ? or nascimento <> ? or idade <> ? or genero <> ?",
                    new String[]{String.valueOf(id), nome, foto, comportamento, status, raca, porte, endereco, nascimento, idade, genero});

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

    public void checkLocalDataIntegrity(){
        db = create_db.getWritableDatabase();
        Cursor pets_data = db.rawQuery("select * from tb_pets;", null);
        if(pets_data.moveToFirst()){
            for(int i=0; i< pets_data.getCount(); i++){
                @SuppressLint("Range") String id_pet = pets_data.getString(pets_data.getColumnIndex("id"));
                Cursor checkDeletionNecessity = db.rawQuery("select id from tb_sync where id=?;", new String[]{id_pet});
                if(checkDeletionNecessity.moveToFirst()){
                    continue;
                }
                else{
                    db.execSQL("delete from tb_pets where id=?",new String[]{String.valueOf(id_pet)} );
                }
                pets_data.moveToNext();
            }
        }
    }

    public void refreshSyncData(){
        db = create_db.getWritableDatabase();
        db.execSQL("delete from tb_sync where 1=1");
    }

}
