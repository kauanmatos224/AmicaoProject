package com.example.amicacina;

//Realiza as importações de bibliotecas necessárias para a execução de métodos da classe.
import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import android.content.Context;
import android.content.Intent;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.gson.JsonArray;
import com.google.gson.JsonNull;
import com.google.gson.JsonObject;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;

//Activity Princpal, classe executada ao inicializar o app.
public class MainActivity extends AppCompatActivity {

    public static final String GET_DATA_URL = "https://amicao.herokuapp.com/application_retrieve/pets";
    public static Fragment selectedFragment = null;
    public static int id_pet;
    public static int pos;
    public static Boolean from_fav;
    public static Boolean null_data;
    public static Boolean null_fav;
    public static Boolean internet_connection;
    public static String first_run;



    //Método responsável por inicializar todas as definições de comportamento da activity toda vez em que a mesma é invocada.
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Oculta elemento visual desnecessário.
        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();

        //Inicializa as variáveos estáticas que definem a forma como o(s) pet(s) será(ão) buscado(s) no banco de dados.
        null_data=false;
        from_fav=false;
        null_fav=false;

        //Realiza o instanciamento como objeto da classe Controller de banco de dados.
        DatabaseController db = new DatabaseController(MainActivity.this);

        //Instancia o BottomNavigationView (barra inferior de navegação).
        BottomNavigationView bottomNavigationview = (BottomNavigationView)findViewById(R.id.bottomNavigationview);


        //Desabilita a barra inferior de navegação enquanto a base de dados não é sincronizada e / ou o fragmento home não é carregado.
        for(int i=0; i<bottomNavigationview.getMenu().size(); i++){
            bottomNavigationview.getMenu().getItem(i).setEnabled(false);
        }

        //Verifica a conectividade do App com a internet.
        //Caso true, realiza a sincronização se for a primeira execuçaõ da activity.
        //Caso false, realiza notifica o usuário e carrega o fragment home com os dados da base local ao invés da base remota.
        ConnectivityManager connectivityManager = (ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        if(connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_MOBILE).getState() == NetworkInfo.State.CONNECTED ||
                connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_WIFI).getState() == NetworkInfo.State.CONNECTED) {
            //we are connected to a network
            internet_connection = true;
        }
        else
            internet_connection = false;

        if(internet_connection) {
            if(db.isRefreshTime() || first_run==null) {
                //Realiza um requisição post para o webserver para obtenção dos dados do pet.
                Ion.with(MainActivity.this)
                        .load(GET_DATA_URL)
                        .asJsonArray()
                        .setCallback(new FutureCallback<JsonArray>() {
                            @Override
                            public void onCompleted(Exception e, JsonArray result) {

                                //Verifica se a requisição teve retorno nulo. Caso true, então o usuário é notificado de que
                                //não há pets na base de dados, e os pets da base local são deletados na sincronização.
                                //Caso false, o fluxo segue normal (a base é sincronizada com os registros obtidos e o fragment home
                                //é alimentado de acordo).
                                if (result.isJsonNull()) {
                                    MainActivity.null_data = true;
                                } else {
                                    MainActivity.null_data = false;
                                    db.refreshSyncData();
                                    for (int i = 0; i < result.size(); i++) {
                                        JsonObject res_json = result.get(i).getAsJsonObject();
                                        Log.d("data", res_json.get("id").getAsString());
                                        String comportamentox, nascimentox;

                                        if (res_json.get("comportamento") == JsonNull.INSTANCE) {
                                            comportamentox = "";
                                        } else {
                                            comportamentox = res_json.get("comportamento").getAsString();
                                        }
                                        if (res_json.get("nascimento") == JsonNull.INSTANCE) {
                                            nascimentox = "";
                                        } else {
                                            nascimentox = res_json.get("nascimento").getAsString();

                                        }

                                        //Realiza a sincronização no banco de dados com os dados obtidos da requisição.
                                        db.syncData(
                                                res_json.get("id").getAsInt(),
                                                res_json.get("nome").getAsString(),
                                                res_json.get("img_path").getAsString(),
                                                comportamentox,
                                                res_json.get("status").getAsString(),
                                                res_json.get("raca").getAsString(),
                                                res_json.get("porte").getAsString(),
                                                res_json.get("endereco").getAsString(),
                                                nascimentox,
                                                "false",
                                                res_json.get("idade").getAsString(),
                                                res_json.get("genero").getAsString()
                                        );

                                        //Realiza o commit (inserção) do fragment na activity principal.
                                        getSupportFragmentManager().beginTransaction()
                                                .replace(R.id.fragment_layout, new fragment_home()).commit();

                                        //Fecha a thread da requisição POST
                                        Ion.getDefault(MainActivity.this).cancelAll(MainActivity.this);
                                        for (int x = 0; x < bottomNavigationview.getMenu().size(); x++) {
                                            bottomNavigationview.getMenu().getItem(x).setEnabled(true);
                                        }
                                    }
                                }

                            }
                        });

                    //Define que a primeira execução da activity já fora realizada.
                    first_run="not";

                    //Atualiza no banco de dados o próximo momento de sincronização dos dados enquanto o app está aberto.
                    db.updateRefreshTime();
            }
        }

        //Realiza o commit (inserção) do fragment na activity principal.
        getSupportFragmentManager().beginTransaction()
                .replace(R.id.fragment_layout, new fragment_home()).commit();


        //Reabilita o menu inferior de navegação. (Ação para evitar erro maligno NullPointException).
        for (int x = 0; x < bottomNavigationview.getMenu().size(); x++) {
            bottomNavigationview.getMenu().getItem(x).setEnabled(true);
        }

        //Caso a requisição realizada anteriormente retornou dados, então os dados obtidos devem ser
        //comparados com os dados da base local para terminar a sincronização.
        if(MainActivity.null_data==false){
            db.checkLocalDataIntegrity();
        }
        //bottom nav
        BottomNavigationView btnNav = findViewById(R.id.bottomNavigationview);
        btnNav.setOnNavigationItemSelectedListener(navListener);

        //setting home fragment as main fragment
        getSupportFragmentManager().beginTransaction()
                .replace(R.id.fragment_layout,new fragment_home()).commit();

    }

    //Define os fragments a serem inseridos de acordo com a opção clicada no menu de navegação.
    public BottomNavigationView.OnNavigationItemSelectedListener navListener = new
            BottomNavigationView.OnNavigationItemSelectedListener() {
                @Override
                public boolean onNavigationItemSelected(@NonNull MenuItem item) {

                    switch (item.getItemId()){
                        case R.id.home:
                            selectedFragment = new fragment_home();
                            break;

                        case R.id.fav:
                            selectedFragment = new fragment_fav();
                            break;

                        case R.id.aboutus:
                            selectedFragment = new fragment_aboutus();
                            break;
                    }

                    //begin transaction
                    getSupportFragmentManager().beginTransaction()
                            .replace(R.id.fragment_layout
                                    ,selectedFragment).commit();
                    return true;
                }
            };

}