package com.example.amicacina;

//Realiza a importação de bibliotecas necessárias para a invocação de métodos na classe.
import android.annotation.SuppressLint;
import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

//Classe responsável por executar todas as operação no banco de dados durante o uso do app.
public class DatabaseController {

    //Objetos privados de banco de dados
    private SQLiteDatabase db;
    private CreateDatabase create_db;

    //Instanciamento da classe Controller.
    public DatabaseController(Context context){
        create_db = new CreateDatabase(context);
    }


    //Método que realiza a inserção de dados relacionado aos pets no banco de dados, após obte-los via requisição POT no webserver.
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


    //Método que realiza uma busca (select) no tabela de pets e retorna todos os registros de pets para serem exibidos.
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

    //Método que realiza a sincronização dos dados locais de pets com os dados remotos.
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

    //Métdo que realiza a atualização na tabela de pets (update) para favoritar ou desfavoritar um pet a depender do seu estado (favoritado?) atual.
    public void favPet(int id, String value){
        db = create_db.getWritableDatabase();
        db.execSQL("update tb_pets " +
                "set favoritado=? " +
                "where id=?", new Object[] {value, id});
    }


    //Método responsável por realizar uma busca no banco de dados por pets favoritados.
    public Cursor retrieveFavPets(){
        db = create_db.getReadableDatabase();
        Cursor cursor = db.rawQuery("select * from tb_pets where favoritado=\"true\"", null);
        cursor.moveToNext();
        return cursor;
    }

    //Método que verifica se os animais na base local ainda existem na base remota e realiza a deleteção dos resgistros inconsistentes.
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

    //Realiza a deleção dos dados da tabela de sincronização dos pets após realizar a sincronização da base.
    public void refreshSyncData(){
        db = create_db.getWritableDatabase();
        db.execSQL("delete from tb_sync where 1=1");
    }

    //Método que verifica se está no momento de realizar novamente a sincronização dos dados da base de dados.
    //(Realiza a sincronização dos dados a cada 10 minutos ou na primeira inicialização do app)
    public boolean isRefreshTime(){
        db = create_db.getWritableDatabase();
        Cursor cursor = db.rawQuery("select refresh_time from tb_settings", null);
        Long tsLong = System.currentTimeMillis()/1000;
        String ts = tsLong.toString();
        int timestamp = Integer.parseInt(ts);
        if(!cursor.moveToFirst()){
            db.execSQL("insert into tb_settings(id, refresh_time)values(1, ?)", new String[]{String.valueOf(timestamp+10*60)});
            db.close();
            return true;
        }
        Cursor cursor_ = db.rawQuery("select refresh_time from tb_settings", null);
        cursor_.moveToFirst();
        @SuppressLint("Range") int refresh_time_ = cursor_.getInt(cursor.getColumnIndex("refresh_time"));

        if(Integer.parseInt(ts) > refresh_time_){
            db.close();
            return true;
        }
        db.close();
        return false;
    }

    //Método que atualiza a tabela de configurações com o timestamp da próxima sincronização.
    public void updateRefreshTime(){
        Long tsLong = System.currentTimeMillis()/1000;
        String ts = tsLong.toString();
        int timestamp = Integer.parseInt(ts);
        db = create_db.getWritableDatabase();
        db.execSQL("update tb_settings set refresh_time=? where id=1", new String[]{String.valueOf(timestamp+10*60)});
        db.close();
    }

}
